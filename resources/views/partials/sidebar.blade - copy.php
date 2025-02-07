
    <div class="d-flex flex-column flex-shrink-0 p-1" style="max-width: 200px">

            <ul class="nav nav-pills flex-column mb-auto" style="position: fixed">
                @if (Auth::user()->role_id == 1)
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="text-start btn btn-secondary w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-file-invoice-dollar text-white"></i>
                            <span class="text-white resp">Stanje</span>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach ($companies as $company)
                                @if ($company->companyRole->id == 2)
                                    <li><a class="dropdown-item" href="{{ route('transfer.index', ['id' => $company]) }}">{{ $company->name }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </li>
                @else
                <li>
                    <a class="text-start btn btn-secondary w-100" href="{{ route('transfer.index') }}">
                        <i class="fa-solid fa-file-invoice-dollar text-white"></i>
                        <span class="text-white resp">Stanje</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ route('transfer.income') }}" class="btn btn-success mt-2 text-start w-100">
                    <i class="fa-solid fa-circle-chevron-right text-white"></i>
                    <span class="text-white resp">Uplata</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('transfer.payment') }}" class="btn btn-warning mt-2 text-start w-100">
                    <i class="fa-solid fa-circle-chevron-left text-white"></i>
                    <span class="resp">Isplata</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('company.new') }}" class="btn btn-info mt-2 text-start w-100">
                    <i class="fa-regular fa-building text-white"></i>
                    <span class="resp">Saradnici</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.index') }}" class="btn btn-primary mt-2 text-start w-100">
                        <i class="fa-solid fa-screwdriver-wrench text-white"></i>
                        <span class="resp">Admin</span>
                    </a>
                </li>
            </ul>

    </div>

