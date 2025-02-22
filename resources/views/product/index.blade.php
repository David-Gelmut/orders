@extends('layouts.app')
@section('title','Продукты')
@section('content')
<div class="flex flex-col gap-4 items-center">
    <div class="flex flex-row gap-8 ">
        <a href="{{route('products.create')}}"
           class="mx-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 md:px-5 md:py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Создать продукт</a>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg ml-10">
        @if(count($products) > 0)
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
                            <a href="{{route('products.edit',compact('product'))}}"
                               class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Редатировать</a>
                        </td>
                        <form action="{{route('products.destroy',compact('product'))}}" method="post">
                            @method("DELETE")
                            @csrf
                            <td class="px-6 py-4">
                                <button type="submit"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline cursor-pointer">
                                    Удалить
                                </button>
                            </td>
                        </form>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="my-4 mx-4">
                {{ $products->links() }}
            </div>
        @else
            <div class="mx-auto relative overflow-x-auto shadow-md sm:rounded-lg px-auto p-6 ml-20">
                Нет результатов
            </div>
        @endif
    </div>
</div>
@endsection
