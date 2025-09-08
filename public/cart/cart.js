$(document).ready(function(){

updateCartSummary();


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
            
        }
    });
});

// Refresh totals
function updateCartSummary(res) {
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




});