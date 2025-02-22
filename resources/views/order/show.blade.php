@extends('layouts.app')
@section('title','Заказ №'.$order->id)
@section('content')
    <div class="container">
        <div class="max-w-xl mx-auto">
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Номера заказа
                    (ID)</label>
                <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    {{$order->id}}
                </div>
            </div>
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ФИО покупателя</label>
                <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    {{$order->name}}
                </div>
            </div>
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Комментарий покупателя</label>
                <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    {{$order->comment}}
                </div>
            </div>
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Итоговая цена</label>
                <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    {{$order->getTotalOrderPrice()}}
                </div>
            </div>
            <form action="{{route('order.change_status',$order)}}" method="post">
                @csrf
                <div class="mb-5">
                    <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Статус
                        заказа</label>
                    <select name="status" id="status"
                            class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('status') border-red-500 @enderror">
                        @php
                            $statuses = \App\Models\Enums\Status::cases();
                        @endphp
                        @foreach($statuses as $status)
                            <option @if($status->value == $order->status) selected @endif value="{{$status->value}}">{{$status->getStatusName()}}</option>
                        @endforeach
                    </select>
                    @error('status')
                    <div class="text-red-900">{{ $message }}</div>@enderror
                </div>
                <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Сменить статус
                </button>
            </form>
        </div>
        @php
            $productsAll = \App\Models\Product::all();
        @endphp
        @if(count($productsAll) > 0)

            <div class="mx-auto max-w-xl relative overflow-x-auto shadow-md sm:rounded-lg px-auto p-6 mt-10 ml-20">
                <form action="{{route('order.bind_product',compact('order'))}}" method="post">
                    @csrf
                    <div class="mb-5">
                        <label for="product_ids" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Товар</label>
                        <select multiple name="product_ids[]"  id="product_ids" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('product_ids') border-red-500 @enderror">
                            @foreach($productsAll as $product)
                                <option value="{{$product->id}}">{{$product->title}}</option>
                            @endforeach
                        </select>
                        @error('product_ids')<div class="text-red-900">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Привязать товары
                    </button>
                </form>
            </div>
        @endif
        <div class="flex flex-col gap-4">
            <div class="mx-auto max-w-xl mb-10 mt-10">
                <div   class="font-bold text-3xl" >Связанные товары</div>
            </div>
            @if(count($products) > 0)
                <div class="mx-auto relative overflow-x-auto shadow-md sm:rounded-lg ml-20">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Название
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Категория
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Цена
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Количество в заказе
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Сумма в заказе
                            </th>
                            <th scope="col" class="px-6 py-3">
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$product->id}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a href="{{route('products.show',compact('product'))}}"> {{$product->title}}</a>
                                </th>
                                <td class="px-6 py-4">
                                    {{$product->category->title}}
                                </td>
                                <td class="px-6 py-4">
                                    {{number_format($product->price, 2, '.', '') }}
                                </td>
                                <td class="px-6 py-4">
                                    <form id="change-count-{{$product->id}}" action="{{route('products.change_count',compact('product','order'))}}" method="post" class="max-w-xs mx-auto">
                                        @csrf
                                        <div class="relative flex items-center max-w-[11rem]">
                                            <button type="submit" id="decrement-button-{{$product->id}}" data-input-counter-decrement="bedrooms-input-{{$product->id}}" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                                </svg>
                                            </button>
                                            <input name="product_count" value="{{$order->getProductCount($product->id)}}" type="text" id="bedrooms-input-{{$product->id}}" data-input-counter data-input-counter-min="1" data-input-counter-max="1000" aria-describedby="helper-text-explanation" class="bg-gray-50 border-x-0 border-gray-300 h-11 font-medium text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full pb-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" />
                                            <button type="submit" id="increment-button-{{$product->id}}" data-input-counter-increment="bedrooms-input-{{$product->id}}" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    {{$order->getProductCount($product->id)*$product->price}}
                                </td>
                                <form action="{{route('order.delete_bind_product',compact('order'))}}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}"/>
                                    <td class="px-6 py-4">
                                        <button type="submit"
                                                class="font-medium text-red-600 dark:text-red-500 hover:underline cursor-pointer">
                                            Отвязать
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mx-auto relative overflow-x-auto shadow-md sm:rounded-lg px-auto p-6 ml-20">
                    Нет результатов
                </div>
            @endif

        </div>
    </div>
@endsection
