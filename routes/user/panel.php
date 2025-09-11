<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\FrontController;
use App\Http\Controllers\User\TicketController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\CustomCartController;

// User routes 
Route::get('/products', [DashboardController::class, 'allProducts']);
Route::get('/get-waiting-customers', [DashboardController::class, 'getPeopleAhead']);

Route::prefix('user')->name('user.')->group(function () {
    // Protected routes (only accessible by users)
    Route::middleware(['isUser', 'SetLocale'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('home');

        Route::get('/generate-ticket/{id}', [DashboardController::class, 'generateTicket'])->name('generate-ticket');

        Route::get('/ticket/print/{id}', [PrinterController::class, 'ticketPrint'])->name('ticket-print');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/cutomer-store', [DashboardController::class, 'customerStore'])->name('customers.store');
        Route::get('/create-ticket', [TicketController::class, 'ticketStore'])->name('create-ticket');
        Route::post('/tickets-assign', [TicketController::class, 'assignBarbar'])->name('tickets.assign');
        Route::post('/barber-action', [TicketController::class, 'barberAction'])->name('barber.action');

        Route::get('/payment/receive', [DashboardController::class, 'paymentReceive'])->name('payment-receive');
        Route::post('/make/ticket/payment', [DashboardController::class, 'makePayment'])->name('make-payment');

        Route::get('/ticket-waiting', [DashboardController::class, 'ticketWaiting'])->name('ticket-waiting');
        Route::get('/in-service', [DashboardController::class, 'inService'])->name('in-service');
        Route::get('/completed', [DashboardController::class, 'completed'])->name('completed');

        Route::get('/status/{status}', [TicketController::class, 'barberAllAction'])->name('status-completed');
        Route::get('/ticket/report', [TicketController::class, 'dailyReport'])->name('ticket-report');
        Route::get('/all/services', [TicketController::class, 'allServices'])->name('all-services');
        Route::get('/cancell-ticket/{id}', [TicketController::class, 'cancellTicket'])->name('cancell-ticket');

        
        Route::get('/get-ticket-details/{id}', [DashboardController::class, 'getTicketDetails'])->name('get-ticket-details');
        Route::get('/barbers/status', [DashboardController::class, 'getStatus'])->name('barbers.status');
        Route::post('/status/{id}', [DashboardController::class, 'updateStatus']);

        Route::get('step-one', [FrontController::class, 'stepOne'])->name('step-one');
        Route::get('step-two', [FrontController::class, 'stepTwo'])->name('step-two');
        Route::get('step-three', [FrontController::class, 'stepThree'])->name('step-three');
        Route::get('step-four/{id}', [FrontController::class, 'stepFour'])->name('step-four');
        Route::get('step-five', [CustomCartController::class, 'stepFive'])->name('step-five');
        Route::get('ticket-summery', [FrontController::class, 'ticketSummery'])->name('ticket-summery');

        Route::get('remove-from-cart', [CustomCartController::class, 'removeFromCart'])->name('remove-from-cart');
        Route::get('step-six/{id}', [FrontController::class, 'stepSix'])->name('step-six');
    });
});

Route::prefix('cart')->group(function () {
    // Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/add', [CustomCartController::class, 'addToCart'])->name('cart.add');
    Route::get('/total', [CustomCartController::class, 'cartDetails'])->name('cart.total');

    Route::post('/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::get('/subtotal', [CartController::class, 'subtotal'])->name('cart.subtotal');
    Route::get('/tax', [CartController::class, 'tax'])->name('cart.tax');
    Route::get('/vat', [CartController::class, 'vat'])->name('cart.vat');
    Route::get('/count', [CartController::class, 'count'])->name('cart.count');
    Route::get('/content', [CartController::class, 'content'])->name('cart.content');
    Route::get('/discount', [CartController::class, 'discount'])->name('cart.discount');
});