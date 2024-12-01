<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function delivery($id)
    {
        // Ambil data pengiriman berdasarkan ID
        $data = Delivery::with('driver', 'delivery_images')->find($id);
        // Generate PDF menggunakan DomPDF
        $pdf = Pdf::loadView('livewire.report.driver', ['data' => $data]);
        // Download PDF dengan nama file delivery_report.pdf
        return $pdf->download('delivery_report.pdf');
    }
}
