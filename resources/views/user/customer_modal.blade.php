<!-- Modal for adding new customer -->
<div class="modal fade" id="addCustomerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addCustomerForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">{{ __('messages.add') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>{{ __('messages.name') }}</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="mb-3">
            <label>{{ __('messages.email') }}</label>
            <input type="email" class="form-control" name="email">
          </div>
          <div class="mb-3">
            <label>{{ __('messages.phone') }}</label>
            <input type="text" class="form-control" name="phone">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">{{ __('messages.create') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>