<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleAnalyticsService
{
    private mixed $measurementId;

    private mixed $apiSecret;

    public function __construct()
    {
        $this->measurementId = config('services.google.analytics.measurement_id');
        $this->apiSecret = config('services.google.analytics.measurement_api_secret');
    }

    public function sendPurchaseEvent(mixed $clientId, Product $product): void
    {
        $url = 'https://www.google-analytics.com/mp/collect?measurement_id='
            .$this->measurementId
            .'&api_secret='
            .$this->apiSecret;

        $transactionId = uniqid('trans_', true);

        $data = [
            'client_id' => $clientId,
            'events' => [
                [
                    'name' => 'purchase',
                    'params' => [
                        'transaction_id' => $transactionId,
                        'value' => $product->price,
                        'currency' => 'USD',
                        'items' => [
                            [
                                'item_id' => (string) $product->id,
                                'item_name' => $product->name,
                                'price' => $product->price,
                                'quantity' => 1,
                            ],
                        ],
                        'purchase_type' => 'single',
                    ],
                ],
            ],
        ];

        $response = Http::post($url, $data);

        if ($response->failed()) {
            Log::error('Failed to send GA4 event', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        } else {
            Log::info('Successfully sent GA4 event', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        }
    }

    /** @param Collection<int, Product> $products */
    public function sendBulkPurchaseEvent(mixed $clientId, Collection $products): void
    {
        $url = 'https://www.google-analytics.com/mp/collect?measurement_id='
            .$this->measurementId
            .'&api_secret='
            .$this->apiSecret;

        $items = [];

        foreach ($products as $product) {
            $items[] = [
                'item_id' => (string) $product->id,
                'item_name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        $totalValue = $products->sum('price');
        $transactionId = uniqid('trans_', true);

        $data = [
            'client_id' => $clientId,
            'events' => [
                [
                    'name' => 'purchase',
                    'params' => [
                        'transaction_id' => $transactionId,
                        'value' => $totalValue,
                        'currency' => 'USD',
                        'items' => $items,
                        'purchase_type' => 'bulk',
                    ],
                ],
            ],
        ];

        $response = Http::post($url, $data);

        if ($response->failed()) {
            Log::error('Failed to send GA4 bulk purchase event', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        } else {
            Log::info('Successfully sent GA4 bulk purchase event', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        }
    }
}
