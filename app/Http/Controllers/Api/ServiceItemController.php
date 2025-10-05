<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceItemResource;
use App\Models\Service;
use App\Models\ServiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ServiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['service_id']);
        $query = ServiceItem::query()->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return ServiceItemResource::make($item)->resolve();
        })->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'service'       => 'required|exists:services,id',
            'label'         => 'required|max:200',
            'custom_label'  => 'required_if:label,other|max:200',
            'image'         => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);
        $label  = $request->label;
        if ($label == 'other') {
            $label = $request->custom_label;
        }
        $exist = ServiceItem::query()
            ->where('service_id', $request->service)
            ->where('label', $label)
            ->first();
        if ($exist) {
            return  response()->json(['message' => 'Label ' . $label . ' Sudah ada!'], 403);
        }
        $img = null;
        if ($files = $request->file('image')) {
            $destinationPath = storage_path('/app/public/img/service/');
            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 755, true);
            }
            $img = 'service_' . $request->service . '_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
            // $files->move($destinationPath, $img);
            $image = scaleDown($files);
            $image->save($destinationPath . $img, 80);
        }
        $service_item = ServiceItem::create([
            'service_id'    => $request->service,
            'label'         => $label,
            'image'         => $img,
        ]);
        return $this->response('Sukses Tambah Data!', new ServiceItemResource($service_item), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceItem $serviceItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceItem $serviceItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceItem $service_item)
    {
        $img = $service_item->getRawOriginal('image');
        $destinationPath = storage_path('/app/public/img/service/');
        if (!empty($img) && file_exists($destinationPath . $img)) {
            File::delete($destinationPath . $img);
        }
        $service_item->delete();
        return $this->response('Sukses Hapus Data!', new ServiceItemResource($service_item), 200);
    }
}
