<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enable Two Factor Authentication</title>
</head>
<body>
    <h1>Enable Two-Factor Authentication</h1>

    <p>Scan this QR code with the Google Authenticator app:</p>
    <img src="{{ $QRImage }}" alt="QR Code">

    <p>Or enter the secret key manually: {{ $secret }}</p>

    <form action="{{ route('two-factor-verify') }}" method="POST">
        @csrf
        <label for="code">Enter the code from Google Authenticator:</label>
        <input type="text" name="code" required>
        <button type="submit">Verify</button>
    </form>
</body>
</html>
