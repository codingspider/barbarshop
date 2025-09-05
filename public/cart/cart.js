$(document).ready(function(){
loadProducts();
updateCartSummary();
updateCartTable();

function loadProducts() {
    $.ajax({
        url: '/products',
        method: 'GET',
        dataType: 'html',
        success: function(products) {
            $('#products-container').html(products);
        },
        error: function(err) {
            console.error(err);
            $('#products-container').html('<div class="col-12 text-center text-danger">Failed to load products</div>');
        }
    });
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Add to cart
$(document).on('click', '.btn-add-to-cart', function(e) {
    e.preventDefault();
    let btn = $(this);

    $.post('/cart/add', {
        id: btn.data('id'),
        name: btn.data('name'),
        price: btn.data('price'),
        qty: btn.data('qty')
    }, function(res) {
        toastr.success("Item Added to cart");
        // Switch button to remove
        btn.removeClass('btn-primary btn-add-to-cart')
           .addClass('btn-danger');

        updateCartSummary();
        updateCartTable();

    });
});


// Remove from cart
$(document).on('click', '.btn-remove-cart', function(e) {
    e.preventDefault();
    let btn = $(this);
    let productId = btn.data('id');

    $.post('/cart/remove', { id: productId }, function(res) {
        if(res.success){
            toastr.success(res.message);
            btn.removeClass('btn-danger btn-remove-cart')
               .addClass('btn-primary btn-add-to-cart')
               .text('Book');
            updateCartTable();
        } else {
            toastr.error(res.message);
        }
        updateCartSummary();
        
    });
});

// Update quantity
$(document).on('change', '.cart-qty', function () {
    let rowId = $(this).data('rowid');
    let qty   = $(this).val();

    $.post('/cart/update', { rowId, qty }, function (res) {
        console.log("Updated:", res);
        updateCartSummary(res);
    });
});

// Remove item
$(document).on('click', '.btn-remove-cart', function () {
    let rowId = $(this).data('rowid');

    $.post('/cart/remove', { rowId }, function (res) {
        console.log("Removed:", res);
        updateCartSummary(res);
        updateCartTable();
    });
});


// Remove item on click
$('#cart-table').on('click', '.btn-remove', function() {
    var rowId = $(this).data('id');
    $.ajax({
        url: '/cart/remove',
        method: 'POST',
        data: {id: rowId},
        success: function(res) {
            $('#cart-table tbody').empty();
            toastr.success('Item removed');
            updateCartSummary(res);
            updateCartTable();
        }
    });
});

// Refresh totals
function updateCartSummary(res) {
    // res.cart is the full content
    loadProducts();

    $.get('/cart/total', function (data) {
        $('.cart-total').text(data.total);
    });

    $.get('/cart/count', function (data) {
        $('.cart-count').text(data.count);
    });

    $.get('/cart/subtotal', function (data) {
        $('.cart-subtotal').text(data.subtotal);
    });
}

// Fetch and display cart
function updateCartTable(res) {
        $.getJSON('/cart/content', function(response) {
        var $tbody = $('#cart-table tbody');
        $tbody.empty();

        if (!response.cart.length) {
            $tbody.append(`
                <tr>
                    <td colspan="2" class="text-center text-muted">Your cart is empty</td>
                </tr>
            `);
            return;
        }

        response.cart.forEach(function(item) {
            var row = `
                <tr data-id="${item.id}">
                    <td>${item.name}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-danger btn-remove" data-id="${item.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $tbody.append(row);
        });
    });
}

// store order records 
$('#submitCartBtn').click(function(e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/user/create-ticket",
            type: "POST",
            data: $('#cartForm').serialize(),
            success: function(response) {
                if(response.success){
                    toastr.success(response.message);
                    $('#cartForm')[0].reset();
                      printTicket(response.ticket_id);
                }
                loadProducts();
                updateCartSummary();
                updateCartTable();
              
            },
            error: function(xhr) {
                if(xhr.responseJSON && xhr.responseJSON.message){
                    toastr.error(xhr.responseJSON.message);
                } else if(xhr.responseJSON && xhr.responseJSON.errors){
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = '';
                    $.each(errors, function(key, value){
                        errorMsg += value + '<br>';
                    });
                    toastr.error(errorMsg);
                } else {
                    toastr.error('Something went wrong.');
                }
            }
        });
});

// print ticktes 
function printTicket(id){
    $.ajax({
        url: "/user/generate-ticket/"+ id,
        method: "GET",
        success: function(html) {
            let printWindow = window.open('', '_blank');
            printWindow.document.write(html);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        }
    });
}

// get ahead people 
function getWaitingCustomers() {
    $.ajax({
        url: '/get-waiting-customers',
        method: 'GET',
        success: function(res) {
            $('#ahead_people').text(res.total);
        },
        error: function(err) {
            console.error(err);
        }
    });
}

// Call immediately on page load
getWaitingCustomers();

// Call every 10 seconds (10000 ms)
setInterval(getWaitingCustomers, 10000);


});