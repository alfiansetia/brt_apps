<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Pool;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PartController extends Controller
{
    public function index(Request $request)
    {
        $pool = Pool::find($request->pool);
        if (!$pool) {
            return redirect()->route('onboarding.index')->with('error', 'Silahkan Pilih Pool!');
        }

        return view('pages.part.index', compact('pool'));
    }

    public function show(Part $part)
    {
        $data = $part->load(['unit', 'pool', 'new_parts', 'old_parts']);
        $mode = 'show';
        $news = $data->new_parts->chunk(4);
        $olds = $data->old_parts->chunk(4);

        return view('pages.part.show', compact(['data', 'mode', 'news', 'olds']));
    }

    public function download(Part $part)
    {
        $s = $part->load(['unit', 'pool', 'new_parts', 'old_parts']);
        $data = [
            'data' => $s,
            'mode' => 'download',
            'news' => $s->new_parts->chunk(4),
            'olds' => $s->old_parts->chunk(4),
        ];
        $pdf = Pdf::loadView('pages.part.download', $data)
            ->setPaper('a4', 'potrait');
        $name = 'part_'.$part->sn.'_'.($part->unit->code ?? '').'_'.Str::random(5);

        return $pdf->download(Str::slug($name).'.pdf');
    }
}
