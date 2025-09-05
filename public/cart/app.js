$(document).ready(function() {
    // Open modal
    $('#addCustomerBtn').click(function() {
        $('#addCustomerModal').modal('show');
    });

    // Submit form via AJAX
    $('#addCustomerForm').submit(function(e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/user/cutomer-store",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                // Append new customer to select
                $('#customerSelect').append(
                    `<option value="${response.id}" selected>${response.name} ${response.phone} </option>`
                );

                // Close modal
                $('#addCustomerModal').modal('hide');

                // Optional: reset form
                $('#addCustomerForm')[0].reset();
            },
            error: function(xhr) {
                alert('Error adding customer.');
            }
        });
    });
   



});
