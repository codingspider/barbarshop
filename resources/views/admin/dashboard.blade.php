@extends('admin.layouts.app')

@section('content')
<div class="row g-3 mb-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="d-flex">
                            <img class="avatar rounded-circle" src="assets/images/profile_av.svg" alt="profile">
                            <div class="flex-fill ms-3">
                                <p class="mb-0"><span class="font-weight-bold">John Quinn</span></p>
                                <small class="">Johnquinn@gmail.com</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="d-flex flex-column">
                            <span class="text-muted mb-1">User ID:164647708</span>
                            <span class="small text-muted flex-fill text-truncate">Last login time 2021-09-29
                                10:56:22</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- Row End -->

<div class="row g-3 mb-3 row-cols-1 row-cols-md-2 row-cols-lg-4">
    <div class="col">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="flex-fill text-truncate">
                    <span class="text-muted small text-uppercase">BNB/BUSD</span>
                    <div class="d-flex flex-column">
                        <div class="price-block">
                            <span class="fs-6 fw-bold color-price-up">418</span>
                            <span class="small text-muted px-2">$418</span>
                        </div>
                        <div class="price-report">
                            <span class="small text-danger">- 1.28% <i class="fa fa-level-down"></i></span>
                            <span class="small text-muted px-2">Volume:109,267,865.92 BUSD</span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="apexspark1"></div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="flex-fill text-truncate">
                    <span class="text-muted small text-uppercase">ETH/USDT</span>
                    <div class="d-flex flex-column">
                        <div class="price-block">
                            <span class="fs-6 fw-bold color-price-down">3499</span>
                            <span class="small text-muted px-2">$3500</span>
                        </div>
                        <div class="price-report">
                            <span class="small text-danger">- 1.79% <i class="fa fa-level-down"></i></span>
                            <span class="small text-muted px-2">Volume:541,545,011.76 USDT</span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="apexspark2"></div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="flex-fill text-truncate">
                    <span class="text-muted small text-uppercase">DOT/BUSD</span>
                    <div class="d-flex flex-column">
                        <div class="price-block">
                            <span class="fs-6 fw-bold">35.00</span>
                            <span class="small text-muted px-2">$35</span>
                        </div>
                        <div class="price-report">
                            <span class="small text-success">+ 3.78% <i class="fa fa-level-up"></i></span>
                            <span class="small text-muted px-2">Volume:63,324,607.43 BUSD BUSD</span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="apexspark3"></div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="flex-fill text-truncate">
                    <span class="text-muted small text-uppercase">GRT/USDT</span>
                    <div class="d-flex flex-column">
                        <div class="price-block">
                            <span class="fs-6 fw-bold color-price-up">0.8413</span>
                            <span class="small text-muted px-2">$1</span>
                        </div>
                        <div class="price-report">
                            <span class="small text-danger">- 1.11% <i class="fa fa-level-down"></i></span>
                            <span class="small text-muted px-2">Volume:28,538,521.44 USDT</span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="apexspark4"></div>
        </div>
    </div>
</div><!-- Row End -->

<div class="row g-3 mb-3 row-deck">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="mb-0 fw-bold">Recent Transactions</h6>
            </div>
            <div class="card-body">
                <table id="ordertabthree"
                    class="priceTable table table-hover custom-table-2 table-bordered align-middle mb-0"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Pair</th>
                            <th>Side</th>
                            <th>Price</th>
                            <th>Executed</th>
                            <th>Fee</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>09-18 17:32:15</td>
                            <td><img src="assets/images/coin/ETH.png" alt="" class="img-fluid avatar mx-1">ETH/USDT</td>
                            <td><span class="color-price-down">Sell</span></td>
                            <td>3,487.50</td>
                            <td>0.0110</td>
                            <td>0.03836250 USDT</td>
                            <td>38.36250000 USDT</td>
                        </tr>
                        <tr>
                            <td>09-18 17:31:11</td>
                            <td><img src="assets/images/coin/SOL.png" alt="" class="img-fluid avatar mx-1">SOL/USDT</td>
                            <td><span class="color-price-down">Sell</span></td>
                            <td>160.33</td>
                            <td>0.75</td>
                            <td>0.12024750 USDT</td>
                            <td>120.24750000 USDT</td>
                        </tr>
                        <tr>
                            <td>09-18 08:52:04</td>
                            <td><img src="assets/images/coin/ETH.png" alt="" class="img-fluid avatar mx-1">ETH/USDT</td>
                            <td><span class="color-price-up">Buy</span></td>
                            <td>3,439.20</td>
                            <td>0.0111</td>
                            <td>0.00001110 ETH</td>
                            <td>38.17512000 USDT</td>
                        </tr>
                        <tr>
                            <td>09-17 08:34:14</td>
                            <td><img src="assets/images/coin/SOL.png" alt="" class="img-fluid avatar mx-1">SOL/USDT</td>
                            <td><span class="color-price-up">Buy</span></td>
                            <td>147.04</td>
                            <td>0.76</td>
                            <td>0.00076000 SOL</td>
                            <td>111.75040000 USDT</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- Row End -->
@endsection