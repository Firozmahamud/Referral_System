<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> </title>
</head>
<body>

    <p>Hi {{ $data['name'] }},
    welcome to referal system !
    </p>

    <p> <b>Username:-</b>{{ $data['email'] }}</p>
    <p> <b>Password:-</b>{{ $data['password'] }}</p>
    <p>you can add users to your <a href="{{ $data['url'] }}">Referral Link</a></p>

    <p>Thank you ! </p>
</body>
</html>
