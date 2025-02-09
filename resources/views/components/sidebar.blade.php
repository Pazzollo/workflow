<sidebar {{ $attributes }} class="z-10">

    <div class="my-3"><a href="{{ route('warehouse.index') }}" class="hover:underline">Magacin</a></div>

    <div class="my-3 z-3">
        <a class="dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Materijali
        </a>
        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
            <li><a class="dropdown-item over:underline mb-2" href="{{ route('material.index') }}">Lista&nbsp;materijala</a></li>
            <li><a class="dropdown-item over:underline" href="{{ route('material_type.index') }}">Vrste materijala</a></li>
            <li><a class="dropdown-item over:underline" href="{{ route('finish.index') }}">Tipovi premaza</a></li>
            <li><a class="dropdown-item over:underline" href="{{ route('dimension.index') }}">Formati papira</a></li>
            <li><a class="dropdown-item over:underline text-warning" href="{{ route('material.create') }}">Novi materijal</a></li>
            <li><a class="dropdown-item over:underline mt-3" href="{{ route('warehouse.order') }}">Poručivanje</a></li>
        </ul>
    </div>
    @if (auth()->user()->role_id !== 5)
        <div class="my-3">
            <a class="dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Klijenti
            </a>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                <li>
                    <a class="dropdown-item over:underline" aria-expanded="false" href="{{ route('warehouseCompany.index', ['role' => 3]) }}">Kupci</a>
                </li>
                <li>
                    <a class="dropdown-item over:underline" aria-expanded="false" href="{{ route('warehouseCompany.index', ['role' => 4]) }}">Dobavljači</a>
                </li>
                <li>
                    <a class="dropdown-item over:underline" aria-expanded="false" href="{{ route('warehouseCompany.create') }}">Novi klijent</a>
                </li>
            </ul>
        </div>

        <div class="my-3">
            <a class="dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Kontakti
            </a>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                <li>
                    <a class="dropdown-item over:underline" aria-expanded="false" href="{{ route('contacts.index') }}">Lista kontakata</a>
                </li>
                <li>
                    <a class="dropdown-item over:underline" aria-expanded="false" href="{{ route('contacts.create') }}">Novi kontakt</a>
                </li>
            </ul>
        </div>
    @endif


    @foreach ($links as $label => $value)
        <div class="my-3"><a href="{{ $value }}" class="hover:underline">{{ $label }}</a></div>
    @endforeach
    <div class="bg-white mb-2" style="height: 1px; margin-top: 200px"></div>
    <a href="{{ route('warehouse.index') }}" class="hover:underline btn btn-sm btn-light w-100 mt-2">Radni nalozi</a>
    @if (Auth::user()->role_id == 1)
        <a href="{{ route('company.index') }}" class="hover:underline btn btn-sm btn-light w-100 mt-2">Saradnici</a>
    @elseif (Auth::user()->role_id == 2)
        <a href="{{ route('company.index') }}" class="hover:underline btn btn-sm btn-light w-100 mt-2">Moji poslovi</a>
    @endif
    <div class="mb-2 mt-4"></div>
    <form action="{{ route('auth.destroy') }}" method="post">
        @csrf
        @method('DELETE')
        <button class="hover:underline btn btn-sm btn-danger w-100 mt-2">Odjavi se</button>
    </form>
    {{ $slot }}
</sidebar>
