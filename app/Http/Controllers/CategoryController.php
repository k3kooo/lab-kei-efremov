<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('products.categories', compact('categories'));
    }
    public function show(Category $category)
    {
         if ($category->children->isNotEmpty()) {
            $productIds = [];
            foreach ($category->children as $subcategory) {
                $productIds = array_merge($productIds, Product::where('category_id', $subcategory->id)->pluck('id')->toArray());
            }
           $products = Product::whereIn('id', $productIds)->with('category')->get();
        } else {
            $products = Product::where('category_id', $category->id)->with('category')->get();
        }

        return view('products.index', compact('category', 'products'));
    }
}
