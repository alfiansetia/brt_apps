<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PartController extends Controller
{
    public function index(Request $request)
    {
        $pool = Part::find($request->pool);
        if (!$pool) {
            return redirect()->route('onboarding.index')->with('error', 'Silahkan Pilih Pool!');
        }
        return view('pages.part.index', compact('pool'));
    }

    public function show(Part $part)
    {
        $data = $part->load(['unit', 'pool', 'items']);
        $mode = 'show';
        $items = $data->items->chunk(4);
        return view('pages.part.show', compact(['data', 'mode', 'items']));
    }

    public function download(Part $part)
    {
        $s = $part->load(['unit', 'pool', 'items']);
        $data = [
            'data'  => $s,
            'mode'  => 'download',
            'items' => $s->items->chunk(4),
        ];
        $pdf = Pdf::loadView('pages.service.download', $data)
            ->setPaper('a4', 'landscape');
        $name = 'service_' . $part->type . '_' . $part->date . '_' . Str::random(5);
        return $pdf->download(Str::slug($name) . '.pdf');
    }
}
