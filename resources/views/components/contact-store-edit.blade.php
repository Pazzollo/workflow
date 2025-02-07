@if (Route::currentRouteName() == 'contacts.edit')
    @php
        $name = $contact->name;
        $email = $contact->email;
        $phone = $contact->phone;
        $phone2 = $contact->phone2;
        $birthday = $contact->birthday;
        $company_id = $contact->companies->last()->id;
        $start_date = $contact->companies->last()->pivot->start_date;
        $end_date = $contact->companies->last()->pivot->end_date;
    @endphp
    <form action="{{ route('contacts.update', $contact) }}" method="POST">
@else
    @php
        $name = '';
        $email = '';
        $phone = '';
        $phone2 = '';
        $birthday = '';
        $company_id = '';
        $start_date = '';
        $end_date = '';
    @endphp
    <form action="{{ route('contacts.store') }}" method="POST">
@endif

    @csrf
    @if(Route::currentRouteName() == 'contacts.edit')
        @method('PUT')
    @endif
    <div class="mb-3">
        <label for="name" class="form-label">Ime</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $name }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $email }}" required>
    </div>
    <div class="mb-3 d-flex gap-3">
        <div class="w-50">
            <label for="phone" class="form-label">Telefon</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $phone }}" required>
        </div>
        <div class="w-50">
            <label for="phone2" class="form-label">Telefon 2</label>
            <input type="text" class="form-control" id="phone" name="phone2" value="{{ $phone2 }}" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="birthday" class="form-label">Datum rođenja</label>
        <input type="date" class="form-control" id="birthday" name="birthday" value="{{ $birthday }}">
    </div>
    <div class="mb-3">
        <label for="company_id" class="form-label">Firma</label>
        <select class="form-select" id="company_id" name="company_id">
            <option selected>Izaberi firmu</option>
            @foreach($companies as $company)
                <option value="{{ $company->id }}" @if ($company->id == $company_id) selected @endif>{{ $company->name }}</option>
            @endforeach
          </select>
    </div>
    <div class="mb-3">
        <label for="start_date" class="form-label">Datum početka rada</label>
        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $start_date }}" required>
    </div>
    @if (Route::currentRouteName() == 'contacts.edit')
        <div class="mb-3">
            <label for="end_date" class="form-label">Datum završetka rada</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $end_date }}">
        </div>
    @endif
    <button type="submit" class="btn btn-primary btn-sm w-100">Sačuvaj</button>
</form>
