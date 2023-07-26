<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Product Service
 * @author IR Salvador
 * @since 2023.07.26
 */
class ProductService
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getProducts(Request $request)
    {
        $searchQuery = $request->query('search');

        return Product::when($searchQuery, function ($query, $searchQuery) {
            $query->where('name', 'like', '%' . $searchQuery . '%')
                ->orWhere('description', 'like', '%' . $searchQuery . '%');
        })->paginate(10);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function saveProduct(Request $request)
    {
        $request->validate([
            'name'        => 'required|string',
            'description' => 'required|string',
            'price'       => 'required|numeric'
        ]);

        Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price
        ]);
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return void
     */
    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string',
            'description' => 'required|string',
            'price'       => 'required|numeric'
        ]);

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price
        ]);
    }

    /**
     * @param Product $product
     * @return void
     */
    public function deleteProduct(Product $product)
    {
        $product->delete();
    }
}
