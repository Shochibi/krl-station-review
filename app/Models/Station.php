<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Station extends Model
{
    protected $fillable = [
        'name',
        'code',
        'line_name',
        'city',
        'is_transit',
        'facilities',
        'description',
        'image_url',
    ];

    protected $casts = [
        'is_transit' => 'boolean',
        'facilities' => 'array',
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function publicReviews(): HasMany
    {
        return $this->reviews()
            ->where('is_private', false);
    }

    /**
     * Line styling metadata (color, code, border, bg classes)
     */
    public function getLineMetaAttribute(): array
    {
        return match ($this->line_name) {
            'Lin Bogor' => [
                'color' => '#dc2626',
                'name_short' => 'Bogor Line',
                'badge_bg' => 'bg-red-50 text-red-700 border-red-200',
                'stripe' => 'bg-red-600',
                'dot' => 'bg-red-500',
                'hex' => '#dc2626',
                'code' => 'B',
            ],
            'Lin Cikarang' => [
                'color' => '#2563eb',
                'name_short' => 'Cikarang Line',
                'badge_bg' => 'bg-blue-50 text-blue-700 border-blue-200',
                'stripe' => 'bg-blue-600',
                'dot' => 'bg-blue-500',
                'hex' => '#2563eb',
                'code' => 'C',
            ],
            'Lin Rangkasbitung' => [
                'color' => '#16a34a',
                'name_short' => 'Rangkas Line',
                'badge_bg' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'stripe' => 'bg-emerald-600',
                'dot' => 'bg-emerald-500',
                'hex' => '#16a34a',
                'code' => 'R',
            ],
            'Lin Tangerang' => [
                'color' => '#92400e',
                'name_short' => 'Tangerang Line',
                'badge_bg' => 'bg-amber-50 text-amber-800 border-amber-300',
                'stripe' => 'bg-amber-700',
                'dot' => 'bg-amber-600',
                'hex' => '#b45309',
                'code' => 'T',
            ],
            'Lin Tanjung Priok' => [
                'color' => '#db2777',
                'name_short' => 'Tj. Priok Line',
                'badge_bg' => 'bg-pink-50 text-pink-700 border-pink-200',
                'stripe' => 'bg-pink-600',
                'dot' => 'bg-pink-500',
                'hex' => '#db2777',
                'code' => 'TP',
            ],
            'Lin Bandara Soekarno-Hatta' => [
                'color' => '#0891b2',
                'name_short' => 'Basoetta Line',
                'badge_bg' => 'bg-cyan-50 text-cyan-800 border-cyan-300',
                'stripe' => 'bg-cyan-600',
                'dot' => 'bg-cyan-500',
                'hex' => '#0891b2',
                'code' => 'A',
            ],
            'Lin Yogyakarta-Solo' => [
                'color' => '#d97706',
                'name_short' => 'Yogya-Solo Line',
                'badge_bg' => 'bg-yellow-50 text-yellow-800 border-yellow-300',
                'stripe' => 'bg-yellow-600',
                'dot' => 'bg-yellow-500',
                'hex' => '#d97706',
                'code' => 'Y',
            ],
            default => [
                'color' => '#475569',
                'name_short' => $this->line_name,
                'badge_bg' => 'bg-slate-100 text-slate-700 border-slate-200',
                'stripe' => 'bg-slate-600',
                'dot' => 'bg-slate-500',
                'hex' => '#475569',
                'code' => 'CL',
            ],
        };
    }
}
