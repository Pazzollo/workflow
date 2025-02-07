<div class="d-flex justify-content-between border-bottom mb-2 justify-items-center">
    <div class="description gap-2">
        <label for="exampleInputPassword1" class="form-label mb-0 text-secondary d-flex align-items-baseline">Brend</label>
        <p class="card-text mb-0">{{ $material->brand }}</p>
    </div>
    <div class="description gap-2">
        <label for="exampleInputPassword1" class="form-label mb-0 text-secondary">širina x <b
                class="text-decoration-underline">(smer)</b></label>
        <p class="card-text fs-6 mb-2 text-end">{{ $material->width }} x <b
                class="text-decoration-underline">{{ $material->length }}</b></p>
    </div>
</div>
