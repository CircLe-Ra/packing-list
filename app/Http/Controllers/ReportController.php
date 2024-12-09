<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Distribution;
use App\Models\Shipment;
use App\Models\ShipmentDetail;
use App\Models\ShipmentItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ReportController extends Controller
{
    public function delivery($id)
    {
        $data = Delivery::with('driver', 'delivery_images')->find($id);
        $pdf = Pdf::loadView('livewire.report.driver', ['data' => $data]);
        return $pdf->stream('delivery_report.pdf');
    }

    public function itemDamaged($id)
    {
        $data = ShipmentDetail::with(['shipment_items' => function($query) {
            $query->where('item_damaged', '>', 0);
    }, 'container'])
            ->whereHas('shipment_items', function ($query) {
                $query->where('item_damaged', '>', 0);
            })
            ->where('shipment_id', $id)
            ->get();

        // Mengambil jumlah container
        $totalContainer = ShipmentDetail::where('shipment_id', $id)->count();

        // Mengonversi gambar statis menjadi base64
        $akhlakImage = base64_encode(File::get(public_path('img/akhlak.jpg')));
        $pelniImage = base64_encode(File::get(public_path('img/pelni.png')));
        $footerImage = base64_encode(File::get(public_path('img/footer.png')));

        $itemDamageImages = [];
        foreach ($data as $shipmentDetail) {
            foreach ($shipmentDetail->shipment_items as $shipmentItem) {
                if ($shipmentItem->item_damaged > 0) {
                    foreach ($shipmentItem->item_damages as $item_damage) {
                        $itemDamageImages[] = base64_encode(File::get(public_path('storage/' . $item_damage->image)));
                    }
                }
            }
        }

        // Memuat tampilan untuk PDF dan mengirimkan data
        $pdf = Pdf::loadView('livewire.report.damaged-item', [
            'data' => $data,
            'akhlakImage' => $akhlakImage,
            'pelniImage' => $pelniImage,
            'footerImage' => $footerImage,
            'totalContainer' => $totalContainer,
            'itemDamageImages' => $itemDamageImages,
        ]);

        // Mengunduh PDF
        return $pdf->download('item_damaged_report.pdf');
    }

    public function acceptance($id){
        $data = Delivery::with('driver', 'consumer')->find($id);
        $shipment_id = $data->shipment_id;
        $quantities = Distribution::whereHas('shipment_item', function($query) use ($shipment_id) {
                $query->whereHas('shipment_detail', function($query) use ($shipment_id) {
                    $query->where('shipment_id', $shipment_id);
                });
            })
                ->where('driver_id', $data->driver_id)
                ->with('shipment_item') // Load shipmentItem to get the item_name
                ->get();

        $akhlakImage = base64_encode(File::get(public_path('img/akhlak.jpg')));
        $pelniImage = base64_encode(File::get(public_path('img/pelni.png')));
        $footerImage = base64_encode(File::get(public_path('img/footer.png')));
        $pdf = Pdf::loadView('livewire.report.acceptance', [
            'data' => $data,
            'akhlakImage' => $akhlakImage,
            'pelniImage' => $pelniImage,
            'footerImage' => $footerImage,
            'quantities' => $quantities
            ]);
        return $pdf->stream('acceptance_report.pdf');
    }

    public function travelDocument($id)
    {
        $data = Delivery::with('driver','consumer')->find($id);
        $shipment_id = $data->shipment_id;
        $quantities = Distribution::whereHas('shipment_item', function($query) use ($shipment_id) {
            $query->whereHas('shipment_detail', function($query) use ($shipment_id) {
                $query->where('shipment_id', $shipment_id);
            });
        })
            ->where('driver_id', $data->driver_id)
            ->with('shipment_item') // Load shipmentItem to get the item_name
            ->get();

        $akhlakImage = base64_encode(File::get(public_path('img/akhlak.jpg')));
        $pelniImage = base64_encode(File::get(public_path('img/pelni.png')));
        $footerImage = base64_encode(File::get(public_path('img/footer.png')));

        $pdf = Pdf::loadView('livewire.report.travel-doc', [
            'data' => $data,
            'akhlakImage' => $akhlakImage,
            'pelniImage' => $pelniImage,
            'footerImage' => $footerImage,
            'quantities' => $quantities,
            ]);
        return $pdf->stream('travel_document.pdf');
    }

    public function container($id)
    {
        $shipment = Shipment::find($id);
        $data = ShipmentDetail::where('shipment_id', $id)->get();
        $pdf = Pdf::loadView('livewire.report.container', [
            'datas' => $data,
            'shipment' => $shipment
            ]);
        return $pdf->stream('container_report.pdf');
    }
}
