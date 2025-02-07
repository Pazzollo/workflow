<div id="buttons" class="sticky-bottom p-1 bg-light pt-2 z-0">
{{ $slot }}
    <div class="d-flex gap-2">
        @if (Route::currentRouteName() == 'warehouse.index')
            <a href="{{ route('material.index') }}" class="btn btn-sm w-100 text-light"
                style="background-color: #e25904">
                Lista materijala
            </a>
        @else
        <a href="{{ route('warehouse.index') }}" class="btn btn-sm w-100 text-light"
            style="background-color: #e25904">
            Stanje materijala
        </a>
        @endif
        <a href="{{ route('material.create') }}" class="btn btn-sm w-100 btn-success" type="submit">
            Novi materijal
        </a>
    </div>
    <div id="buttons" class="pt-2">
        <a href="{{ url()->previous() }}" class="btn btn-sm w-100 btn-secondary " type="submit">
            Nazad
        </a>
    </div>
</div>
