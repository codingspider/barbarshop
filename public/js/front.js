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
    
    
    
    $(document).on('click', '.showcartsummery', function(e) {
        e.preventDefault();

        $.ajax({
            url: '/user/ticket-summery',
            method: 'GET',
            dataType: 'html',
            success: function(res) {
                $('#content-body').html(res);
                updateCartSummary();
            },
            error: function(err) {
                console.error(err);
                $('#content-body').html('<div class="col-12 text-center text-danger">Failed to load section </div>');
            }
        });
    });

    $(document).on('click', '.choose_addon', function(e) {
        e.preventDefault();

        var card = $(this);
        var addon_id = card.data('id');

        // Prevent double-click when Remove button clicked
        if($(e.target).hasClass('remove-btn')) return;

        // Add to cart via AJAX
        $.ajax({
            url: '/user/step-five?addon_id=' + addon_id,
            method: 'GET',
            success: function(res) {
                // Mark as selected
                card.addClass('border-primary');
                card.find('.remove-btn').removeClass('d-none');
                console.log('Addon added:', addon_id);
            },
            error: function(err) {
                console.error(err);
                alert('Failed to add addon.');
            }
        });
    });

    // Remove button click
    $(document).on('click', '.remove-btn', function(e) {
        e.stopPropagation(); // Prevent triggering parent click

        var card = $(this).closest('.choose_addon');
        var addon_id = card.data('id');

        // Remove from cart via AJAX
        $.ajax({
            url: '/user/remove-from-cart?addon_id=' + addon_id,
            method: 'GET',
            success: function(res) {
                card.removeClass('border-primary');
                card.find('.remove-btn').addClass('d-none');
                console.log('Addon removed:', addon_id);
            },
            error: function(err) {
                console.error(err);
                alert('Failed to remove addon.');
            }
        });
    });


    function updateCartSummary() {
        $.get('/cart/total', function(res) {

            let tbodyHtml = '';
            $('.service_name').text(res.items.service);
            $('.service_price').text(res.items.price);
            let currency = $('#default_currency').val();

            // Loop through addons
            res.items.addons.forEach(addon => {
                tbodyHtml += `
                    <div>
                        <div class="d-flex justify-content-between w-100 small text-muted mb-1">
                            <span>${addon.name}</span>
                            <span>${currency}${addon.price}</span>
                        </div>
                    </div>
                `;
            });

            // Inject as HTML, not text
            $('.addonsData').html(tbodyHtml);

            $('.cart-total').text(res.items.total);
            $('.cart-count').text(res.items.qty);
            $('.cart-subtotal').text(res.items.subtotal);
        });
    }



    // store order records 
    $(document).on('click','#submitCartBtn', function(e) {
        e.preventDefault();
        $.ajax({
            url: "/user/create-ticket/",
            method: "GET",
            success: function(res) {
                console.log(res);
                stepSix(res.id);
                // printTicket(res.id);
                window.open(`/user/ticket/print/${res.id}`, '_blank');
                // setTimeout(function() {
                //     window.location.href = "/";
                // }, 5000);
            },
            error: function(err) {
                console.error(err);
                $('#content-body').html('<div class="col-12 text-center text-danger">Failed to load section </div>');
            }
        });

    });
    
    // store order records 
    $(document).on('click','.skip-btn', function(e) {
        e.preventDefault();

        $.ajax({
            url: '/user/step-five?addon_id=',
            method: "GET",
            success: function(res) {
                $('#content-body').html(res);
                updateCartSummary();
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
    function printTicket(id) {
        fetch("/user/ticket/print/" + id)
            .then(res => res.html())
            .then(data => {
                if (data.success) {
                    alert("Ticket printed successfully!");
                } else {
                    alert("Print failed: " + data.message);
                }
            })
            .catch(err => console.error("Print request failed:", err));
    }


    function updateBarberStatus() {
        $.ajax({
            url: "/user/barbers/status",
            type: "GET",
            success: function(response) {
                response.forEach(function(barber) {
                    $("#waiting-" + barber.id).text(barber.waiting);
                    $("#time-" + barber.id).text(barber.time);
                });
            },
            error: function(xhr) {
                console.error("Error fetching barber status:", xhr);
            }
        });
    }


    // Update every 30 seconds
    setInterval(updateBarberStatus, 30000);

    // Initial load
    updateBarberStatus();


});