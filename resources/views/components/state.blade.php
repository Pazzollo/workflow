<div class="d-flex gap-3">
    <div class="mb-1 w-100">
        <p class="mb-0 text-center" style="font-size: 12px">Stanje sa rezervacijama</p>
<a href="{{ route('material.show', $material) }}" class="btn btn-success @if ($quantities->sum('quantity') - $reservations->where('reserved', 1)->sum('quantity') < 0) btn-danger

        @endif btn-sm w-100">
            {{ number_format($quantities->sum('quantity') - $reservations->where('reserved', 1)->sum('quantity'), 0, ',', '.') }}
            tabaka
        </a>
    </div>
    <div class="mb-2 w-100">
        <p class="my-0 text-primary text-center" style="font-size: 12px">Rezervacija</p>
        <a href="{{ route('reservation.show', $material->id) }}" class="btn btn-primary btn-sm w-100">
            {{ number_format($reservations->where('reserved', 1)->sum('quantity'), 0, ',', '.') }} tabaka
        </a>
    </div>
</div>
