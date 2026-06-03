<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h1>Hello, {{ $userData['name'] }}!</h1>
    <p>Please click the link below to verify your email address:</p>
    <a href="{{ $userData['verificationUrl'] }}">Verify Email</a>
</body>
</html>