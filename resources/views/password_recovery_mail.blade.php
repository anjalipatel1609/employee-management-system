<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Password Recovery</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
  <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: #333333;">Password Recovery</h2>
    <p style="color: #333333;">Dear {{ $user->employee_name }} !</p>
    <p style="color: #333333;">You've requested a password reset for your account. To proceed, please click the button below:</p>
    <div style="text-align: center; margin-top: 20px;">
      <a href="{{ route('password_reset', $user->id) }}" style="display: inline-block; background-color: #007bff; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Reset Password</a>
    </div>
    <p style="color: #333333; margin-top: 20px;">If you did not request this change, you can safely ignore this email.</p>
    <p style="color: #333333;">Thank you</p>
  </div>
</body>
</html>
