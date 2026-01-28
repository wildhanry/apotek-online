<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Http;

$apiKey = config('services.gemini.api_key');

echo "Testing Gemini API...\n";
echo "API Key: " . substr($apiKey, 0, 10) . "...\n\n";

try {
    $response = Http::timeout(30)->post(
        'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey,
        [
            'contents' => [
                [
                    'parts' => [
                        ['text' => 'Halo, apa kabar?']
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 1024,
            ],
        ]
    );

    echo "Status: " . $response->status() . "\n";
    
    if ($response->successful()) {
        echo "✅ SUCCESS!\n";
        $data = $response->json();
        echo "Response: " . ($data['candidates'][0]['content']['parts'][0]['text'] ?? 'No text') . "\n";
    } else {
        echo "❌ FAILED!\n";
        echo "Error: " . $response->body() . "\n";
    }

} catch (\Exception $e) {
    echo "❌ EXCEPTION: " . $e->getMessage() . "\n";
}
