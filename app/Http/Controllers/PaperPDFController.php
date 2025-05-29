<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;


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

        $now = now()->format('d-m-Y');
        $filename = str_replace(['/', '\\', ' '], '-', "{$now}_{$paper->customer->getFullNameAttribute()}_proforma-{$paper->id}.pdf");
        return $dompdf->stream($filename, [
            "Attachment" => false
        ]);
    }
}
