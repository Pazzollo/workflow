<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="{{ route('warehouseCompany.index') }}" method="get">
            <div class="modal-body">
                <input type="text" class="form-control mb-3" placeholder="Unesite deo naziva" name="name" value="{{ request('name') }}">
                <input type="hidden" name="role" value="{{ $_GET['role'] ?? $companyRole }}">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
            <button type="submit" class="btn btn-primary">Traži</button>
            </div>
        </form>
        
      </div>
    </div>
  </div>
