<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактирование товара') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="container">
                        <form action="{{ route('products.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Название товара -->
                            <div class="mb-6">
                                <label for="name" class="block text-sm font-medium text-gray-700">Название
                                    товара</label>
                                <input type="text"
                                    class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                                    id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Описание -->
                            <div class="mb-6">
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700">Описание</label>
                                <textarea
                                    class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror"
                                    id="description" name="description" rows="3" required>{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Цена -->
                            <div class="mb-6">
                                <label for="price" class="block text-sm font-medium text-gray-700">Цена</label>
                                <input type="number"
                                    class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('price') border-red-500 @enderror"
                                    id="price" name="price" value="{{ old('price', $product->price) }}"
                                    step="0.01" required>
                                @error('price')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Категория -->
                            <div class="mb-6">
                                <label for="category_id"
                                    class="block text-sm font-medium text-gray-700">Категория</label>
                                <select
                                    class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('category_id') border-red-500 @enderror"
                                    id="category_id" name="category_id" required>
                                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Выберите
                                        категорию</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Главное изображение -->
                            <div class="mb-6">
                                <label for="main_image" class="block text-sm font-medium text-gray-700">Главное
                                    изображение</label>
                                <input type="file"
                                    class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('main_image') border-red-500 @enderror"
                                    id="main_image" name="main_image">
                                @if ($product->main_image)
                                    <div class="mt-2">
                                        <img src="{{ asset($product->main_image) }}" style="max-width: 200px"
                                            alt="Текущее изображение">
                                    </div>
                                @endif
                                @error('main_image')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Галерея изображений -->
                            <div class="mb-6">
                                <label for="gallery_images" class="block text-sm font-medium text-gray-700">Галерея
                                    изображений</label>
                                <input type="file"
                                    class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('gallery_images') border-red-500 @enderror"
                                    id="gallery_images" name="gallery_images[]" multiple>
                                <div class="mt-2 grid grid-cols-2 gap-2">
                                    @if (!empty($product->galleryImages))
                                        @foreach ($product->galleryImages as $image)
                                            <div class="w-24 h-24 bg-gray-100 rounded-md overflow-hidden">
                                                <img src="{{ asset($image->path) }}" class="w-full h-full object-cover"
                                                    alt="Галерея">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                @error('gallery_images')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Кнопка сохранения -->
                            <div class="mt-6">
                                <button type="submit"
                                    class="w-full py-2 px-4 bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    Сохранить изменения
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
