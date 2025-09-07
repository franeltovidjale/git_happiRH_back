<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function download(): Response
    {
        // Données d'exemple - à remplacer par les vraies données de l'employé
        $data = [
            'company_name' => 'SOGEA-SATOM SA',
            'company_address' => '01 B P 2190',
            'company_city' => 'COTONOU',
            'company_phone' => '21-33-00-94',
            'company_country' => 'BENIN',
            'period' => 'OCTOBRE 2024',
            'period_start' => '01/10/2024',
            'period_end' => '31/10/24',
            'employee_name' => 'DUPONT JEAN',
            'salary' => 500000,
            'net_pay' => 361500,
        ];

        $pdf = Pdf::loadView('pdf.payslip.benin_payslip', $data);
        return $pdf->stream();
    }
}
