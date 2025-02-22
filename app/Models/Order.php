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

    public function orderItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalOrderPrice(): float
    {
        $totalPrice = 0;

        foreach ($this->getProducts() as $product) {
            $priceProduct = $product->price;
            $countProduct = $this->getProductCount($product->id);

            $totalPrice+=$priceProduct*$countProduct;
        }
        return $totalPrice;
    }

    public function getProducts(): Collection
    {
        return OrderItem::query()
            ->where('order_id', $this->id)
            ->with('product')
            ->get()
            ->pluck('product');
    }

    public function getProductCount(int $productId): int
    {
        return ($this->orderItems()
            ->where('product_id', $productId)
            ->value('product_count'));
    }
}
