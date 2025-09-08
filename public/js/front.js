$(document).ready(function() {

    stepOne();
    function stepOne() {
        $.ajax({
            url: '/user/step-one',
            method: 'GET',
            dataType: 'html',
            success: function(res) {
                $('#content-body').html(res);
            },
            error: function(err) {
                console.error(err);
                $('#content-body').html('<div class="col-12 text-center text-danger">Failed to load section </div>');
            }
        });
    }

    $(document).on('click', '.order-btn', function(e) {
        e.preventDefault();
        $('#content-body').html('');
        $.ajax({
            url: '/user/step-two',
            method: 'GET',
            dataType: 'html',
            success: function(res) {
                $('#content-body').html(res);
            },
            error: function(err) {
                console.error(err);
                $('#content-body').html('<div class="col-12 text-center text-danger">Failed to load section </div>');
            }
        });
    });


    $(document).on('click', '.btn-add-to-cart', function(e) {
        e.preventDefault();
        let btn = $(this);

        $.post('/cart/add', {
            id: btn.data('id'),
            name: btn.data('name'),
            price: btn.data('price'),
            qty: btn.data('qty')
        }, function(res) {
            stepThree();
        });
    });

    function stepThree () {
        $.ajax({
            url: '/user/step-three',
            method: 'GET',
            dataType: 'html',
            success: function(res) {
                $('#content-body').html(res);
            },
            error: function(err) {
                console.error(err);
                $('#content-body').html('<div class="col-12 text-center text-danger">Failed to load section </div>');
            }
        });
    }


    $(document).on('click', '.choose_barber', function(e) {
        e.preventDefault();
        var barber_id = $(this).data('id');
        console.log('barber id' + barber_id);

        $.ajax({
            url: '/user/step-four/'+barber_id,
            method: 'GET',
            dataType: 'html',
            success: function(res) {
                $('#content-body').html(res);
            },
            error: function(err) {
                console.error(err);
                $('#content-body').html('<div class="col-12 text-center text-danger">Failed to load section </div>');
            }
        });
    });
    
    
    
    $(document).on('click', '.choose_addon', function(e) {
        e.preventDefault();
        var addon_id = $(this).data('id');
        console.log('addon id' + addon_id);

        $.ajax({
            url: '/user/step-five/'+addon_id,
            method: 'GET',
            dataType: 'html',
            success: function(res) {
                $('#content-body').html(res);
                $('.cart_count').show();
                updateCartSummary();
                updateCartTable();
            },
            error: function(err) {
                console.error(err);
                $('#content-body').html('<div class="col-12 text-center text-danger">Failed to load section </div>');
            }
        });
    });

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

    // store order records 
    $(document).on('click','#submitCartBtn', function(e) {
        e.preventDefault();
        $.ajax({
            url: "/user/create-ticket/",
            method: "GET",
            success: function(res) {
                $('#content-body').html(res);
                $('.cart_count').hide();
                printTicket(res.id);
                stepSix(res.id);
            },
            error: function(err) {
                console.error(err);
                $('#content-body').html('<div class="col-12 text-center text-danger">Failed to load section </div>');
            }
        });

    });

    function stepSix (id) {
        $.ajax({
            url: '/user/step-six/'+id,
            method: 'GET',
            dataType: 'html',
            success: function(res) {
                $('#content-body').html(res);
                setTimeout(function() {
                    window.location.href = "/";
                }, 5000);
            },
            error: function(err) {
                console.error(err);
                $('#content-body').html('<div class="col-12 text-center text-danger">Failed to load section </div>');
            }
        });
    }

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
                    </tr>
                `;
                $tbody.append(row);
            });
        });
    }


});