<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактирование товара') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <h1 class="mb-4">Категории</h1>
                        <ul class="list-group">
                            @foreach ($categories as $category)
                                <li class="list-group-item">
                                    <a href="{{ route('categories.show', $category->id) }}"
                                        class="text-decoration-none">
                                        {{ $category->name }}
                                    </a>
                                    @if ($category->children->isNotEmpty())
                                        <ul class="list-group mt-2">
                                            @foreach ($category->children as $subcategory)
                                                <li class="list-group-item list-group-item-action">
                                                    <a href="{{ route('categories.show', $subcategory->id) }}"
                                                        class="text-decoration-none">
                                                        ---- {{ $subcategory->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
