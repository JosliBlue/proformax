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

                // Verificar el tamaño del archivo en bytes
                $originalSize = filesize($imagePath);

                // Si es mayor a 1MB, comprimir hasta que pese menos de 1MB
                if ($originalSize > 1048576) {
                    $quality = 90;
                    do {
                        imagewebp($imageResource, $webpPath, $quality);
                        $compressedSize = filesize($webpPath);
                        $quality -= 5;
                        if ($quality < 10) break; // Evita que la calidad sea muy baja
                    } while ($compressedSize > 1048576);
                } else {
                    // Si es menor a 1MB, guardarla con calidad máxima (100)
                    imagewebp($imageResource, $webpPath, 100);
                }

                $storagePath = 'companies/' . uniqid() . '.webp';
                Storage::disk('public')->put($storagePath, file_get_contents($webpPath));

                $company->company_logo_path = $storagePath;

                unlink($webpPath);
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
