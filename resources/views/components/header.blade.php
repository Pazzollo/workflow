<header class="text-light d-flex justify-content-between" id="header">
    <div>
        @auth
            @if ($burger)
                <div class="d-flex justify-content-center align-items-center header-box" style="border: none" onclick="showSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </div>
            @endif
        @endauth
    </div>
    @if ($title)
        <div class="d-flex justify-content-center align-items-center fs-6">{{ $title }}</div>
    @endif
    <div class="d-flex gap-1">
        @auth

            @if ($search)
                <div class="d-flex justify-content-center align-items-center header-box pointer-event" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            @endif
            <form action="{{ route('auth.destroy') }}" method="post">
                @csrf
                @method('DELETE')
                <button class="d-flex justify-content-center align-items-center header-box text-white" type="submit"><i class="fa-solid fa-right-from-bracket"></i></button>
            </form>
        @else
            <a href="{{ route('auth.create') }}" class="d-flex justify-content-center align-items-center header-box">
                <i class="fa-regular fa-user"></i>
            </a>
        @endauth
    </div>
</header>
