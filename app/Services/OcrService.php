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
        
        // Redimensionăm păstrând rezoluția bună
        $img->scale(width: 2000);
        
        // Salvăm temporar
        $tempPath = storage_path('app/temp_' . basename($imagePath));
        $img->save($tempPath, quality: 95);
        
        return $tempPath;
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
            - numar_bon: numărul bonului fiscal
            - data_bon: data în format DD/MM/YYYY
            - cantitate: cantitatea de motorină în litri (doar numărul)
            - valoare: valoarea totală (doar numărul)

            Răspunde doar cu JSON-ul, fără alte explicații.";

            // Apelăm Claude API
            $response = Anthropic::messages()->create([
                'model' => 'claude-3-5-sonnet-20241022',
                'max_tokens' => 1024,
                'messages' => [
                    ['role' => 'user', 'content' => [
                        ['type' => 'text', 'text' => $prompt],
                        ['type' => 'image', 'source' => [
                            'type' => 'base64',
                            'media_type' => 'image/jpeg',
                            'data' => $imageBase64
                        ]]
                    ]]
                ]
            ]);

            // Ștergem fișierul temporar
            if (file_exists($optimizedImagePath)) {
                unlink($optimizedImagePath);
            }

            // Extragem JSON din răspuns
            if (!isset($response->content[0]) || !isset($response->content[0]->text)) {
                throw new \Exception('Răspuns invalid de la Claude API');
            }
            
            $content = $response->content[0]->text;
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
                'cantitate' => $extractedData['cantitate'] ?? 0,
                'valoare' => $extractedData['valoare'] ?? 0,
                'raw_data' => json_encode($response)
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