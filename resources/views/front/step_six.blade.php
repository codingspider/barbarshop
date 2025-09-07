<div class="row">
    <div class="col-12 col-md-6 text-center text-md-start">
        <h1 class="display-1 fw-bold">3</h1>
        <p class="fs-4">people ahead<br>of you</p>
        <p class="fs-5 text-muted">Approx. 25 min</p>
        <a href="{{ route('user.cancell-ticket', $ticket->id) }}" class="btn btn-success btn-lg w-100 mt-4 rounded-3">Cancel</a>
    </div>

    <div class="col-12 col-md-6 mt-4 mt-md-0">
        <div class="card mb-3 rounded-4 border-0 shadow-sm">
            <div class="row g-0">
                <div class="col-4">
                    <img src="https://via.placeholder.com/150" class="img-fluid rounded-start rounded-4"
                        alt="Stylist 1">
                </div>
                <div class="col-8 d-flex align-items-center justify-content-center">
                    <span class="fs-4 fw-bold">15</span>
                </div>
            </div>
        </div>
        <div class="card mb-3 rounded-4 border-0 shadow-sm">
            <div class="row g-0">
                <div class="col-4">
                    <img src="https://via.placeholder.com/150" class="img-fluid rounded-start rounded-4"
                        alt="Stylist 2">
                </div>
                <div class="col-8 d-flex align-items-center justify-content-center">
                    <span class="fs-4 fw-bold">50</span>
                </div>
            </div>
        </div>
        <div class="card rounded-4 border-0 shadow-sm">
            <div class="row g-0">
                <div class="col-4">
                    <img src="https://via.placeholder.com/150" class="img-fluid rounded-start rounded-4"
                        alt="Stylist 3">
                </div>
                <div class="col-8 d-flex align-items-center justify-content-center">
                    <span class="fs-4 fw-bold">...</span>
                </div>
            </div>
        </div>
    </div>
</div>