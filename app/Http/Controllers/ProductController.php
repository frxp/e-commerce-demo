<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController
{
    public function index(): JsonResponse
    {
        $products = Product::all();

        return response()->json($products);
    }

    public function show(int $id): JsonResponse
    {
        $product = Product::find($id);

        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    public function purchase(int $id): JsonResponse
    {
        $product = Product::find($id);

        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->increment('sales');

        return response()->json([
            'message' => 'Product purchased successfully',
            'sales' => $product->sales,
        ]);
    }

    public function cartPurchase(Request $request): JsonResponse
    {
        $productIds = $request->input('ids', []);

        if (empty($productIds)) {
            return response()->json(['message' => 'No product IDs provided'], 400);
        }

        $products = Product::whereIn('id', $productIds)->get();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'Products not found'], 404);
        }

        foreach ($products as $product) {
            $product->increment('sales');
        }

        return response()->json([
            'message' => 'Products purchased successfully',
            'sales' => $products->pluck('sales', 'id'),
        ]);
    }
}
