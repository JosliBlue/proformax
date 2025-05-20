<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company = Auth::user()->company ?? Company::default();
        return view("_admin.settings", compact('company'));
    }

    /**
     * Update the company settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_primary_color' => 'required|string|max:7',
            'company_secondary_color' => 'required|string|max:7',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ]);

        $company = Auth::user()->company;

        if (!$company) {
            $company = new Company();
            $company->save();

            $user = Auth::user();
            $user->company_id = $company->id;
            $user->save();
        }

        $company->company_name = $request->company_name;
        $company->company_primary_color = $request->company_primary_color;
        $company->company_secondary_color = $request->company_secondary_color;
        $company->company_primary_text_color = $this->getContrastColor($request->company_primary_color);
        $company->company_secondary_text_color = $this->getContrastColor($request->company_secondary_color);

        // Procesar logo si se ha subido uno nuevo
        if ($request->hasFile('company_logo')) {
            try {
                if ($company->company_logo_path && $company->company_logo_path !== 'companies/_01_proformax.webp') {
                    Storage::disk('public')->delete($company->company_logo_path);
                }

                $image = $request->file('company_logo');
                $imagePath = $image->getPathname();
                $webpPath = $imagePath . '.webp';

                $imageResource = imagecreatefromstring(file_get_contents($imagePath));
                if (!$imageResource) {
                    throw new \Exception("No se pudo crear la imagen desde el archivo proporcionado.");
                }

                // Configuración de compresión para alcanzar ≤50KB
                $maxSize = 50 * 1024; // 50KB en bytes
                $quality = 85; // Calidad inicial
                $minQuality = 30; // Calidad mínima permitida
                $step = 5; // Reducción de calidad por iteración

                do {
                    imagewebp($imageResource, $webpPath, $quality);
                    $currentSize = filesize($webpPath);

                    // Si aún es mayor que 50KB y podemos reducir más la calidad
                    if ($currentSize > $maxSize && $quality > $minQuality) {
                        $quality -= $step;
                        // Asegurarnos de no bajar de la calidad mínima
                        $quality = max($quality, $minQuality);
                    } else {
                        break;
                    }
                } while ($currentSize > $maxSize);

                // Si después de todo sigue siendo muy grande, reducir dimensiones
                if (filesize($webpPath) > $maxSize) {
                    // Obtener dimensiones originales
                    $originalWidth = imagesx($imageResource);
                    $originalHeight = imagesy($imageResource);

                    // Calcular nuevas dimensiones (reducir a la mitad)
                    $newWidth = $originalWidth / 2;
                    $newHeight = $originalHeight / 2;

                    // Crear nueva imagen con dimensiones reducidas
                    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
                    imagecopyresampled($resizedImage, $imageResource, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

                    // Volver a intentar compresión con calidad mínima
                    imagewebp($resizedImage, $webpPath, $minQuality);
                    imagedestroy($resizedImage);
                }

                $storagePath = 'companies/' . uniqid() . '.webp';
                Storage::disk('public')->put($storagePath, file_get_contents($webpPath));

                $company->company_logo_path = $storagePath;

                // Limpiar recursos temporales
                unlink($webpPath);
                imagedestroy($imageResource);
            } catch (\Throwable $e) {
                return redirect()->route('settings')
                    ->with('error', 'Hubo un error al subir o procesar la imagen: ' . $e->getMessage());
            }
        }

        $company->save();

        return redirect()->route('settings')->with('success', 'Configuración actualizada correctamente');
    }


    // Método para calcular el color de contraste
    private function getContrastColor($hexColor)
    {
        // Eliminar el # si existe
        $hexColor = ltrim($hexColor, '#');

        // Convertir a RGB
        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));

        // Calcular luminosidad relativa
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

        // Retornar negro para colores claros, blanco para colores oscuros
        return ($luminance > 0.5) ? '#000000' : '#FFFFFF';
    }
}
