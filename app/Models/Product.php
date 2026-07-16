<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'unit',
        'category_id',
        'name',
        'price',
        'stock',
        'emoji',
        'discount_type',
        'discount_value',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'stock' => 'integer',
            'discount_value' => 'integer',
        ];
    }

    /**
     * The price after applying this product's discount (never below zero).
     */
    public function finalPrice(): int
    {
        $price = (int) $this->price;
        $value = (int) $this->discount_value;

        if ($this->discount_type === 'percent') {
            return max(0, (int) round($price * (100 - min(100, $value)) / 100));
        }

        if ($this->discount_type === 'amount') {
            return max(0, $price - $value);
        }

        return $price;
    }

    /**
     * Whether an active discount actually lowers the price.
     */
    public function hasDiscount(): bool
    {
        return $this->discount_type !== null
            && (int) $this->discount_value > 0
            && $this->finalPrice() < (int) $this->price;
    }

    /**
     * The category this catalog item belongs to (may be null).
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope the query to a single POS unit (gym / store / kitchen).
     */
    public function scopeForUnit(Builder $query, string $unit): Builder
    {
        return $query->where('unit', $unit);
    }

    /**
     * Map this item to the shape the Alpine POS app expects for its catalog.
     *
     * @return array<string, mixed>
     */
    public function toPosArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cat' => $this->category?->name ?? '',
            'price' => $this->price,
            'stock' => $this->stock,
            'emoji' => $this->emoji ?: '',
            'discountType' => $this->discount_type,
            'discountValue' => (int) $this->discount_value,
            'finalPrice' => $this->finalPrice(),
            'hasDiscount' => $this->hasDiscount(),
        ];
    }
}
