<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeCountProductRequest;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::query()->with('category')->paginate(10);
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCreateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        Product::query()->create($data);
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        if($product->update($data)){
            return redirect()->route('products.show',compact('product'))->with('success','Товар обновлен!');
        }
        return redirect()->route('products.show',compact('product'))->with('error','Не удалось обновить товар!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        if($product->delete()){
            return redirect()->route('products.index')->with('success','Товар удалён!');
        }
        return redirect()->route('products.index')->with('error','Ошибка удаления товара!');
    }

    public function changeCountProduct(ChangeCountProductRequest $request, Product $product, Order $order): RedirectResponse
    {
        $data = $request->validated();

        $orderItem = $order->orderItems()
            ->where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->first();
        if ($orderItem) {
            $orderItem->product_count = $data['product_count'];
            $orderItem->save();
            return redirect()->route('orders.show', ['order' => $order])->with('success','Количество товара в заказе изменено!');
        }

        return redirect()->route('orders.show', ['order' => $order])->with('error','Не удалось изменить количество товара!');
    }
}
