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
        $options->set('defaultFont', 'Arial');
        $options->set('chroot', [public_path(), storage_path('app/public')]);

        $dompdf = new Dompdf($options);
        $company = $paper->user->company;
        $html = view('_general.papers.paper-pdf', compact('paper', 'company'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = $paper->created_at->format('d-m-Y') . "_{$paper->customer->getFullName()}_proforma-{$paper->id}.pdf";
        
        // Verificar si se solicita descarga
        $disposition = request('download') ? 'attachment' : 'inline';

        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => $disposition . '; filename="' . $filename . '"',
            'Cache-Control' => 'public, max-age=0'
        ]);
    }
}
