<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- IMPORTANT: CSRF Token for security -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Notifier</title>
    <style>
        body { font-family: system-ui, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f1f5f9; }
        .container { text-align: center; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        button { background-color: #ef4444; color: white; border: none; padding: 15px 30px; font-size: 16px; border-radius: 8px; cursor: pointer; transition: background-color 0.3s; }
        button:hover { background-color: #dc2626; }
        #status { margin-top: 20px; font-size: 14px; height: 20px; color: #16a34a; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Notify via Telegram</h1>
        <p>This button will trigger a Laravel endpoint, which calls a Python service!</p>
        <button id="notifyBtn">Send Telegram Alert</button>
        <div id="status"></div>
    </div>

    <script>
        document.getElementById('notifyBtn').addEventListener('click', function() {
            const statusDiv = document.getElementById('status');
            statusDiv.textContent = 'Sending...';

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // This fetch call goes to our LARAVEL route
            fetch('{{ route("notify.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Laravel requires this for POST requests
                },
                body: JSON.stringify({
                    message: "🔥 Urgent alert from the Laravel Website!"
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                statusDiv.textContent = data.message;
            })
            .catch((error) => {
                console.error('Error:', error);
                statusDiv.style.color = 'red';
                statusDiv.textContent = 'An error occurred.';
            });
        });
    </script>
</body>
</html>
