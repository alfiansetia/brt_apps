<div class="row mb-3 hidden" id="filters">
    <div class="col-8 col-lg-6 mb-2">
        <select id="filters_unit" class="form-control select2">
            <option value="">ALL Unit</option>
            @foreach ($units as $item)
                <option value="{{ $item->id }}">{{ $item->code }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-4 col-lg-2 mb-2">
        <button type="button" id="btn_filter" class="btn btn-primary btn-block">Filter</button>
    </div>
</div>
