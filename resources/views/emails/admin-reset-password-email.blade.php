<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #dddddd;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
        }

        .body {
            padding: 20px 0;
            text-align: center;
        }

        .body p {
            font-size: 16px;
            color: #555555;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #007BFF;
            text-decoration: none;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #dddddd;
            color: #999999;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reset Your Password</h1>
        </div>
        <div class="body">
            <p>Hello {{ $name }},</p>
            <p>You requested to reset your password. Please click the button below to reset it:</p>
            <a href="{{ $link }}" class="button">Reset Password</a>
            <p>If you did not request a password reset, please ignore this email or contact support if you have
                questions.</p>
        </div>
        <div class="footer">
            <p>Thank you,<br>The YourApp Team</p>
        </div>
    </div>
</body>
</html>