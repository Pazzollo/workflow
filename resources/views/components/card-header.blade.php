<div class="card-header px-0" {{ $attributes }}>
    @if ($material)
        <button class="text-uppercase text-dark badge border-1">{{ $material->materialtype->name }}</button>
        @if ($material->finish_id != 3)
            <button class="text-uppercase text-dark badge border-1">{{ $material->finish->name }}</button>
        @endif
        <button class="badge text-dark border-1">{{ $material->weight }} gr/m2</button>
        <button class="badge text-dark border-1">{{ $material->dimension->name }}</button>
        <button class="badge text-dark border-1">{{ $material->brand }}</button>
    @else
        {{-- <button class="text-uppercase text-dark badge border-1">{{ $company->name }}</button> --}}
    @endif
</div>
