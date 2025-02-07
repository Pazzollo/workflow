<header class="navbar sticky-top bg-dark flex-md-nowrap p-2 shadow" data-bs-theme="dark">
    <div class="d-flex flex-row">
        <div>
            @auth
            <div>
                <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="{{ route('company.index') }}">{{ Auth::user()->company->name }}</a>
                <div
                    @class(['px-3', 'fw-bold',
                    'text-danger' => Auth::user()->company->getBalance(Auth::user()->company->id) < 0,
                    'text-success' => Auth::user()->company->getBalance(Auth::user()->company->id)])>
                    Stanje: {{ number_format(Auth::user()->company->getBalance(Auth::user()->company->id),2,',','.') }}
                </div>
            </div>
            {{-- @endauth --}}
        </div>

        @if (Auth::user()->role_id == 1  && Route::currentRouteName() == 'transfer.index')
        <div>

            <div class="text-white px-3">
                {{ $company->name }}
            </div>

            <div
                @class(['px-3', 'fw-bold', 'text-left',
                'text-danger' => $company->getBalance($company->id) < 0,
                'text-success' => $company->getBalance($company->id) >= 0])>
                Stanje: {{ number_format($company->getBalance($company->id),2,',','.') }}
            </div>
        </div>
        @endif
    </div>

        {{-- @auth --}}
    <div class="btn btn-secondary m-2">{{ Auth::user()->name }}</div>
        {{-- @endauth --}}
        <div class="d-flex justify-content-end">
        {{-- @auth --}}
        <a class="btn btn-danger m-2" href="{{ route('logout') }}">Logout</a>
        {{-- @endauth --}}
            {{-- <button class="btn btn-primary m-2"><div id="time"></div></button> --}}
    </div>
    @endauth
</header>
