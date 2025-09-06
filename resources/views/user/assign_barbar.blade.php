<div class="modal fade" id="assignBarberModal" tabindex="-1" aria-labelledby="assignBarberModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="assignBarberForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="assignBarberModalLabel">Assign Barber</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="text" name="ticket_id" id="ticket_id" value="">
          <div class="mb-3">
            <label for="barber_id" class="form-label">Select Barber</label>
            <select name="barber_id" id="barber_id" class="form-select" required>
              <option value="">-- Select Barber --</option>
                @foreach($barbers as $barber)
                    <option value="{{ $barber->id }}">{{ $barber->name }}</option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Assign</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
