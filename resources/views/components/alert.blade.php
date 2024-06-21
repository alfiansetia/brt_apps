@isset($pool)
    <div class="col-12">
        <div class="alert alert-info alert-has-icon alert-dismissible show fade">
            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
            <div class="alert-body">
                <div class="alert-title">Anda berada di Pool {{ $pool->name }}!</div>
            </div>
            <button class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    </div>
@endisset
