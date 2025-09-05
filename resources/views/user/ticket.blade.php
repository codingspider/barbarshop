<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Queue Ticket</title>
    <style>
    body {
        font-family: monospace;
        font-size: 14px;
    }

    .ticket {
        width: 250px;
    }

    .center {
        text-align: center;
    }

    .divider {
        border-top: 1px dashed #000;
        margin: 5px 0;
    }
    </style>
</head>

<body>
    <div class="ticket center">
        <div class="center">
            <h3>{{ env('APP_NAME') }}</h3>
            <p>{{ $data['created_at'] }}</p>
        </div>
        <div class="divider"></div>
        <p><strong>Ticket No:</strong> {{ $data['ticket_no'] }}</p>
        <p><strong>Customer:</strong> {{ $data['customer_name'] }}</p>
        <div class="divider"></div>
        <p class="center">Please wait for your turn</p>
    </div>
</body>

</html>