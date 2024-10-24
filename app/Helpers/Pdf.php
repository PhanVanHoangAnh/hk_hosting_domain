<?php

namespace App\Helpers;

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf {
    public static function exportPdf($htmlContent)
    {
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($htmlContent);
        $dompdf->render();
        
        return $dompdf->output();
    }
}