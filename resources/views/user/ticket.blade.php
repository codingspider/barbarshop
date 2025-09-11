<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Print Ticket</title>
</head>
<body>
<script>
    window.onload = function() {
        // Trigger RawBT print
        window.location.href = "rawbt:base64,{{ $payload }}";

        // Redirect to home after a short delay (e.g., 2 seconds)
        setTimeout(function() {
            window.location.href = "/";
        }, 2000);
    }
</script>
</body>
</html>
