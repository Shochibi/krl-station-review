<?php

namespace Tests\Feature;

use App\Models\Review;
use App\Models\Station;
use App\Models\User;
use Tests\TestCase;

class ReviewManagementTest extends TestCase
{
    private function createStation(): Station
    {
        return Station::create([
            'name' => 'Stasiun Uji',
            'code' => 'UTS',
            'line_name' => 'Lin Uji',
            'city' => 'Jakarta',
            'is_active' => true,
        ]);
    }

    private function createReview(User $user, Station $station, bool $isPrivate = false): Review
    {
        return $station->reviews()->create([
            'user_id' => $user->id,
            'rating' => $isPrivate ? null : 4,
            'category' => 'Fasilitas',
            'content' => $isPrivate ? 'Catatan untuk saya' : 'Ulasan untuk semua',
            'is_private' => $isPrivate,
        ]);
    }

    public function test_owner_can_edit_and_update_their_public_review(): void
    {
        $user = User::factory()->create();
        $station = $this->createStation();
        $review = $this->createReview($user, $station);

        $this->actingAs($user)
            ->get(route('reviews.edit', $review))
            ->assertOk()
            ->assertSee('Edit Ulasan Stasiun');

        $this->actingAs($user)
            ->put(route('reviews.update', $review), [
                'rating' => 5,
                'category' => 'Kebersihan',
                'content' => 'Ulasan yang sudah diperbarui',
                'is_private' => '0',
            ])
            ->assertRedirect(route('stations.show', $station));

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'rating' => 5,
            'category' => 'Kebersihan',
            'content' => 'Ulasan yang sudah diperbarui',
        ]);
    }

    public function test_users_cannot_edit_or_delete_another_users_private_note(): void
    {
        $author = User::factory()->create();
        $otherUser = User::factory()->create();
        $station = $this->createStation();
        $note = $this->createReview($author, $station, true);

        $this->actingAs($otherUser)
            ->get(route('reviews.edit', $note))
            ->assertForbidden();

        $this->actingAs($otherUser)
            ->delete(route('reviews.destroy', $note))
            ->assertForbidden();

        $this->assertDatabaseHas('reviews', ['id' => $note->id]);
    }

    public function test_private_notes_are_only_shown_to_their_owner(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $station = $this->createStation();
        $note = $this->createReview($owner, $station, true);

        $this->get(route('stations.show', $station))
            ->assertDontSee($note->content);

        $this->actingAs($owner)
            ->get(route('stations.show', $station))
            ->assertSee($note->content);

        $this->actingAs($otherUser)
            ->get(route('reviews.my-notes'))
            ->assertDontSee($note->content);
    }

    public function test_admin_cannot_read_or_manage_private_notes(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $owner = User::factory()->create();
        $station = $this->createStation();
        $note = $this->createReview($owner, $station, true);

        $this->actingAs($admin)
            ->get(route('reviews.edit', $note))
            ->assertForbidden();

        $this->actingAs($admin)
            ->delete(route('reviews.destroy', $note))
            ->assertForbidden();

        $this->assertDatabaseHas('reviews', ['id' => $note->id]);
    }

    public function test_editing_a_private_note_cannot_publish_it(): void
    {
        $owner = User::factory()->create();
        $station = $this->createStation();
        $note = $this->createReview($owner, $station, true);

        $this->actingAs($owner)
            ->put(route('reviews.update', $note), [
                'rating' => 5,
                'category' => 'Tips Transit',
                'content' => 'Catatan pribadi diperbarui',
                'is_private' => '0',
            ])
            ->assertRedirect(route('reviews.my-notes'));

        $this->assertDatabaseHas('reviews', [
            'id' => $note->id,
            'is_private' => true,
            'rating' => null,
            'content' => 'Catatan pribadi diperbarui',
        ]);
    }

    public function test_admin_can_delete_a_public_review(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $author = User::factory()->create();
        $station = $this->createStation();
        $review = $this->createReview($author, $station);

        $this->actingAs($admin)
            ->delete(route('reviews.destroy', $review))
            ->assertRedirect(route('stations.show', $station));

        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }

    public function test_directory_uses_active_stations_and_current_counts(): void
    {
        $active = $this->createStation();
        $inactive = $this->createStation();
        $inactive->update(['name' => 'Stasiun Nonaktif', 'is_active' => false]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('1 Stasiun Aktif di Direktori')
            ->assertSee('50% dari 2 tercatat')
            ->assertSee($active->name)
            ->assertDontSee($inactive->name);
    }

    public function test_station_page_shows_optional_access_and_map_data(): void
    {
        $station = $this->createStation();
        $station->update([
            'latitude' => -6.175392,
            'longitude' => 106.827153,
            'facilities' => ['Toilet'],
            'accessibility' => ['Lift'],
            'transit_connections' => ['Transjakarta'],
        ]);

        $this->get(route('stations.show', $station))
            ->assertOk()
            ->assertSee('Toilet')
            ->assertSee('Aksesibilitas')
            ->assertSee('Lift')
            ->assertSee('Koneksi Antarmoda')
            ->assertSee('Transjakarta')
            ->assertSee('openstreetmap.org/?mlat=');
    }
}
