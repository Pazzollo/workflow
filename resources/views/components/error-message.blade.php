<div>
    @if ($message)
        <div role="alert"
            class="p-2 border-2 rounded border-danger mb-1"
            style="background-color: rgb(255, 149, 149)">
            <p class="font-bold text-danger mb-0">Greška!</p>
            <p class="mb-1">{{ $message }}</p>
        </div>
    @endif
</div>
