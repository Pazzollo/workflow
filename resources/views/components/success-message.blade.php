<div>
    @if ($message)
        <div role="alert"
            class="p-2 border-2 rounded border-success mb-2"
            style="background-color: rgb(176, 249, 193)">
            <p class="font-bold text-success mb-0">Uspešno!</p>
            <p class="mb-1">{{ $message }}</p>
        </div>
    @endif
</div>
