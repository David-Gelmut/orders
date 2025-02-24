<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'created_date', 'status', 'comment', 'product_id'];
    protected $casts = [
        'created_date' => 'datetime',
    ];

    public function orderItems(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalOrderPrice(): float
    {
        return $this->orderItems()
            ->with('product')
            ->get()
            ->map(function ($item) {
                return $item->product->price * $item->product_count;
            })->sum();
    }

    public function getProducts(): Collection
    {
        return $this->orderItems()
            ->with('product')
            ->get()
            ->pluck('product');
    }

    public function getProductCount(int $productId): int
    {
        return $this->orderItems()
            ->where('product_id', $productId)
            ->value('product_count');
    }
}
