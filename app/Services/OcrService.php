<?php

namespace App\Services;

use App\Models\Bon;
use App\Models\RezultatOcr;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Anthropic\Laravel\Facades\Anthropic;
use Intervention\Image\Drivers\Gd\Driver;

class OcrService
{
    protected $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    private function optimizeImage($imagePath)
    {
        $img = $this->imageManager->read($imagePath);

        // Optimizări pentru text mai clar
        $img->contrast(20)
            ->brightness(10)
            ->greyscale();

        // Redimensionăm la o dimensiune mai mică dar suficientă pentru OCR
        // De obicei, 1000px lățime e suficientă pentru bonuri
        $img->scale(width: 1000);

        // Salvăm temporar cu o calitate mai mică (75% în loc de 95%)
       
        $tempPath = storage_path('app/temp_' . basename($imagePath));

        // Compresie mai agresivă pentru JPG
        if (
            strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)) === 'jpg' ||
            strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)) === 'jpeg'
        ) {
            $img->save($tempPath, quality: 75, format: 'jpg');
        } else {
            $img->save($tempPath, quality: 75);
        }

        return $tempPath;
    }

    public function optimizeAndStore($uploadedFile)
    {
        $img = $this->imageManager->read($uploadedFile);

        // Redimensionăm direct la upload
        $img->scale(width: 1000)
            ->greyscale();

        // Generăm un nume unic pentru fișier
        $fileName = 'bon_' . uniqid() . '.jpg';
        $path = 'bonuri/' . $fileName;

        // Salvăm direct în storage cu compresie
        $storagePath = storage_path('app/public/' . $path);
        $img->save($storagePath, quality: 75, format: 'jpg');

        return $path;
    }

    public function process(Bon $bon)
    {
        try {
            $imagePath = storage_path('app/public/' . $bon->imagine_path);
            $optimizedImagePath = $this->optimizeImage($imagePath);

            // Convertim imaginea în base64
            $imageBase64 = base64_encode(file_get_contents($optimizedImagePath));

            // Construim promptul pentru Claude
            $prompt = "Analizează acest bon fiscal și extrage următoarele informații în format JSON:
                - furnizor: numele companiei (S.C. ... S.R.L.)
                - numar_bon: numărul tranzacției (format XXXXXXX/X/XXXXXX/XXX care apare după 'NUMAR TRANZACTIE:')
                - data_bon: data în format DD/MM/YYYY
                - cantitate_facturata: cantitatea de motorină în litri (al doilea număr din formatul 'preț x cantitate', de exemplu din '7,33 x 20.48' extrage 20.48)
                
                Răspunde doar cu JSON-ul, fără alte explicații.";

            $response = Anthropic::messages()->create([
                'model' => 'claude-3-5-sonnet-20241022',
                'max_tokens' => 1024,
                'system' => 'You are a helpful assistant that analyzes receipts.',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => [
                            ['type' => 'text', 'text' => $prompt],
                            ['type' => 'image', 'source' => [
                                'type' => 'base64',
                                'media_type' => 'image/jpeg',
                                'data' => $imageBase64
                            ]]
                        ]
                    ]
                ]
            ]);
            // Ștergem fișierul temporar
            if (file_exists($optimizedImagePath)) {
                unlink($optimizedImagePath);
            }

            // Verificăm răspunsul și extragem conținutul
            if (!$response || !isset($response['content'][0]['text'])) {
                throw new \Exception('Răspuns invalid de la Claude API');
            }

            $content = $response['content'][0]['text'];
            $extractedData = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Eroare la decodarea JSON: ' . json_last_error_msg());
            }

            Log::info('Claude Response:', ['data' => $extractedData]);

            // Validăm și formatăm data
            if (isset($extractedData['data_bon'])) {
                $extractedData['data_bon'] = \Carbon\Carbon::createFromFormat('d/m/Y', $extractedData['data_bon'])->format('Y-m-d');
            }

            return RezultatOcr::create([
                'bon_id' => $bon->id,
                'furnizor' => $extractedData['furnizor'] ?? '',
                'numar_bon' => $extractedData['numar_bon'] ?? '',
                'data_bon' => $extractedData['data_bon'] ?? null,
                'cantitate_facturata' => $extractedData['cantitate_facturata'] ?? 0,
                'cantitate_utilizata' => $extractedData['cantitate_facturata'] ?? 0,
                'raw_data' => json_encode($extractedData)
            ]);
        } catch (\Exception $e) {
            Log::error('Claude OCR Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
