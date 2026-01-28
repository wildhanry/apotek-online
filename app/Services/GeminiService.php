<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';
    }

    /**
     * Ask Gemini AI a question with pharmacy context
     */
    public function askGemini(string $userMessage): array
    {
        try {
            // Get all products from database
            $products = Product::select('name', 'category', 'price', 'stock', 'description')
                ->where('stock', '>', 0)
                ->get();

            // Format products as JSON string
            $productsJson = json_encode($products->map(function ($product) {
                return [
                    'nama' => $product->name,
                    'kategori' => $product->category,
                    'harga' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                    'stok' => $product->stock,
                    'deskripsi' => $product->description,
                ];
            })->values(), JSON_PRETTY_PRINT);

            // Construct system prompt with pharmacy rules
            $systemPrompt = <<<PROMPT
Kamu adalah **Asisten Apoteker Pintar** untuk Apotek Online.
Kamu harus membantu pelanggan dengan ramah dan profesional dalam Bahasa Indonesia.

**DATA PRODUK TERSEDIA:**
{$productsJson}

**ATURAN PENTING:**
1. **Rekomendasi Obat OTC (Over-the-Counter):**
   - Jika pelanggan mengeluh gejala ringan seperti sakit kepala, flu, batuk, demam, atau masalah kesehatan ringan lainnya, rekomendasikan produk yang sesuai HANYA dari daftar produk di atas.
   - Sebutkan nama produk, harga, dan manfaatnya.
   - Jika produk yang cocok tidak tersedia atau stok habis, katakan dengan jelas: "Maaf, saat ini produk untuk {keluhan} sedang kosong. Silakan coba lagi nanti atau hubungi apoteker kami."
   - JANGAN merekomendasikan produk yang tidak ada di database.

2. **Panduan Resep Dokter:**
   - Jika pelanggan bertanya tentang obat resep atau cara upload resep, jelaskan: "Untuk obat yang memerlukan resep dokter, Anda dapat mengupload foto resep saat proses Checkout. Apoteker kami akan memvalidasi resep Anda sebelum pesanan diproses."

3. **Status Pesanan:**
   - Jika ditanya tentang status pesanan atau tracking, arahkan: "Silakan cek status pesanan Anda di menu 'Riwayat Pesanan' di akun Anda."

4. **Jam Operasional & FAQ:**
   - Jam buka apotek: 08:00 - 22:00 WIB setiap hari.
   - Untuk pertanyaan umum lainnya, jawab dengan ramah dan informatif.

5. **Batasan:**
   - JANGAN memberikan diagnosis medis.
   - JANGAN merekomendasikan dosis obat tanpa resep dokter.
   - Selalu sarankan konsultasi dengan dokter untuk keluhan serius.

**GAYA KOMUNIKASI:**
- Gunakan Bahasa Indonesia yang sopan dan mudah dipahami.
- Gunakan emoji secukupnya untuk kesan ramah (misal: 😊, 💊, 🏥).
- Jawab singkat dan to-the-point.

Sekarang jawab pertanyaan pelanggan berikut:
PROMPT;

            // Combine system prompt with user message
            $fullPrompt = $systemPrompt . "\n\nPertanyaan Pelanggan: " . $userMessage;

            // Make API request to Gemini
            $response = Http::timeout(30)->post($this->apiUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $fullPrompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ],
            ]);

            if ($response->failed()) {
                Log::error('Gemini API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'api_key_exists' => !empty($this->apiKey),
                    'url' => $this->apiUrl
                ]);

                return [
                    'success' => false,
                    'message' => 'Maaf, terjadi kesalahan saat menghubungi AI. Silakan coba lagi. 😔'
                ];
            }

            $data = $response->json();

            // Log successful response for debugging
            Log::info('Gemini API Success', [
                'has_candidates' => isset($data['candidates']),
                'response_structure' => array_keys($data)
            ]);

            // Extract response text
            $aiResponse = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak dapat memproses pertanyaan Anda saat ini.';

            return [
                'success' => true,
                'message' => trim($aiResponse)
            ];

        } catch (\Exception $e) {
            Log::error('Gemini Service Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Maaf, terjadi kesalahan sistem. Silakan coba lagi nanti atau hubungi customer service kami. 🙏'
            ];
        }
    }
}
