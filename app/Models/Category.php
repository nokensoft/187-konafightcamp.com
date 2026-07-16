<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'unit',
        'name',
        'description',
    ];

    /**
     * Catalog items that belong to this category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope the query to a single POS unit (gym / store / kitchen).
     */
    public function scopeForUnit(Builder $query, string $unit): Builder
    {
        return $query->where('unit', $unit);
    }

    /**
     * Map this category to the shape the Alpine POS app expects.
     *
     * @return array<string, mixed>
     */
    public function toPosArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description ?: '',
        ];
    }
}
