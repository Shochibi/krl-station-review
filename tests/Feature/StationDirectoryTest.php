<?php

namespace Tests\Feature;

use App\Models\Review;
use App\Models\Station;
use App\Models\User;
use Database\Seeders\StationSeeder;
use Tests\TestCase;

class StationDirectoryTest extends TestCase
{
    public function test_dashboard_renders_user_commuter_summary(): void
    {
        $user = User::factory()->create();
        $station = Station::create([
            'name' => 'Manggarai',
            'code' => 'MRI',
            'line_name' => 'Lin Bogor',
            'city' => 'Jakarta Selatan',
            'is_active' => true,
        ]);

        $station->reviews()->create([
            'user_id' => $user->id,
            'rating' => 5,
            'category' => 'Fasilitas',
            'content' => 'Stasiun transit sangat ramai saat jam kerja.',
            'is_private' => false,
        ]);

        $station->reviews()->create([
            'user_id' => $user->id,
            'rating' => null,
            'category' => 'Tips Transit',
            'content' => 'Naik gerbong 4 agar dekat eskalator.',
            'is_private' => true,
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Komuter')
            ->assertSee('1 Ulasan')
            ->assertSee('1 Catatan')
            ->assertSee('Manggarai');
    }

    public function test_directory_filters_and_sorts_by_rating_with_unrated_last(): void
    {
        $unrated = Station::create([
            'name' => 'Alpha Tanpa Rating',
            'code' => 'ATR',
            'line_name' => 'Lin Bogor',
            'city' => 'Jakarta Pusat',
            'is_transit' => false,
            'is_active' => true,
        ]);

        $rated = Station::create([
            'name' => 'Zeta Berbintang',
            'code' => 'ZBB',
            'line_name' => 'Lin Bogor',
            'city' => 'Jakarta Selatan',
            'is_transit' => true,
            'is_active' => true,
        ]);

        $user = User::factory()->create();
        $rated->reviews()->create([
            'user_id' => $user->id,
            'rating' => 4,
            'category' => 'Fasilitas',
            'content' => 'Fasilitas lengkap dan nyaman.',
            'is_private' => false,
        ]);

        $response = $this->get(route('home', ['sort' => 'rating']));
        $response->assertOk();
        $response->assertSeeInOrder([$rated->name, $unrated->name]);

        $this->get(route('home', ['search' => 'ZBB', 'transit' => '1']))
            ->assertOk()
            ->assertSee($rated->name)
            ->assertDontSee($unrated->name);
    }

    public function test_inactive_station_returns_not_found_on_show_and_review_store(): void
    {
        $user = User::factory()->create();
        $inactive = Station::create([
            'name' => 'Stasiun Nonaktif',
            'code' => 'NON',
            'line_name' => 'Lin Bogor',
            'city' => 'Jakarta',
            'is_active' => false,
        ]);

        $this->get(route('stations.show', $inactive))->assertNotFound();

        $this->actingAs($user)
            ->post(route('reviews.store', $inactive), [
                'rating' => 5,
                'category' => 'Fasilitas',
                'content' => 'Mencoba ulas stasiun nonaktif.',
                'is_private' => '0',
            ])
            ->assertNotFound();
    }

    public function test_user_can_create_public_review_and_private_note_and_filter_them(): void
    {
        $user = User::factory()->create();
        $station = Station::create([
            'name' => 'Sudirman',
            'code' => 'SUD',
            'line_name' => 'Lin Cikarang',
            'city' => 'Jakarta Pusat',
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->post(route('reviews.store', $station), [
                'rating' => 5,
                'category' => 'Kuliner',
                'content' => 'Banyak pilihan kopi di terowongan Kendal.',
                'is_private' => '0',
            ])
            ->assertRedirect(route('stations.show', $station));

        $this->actingAs($user)
            ->post(route('reviews.store', $station), [
                'rating' => 5,
                'category' => 'Tips Transit',
                'content' => 'Parkir motor terdekat di pintu barat.',
                'is_private' => '1',
            ])
            ->assertRedirect(route('stations.show', $station));

        $this->assertDatabaseHas('reviews', [
            'station_id' => $station->id,
            'user_id' => $user->id,
            'is_private' => false,
            'rating' => 5,
            'category' => 'Kuliner',
        ]);

        $this->assertDatabaseHas('reviews', [
            'station_id' => $station->id,
            'user_id' => $user->id,
            'is_private' => true,
            'rating' => null,
            'category' => 'Tips Transit',
        ]);

        $this->get(route('stations.show', ['station' => $station, 'category' => 'Fasilitas']))
            ->assertOk()
            ->assertDontSee('Banyak pilihan kopi di terowongan Kendal.');

        $this->get(route('stations.show', ['station' => $station, 'category' => 'Kuliner']))
            ->assertOk()
            ->assertSee('Banyak pilihan kopi di terowongan Kendal.');

        $this->actingAs($user)
            ->get(route('reviews.my-notes', ['search' => 'pintu barat']))
            ->assertOk()
            ->assertSee('Parkir motor terdekat di pintu barat.');

        $this->actingAs($user)
            ->get(route('reviews.my-notes', ['category' => 'Kebersihan']))
            ->assertOk()
            ->assertDontSee('Parkir motor terdekat di pintu barat.');
    }

    public function test_admin_cannot_edit_another_users_public_review_but_can_delete_it(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $author = User::factory()->create();
        $station = Station::create([
            'name' => 'Tanah Abang',
            'code' => 'THB',
            'line_name' => 'Lin Cikarang',
            'city' => 'Jakarta Pusat',
            'is_active' => true,
        ]);

        $review = Review::create([
            'station_id' => $station->id,
            'user_id' => $author->id,
            'rating' => 3,
            'category' => 'Keramaian',
            'content' => 'Sangat padat di jam pulang kantor.',
            'is_private' => false,
        ]);

        $this->actingAs($admin)
            ->get(route('reviews.edit', $review))
            ->assertForbidden();

        $this->actingAs($admin)
            ->put(route('reviews.update', $review), [
                'rating' => 5,
                'category' => 'Keramaian',
                'content' => 'Diubah oleh admin.',
            ])
            ->assertForbidden();

        $this->actingAs($admin)
            ->delete(route('reviews.destroy', $review))
            ->assertRedirect(route('stations.show', $station));

        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }

    public function test_station_seeder_is_idempotent_and_seeds_100_active_stations(): void
    {
        $this->seed(StationSeeder::class);
        $this->seed(StationSeeder::class);

        $this->assertSame(100, Station::count());
        $this->assertSame(100, Station::active()->count());
        $this->assertSame(100, Station::whereNotNull('image_url')->count());
        $this->assertSame(7, Station::active()->distinct('line_name')->count('line_name'));

        $firstStation = Station::orderBy('name')->first();
        $this->get(route('home'))
            ->assertOk()
            ->assertSee($firstStation->image_url);
    }
}
