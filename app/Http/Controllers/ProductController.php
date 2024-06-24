<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        foreach ($products as $product) {
            if (empty($product->slug)) {
                $product->slug = \Illuminate\Support\Str::slug($product->title);
                $product->save();
            }
        }
    
        return response()->json($products);
    }

    public function show($slug)
    {

        $product = Product::where('slug', $slug)->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $categoryId = $product->category_id;

        $similarProducts = Product::where('category_id', $categoryId)
            ->where('id', '!=', $product->id) 
            ->limit(10)
            ->get();

        $product['similar_products'] = $similarProducts;

        return response()->json($product, 200);
    }

    public function allBrands($type)
    {
        return Brand::whereHas('products', function ($query) use ($type) {
            $query->where('type', $type);
        })->orderBy('title')->get();
    }

    public function allCategories($type)
    {
        return Category::whereHas('products', function ($query) use ($type) {
            $query->where('type', $type);
        })->orderBy('title')->get();
    }

    public function search($type, Request $request)
    {

        $query = $request->input('query');
        $brandId = $request->input('brand_id');
        $categoryId = $request->input('category_id');
        $productsQuery = Product::query()->where('type', $type);

        if (!empty($query)) {
            $productsQuery->where('title', 'like', '%' . $query . '%');
        }
        if (!empty($brandId)) {
            $productsQuery->where('brand_id', $brandId);
        }
        if (!empty($categoryId)) {
            $productsQuery->where('category_id', $categoryId);
        }

        return $productsQuery->get();
        
    }

    public function getByType($type, Request $request)
    {
        $perPage = $request->query('perPage', 12);
        $categories = $request->query('categories');
        $brands = $request->query('brands');
        $query = Product::where('type', $type);

        $querySearch = $request->input('query');
        if (!empty($querySearch)) {
            $query->where('title', 'like', '%' . $querySearch . '%');
        }

        if (!empty($categories)) {
            $categories = explode(',', $categories);
            $query->whereIn('category_id', $categories);
        }

        if (!empty($brands)) {
            $brands = explode(',', $brands);
            $query->whereIn('brand_id', $brands);
        }

        $products = $query->paginate($perPage);

        return response()->json([
            'data' => $products->items(),
            'total_pages' => $products->lastPage(),
        ], 200);
    }
}