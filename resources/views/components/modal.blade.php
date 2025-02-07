<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <form action="{{ route(Route::currentRouteName()) }}" method="get">
            <div class="modal-body">
                <select class="form-select mb-3" id="inputGroupSelect01" name="materialtype_id">
                    <option value="" selected>Materijal...</option>
                    @foreach ($materialTypes as $type)
                        <option value="{{ $type->id }}" @selected(request('materialtype_id') == $type->id)>{{ $type->name }}</option>
                    @endforeach
                </select>
                <input type="number" class="form-control mb-3" placeholder="Gramatura" name="weight" value="{{ request('weight') }}">
                <select class="form-select" id="inputGroupSelect01" name="finish">
                    <option value="" selected>Premaz...</option>
                    @foreach ($finishes as $finish)
                        <option value="{{ $finish->id }}" @selected(request('finish') == $finish->id)>{{ $finish->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <div>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Reset</button>
                </div>
                <div>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>
