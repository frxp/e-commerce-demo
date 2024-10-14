<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\GoogleAnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController
{
    private GoogleAnalyticsService $googleAnalyticsService;

    public function __construct(GoogleAnalyticsService $googleAnalyticsService)
    {
        $this->googleAnalyticsService = $googleAnalyticsService;
    }

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

    public function purchase(Request $request, int $id): JsonResponse
    {
        $clientId = $request->input('client_id');
        $product = Product::find($id);

        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->increment('sales');

        $this->googleAnalyticsService->sendPurchaseEvent($clientId, $product);

        return response()->json([
            'message' => 'Product purchased successfully',
            'sales' => $product->sales,
        ]);
    }

    public function cartPurchase(Request $request): JsonResponse
    {
        $clientId = $request->input('client_id');
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

        $this->googleAnalyticsService->sendBulkPurchaseEvent($clientId, $products);

        return response()->json([
            'message' => 'Products purchased successfully',
            'sales' => $products->pluck('sales', 'id'),
        ]);
    }
}
