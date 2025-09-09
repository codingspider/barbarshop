<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
<!-- Thermal Print : End -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Waiting Ticket</title>
    <style>
        body {
            font-family: 'Calibri', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .ticket-wrapper {
            width: 75mm; /* Thermal 80mm paper with margins */
            padding: 5px;
            text-align: center;
        }

        .ticket-header img {
            max-width: 80px;
            height: auto;
            margin: 0 auto;
            display: block;
        }

        .ticket-header h2 {
            margin: 5px 0 0 0;
            font-size: 18px;
        }

        .ticket-header p {
            margin: 2px 0 5px 0;
            font-size: 12px;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .ticket-details p {
            margin: 3px 0;
            font-size: 14px;
        }

        .ticket-details .ticket-no {
            font-size: 24px;
            font-weight: bold;
            margin: 5px 0;
        }

        .ticket-footer p {
            margin: 3px 0;
            font-size: 12px;
        }

        .thank-you {
            margin-top: 10px;
            font-weight: bold;
            font-size: 14px;
        }
    </style>

</head>
<!-- Thermal 80mm : START -->

<body>
    <div class="ticket-wrapper">
        <!-- Header -->
        <div class="ticket-header">
            <img src="{{ $siteLogo }}" alt="Site Logo">
            <h2>{{ env('APP_NAME') }}</h2>
            <p>{{ $data['created_at'] }}</p>
        </div>

        <div class="divider"></div>

        <!-- Ticket Details -->
        <div class="ticket-details">
            <p class="ticket-no">#{{ $data['ticket_no'] }}</p>
        </div>

        <div class="divider"></div>

        <!-- Message -->
        <div class="ticket-footer">
            <p>Please wait for your turn</p>
            <p class="thank-you">Thank you for visiting!</p>
        </div>
    </div>
</body>
</html>