<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Response;


class PaperPDFController extends Controller
{
    public function generatePDF(Paper $paper)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Inter');
        $options->set('chroot', [public_path(), storage_path('app/public')]);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        $html = view('_general.papers.paper-pdf', compact('paper'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $now = $paper->created_at->format('d-m-Y');
        $filename = str_replace(['/', '\\', ' '], '-', "{$now}_{$paper->customer->getFullNameAttribute()}_proforma-{$paper->id}.pdf");

        // Solución: Usar response() con los headers adecuados
        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
                'Cache-Control' => 'public, max-age=0'
            ]
        );
    }
}
