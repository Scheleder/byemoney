<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF()
    {
        $data = [
            'title' => 'Exemplo PDF',
            'date' => date('d/m/Y')
        ];

        info($data);
        $pdf = PDF::loadView('pdf.myPDF', $data);

        //$pdf = PDF::loadView('shop.coupon', ['sale' => $sale, 'setting' => $setting]);
        //$pdf->setPaper('A7', 'portrait');
        $pdf->setPaper('A4', 'portrait');
        //$pdf->setPaper([0, 0, 807.874, 221.102], 'landscape');
        //return $pdf->download('template.pdf');
        return $pdf->stream('lista.pdf');

    }
}
