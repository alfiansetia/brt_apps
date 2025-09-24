<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pool = Pool::find($request->pool);
        if (!$pool) {
            return redirect()->route('onboarding.index')->with('error', 'Silahkan Pilih Pool!');
        }
        return view('pages.service.index', compact('pool'));
    }

    public function show(Service $service)
    {
        $data = $service->load(['unit', 'pool', 'items']);
        $mode = 'show';
        $items = $data->items->chunk(4);
        return view('pages.service.show', compact(['data', 'mode', 'items']));
    }

    public function download(Service $service)
    {
        $s = $service->load(['unit', 'pool', 'items']);
        $data = [
            'data'  => $s,
            'mode'  => 'download',
            'items' => $s->items->chunk(4),
        ];
        $pdf = Pdf::loadView('pages.service.download', $data)
            ->setPaper('a4', 'landscape');
        $name = 'service_' . ($service->unit->code ?? '') . '_' . $service->date . '_' . Str::random(5);
        return $pdf->download(Str::slug($name) . '.pdf');
    }
}
