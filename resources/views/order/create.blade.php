@extends('layouts.app')
@section('title','Create order')
@section('content')
    <form action="{{route('orders.store')}}" method="post" class="max-w-sm mx-auto">
        @csrf
        <div class="mb-5">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ФИО покупателя</label>
            <input value="{{old('name')}}" name="name" type="text" id="name"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('name') border-red-500 @enderror"
                   placeholder="Петров Пётр Петрович"/>
            @error('name')<div class="text-red-900">{{ $message }}</div>@enderror
        </div>
        <div class="mb-5">
            <label for="comment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Комментарий покупателя</label>
            <textarea name="comment"  id="comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('comment') border-red-500 @enderror" placeholder="Напишите хоть что-то">{{old('comment')}}</textarea>
            @error('comment')<div class="text-red-900">{{ $message }}</div>@enderror
        </div>
        <div class="mb-5">
            <label for="created_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Дата создания</label>
            <input value="{{old('created_date')}}" name="created_date" type="text" id="created_date"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('created_date') border-red-500 @enderror"
                   placeholder="2025-01-24"/>
            @error('created_date')<div class="text-red-900">{{ $message }}</div>@enderror
        </div>
        <div class="mb-5">
            <label for="product_ids" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Выберите товар(можно выбрать несколько)</label>
            <select multiple name="product_ids[]"  id="product_ids" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('product_ids') border-red-500 @enderror">
                @php
                    $products = \App\Models\Product::all();
                @endphp
                @foreach($products as $product)
                    <option value="{{$product->id}}">{{$product->title}}</option>
                @endforeach
            </select>
            @error('product_ids')<div class="text-red-900">{{ $message }}</div>@enderror
        </div>
        <div class="mb-5">
            <label for="number-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Количество каждого выбранного товара</label>
            <input value="{{old('product_count')}}" name="product_count" type="text" id="number-input" aria-describedby="helper-text-explanation" class="@error('comment') border-red-500 @enderror bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="1000"/>
            @error('product_count')<div class="text-red-900">{{ $message }}</div>@enderror
        </div>
        <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Создать
        </button>
    </form>
@endsection
