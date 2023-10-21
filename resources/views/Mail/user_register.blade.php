<!DOCTYPE html>
<html>

<head>
    <title>New User Registered</title>
</head>

<body>
    <h2>New User Registered</h2>

    <p>Hello Admin,</p>
    <p>A new user has registered on your website with the following details:</p>

    <ul>
        <li><strong>Name:</strong> {{ $userName }}</li>
        <li><strong>Email:</strong> {{ $userEmail }}</li>
    </ul>

    <p>Thank you for your attention.</p>
</body>

</html>
