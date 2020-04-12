<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Credentials</title>
    <meta charset="utf-8">
</head>
    <body>
        Email : {{$user->getEmail()}}
        Name : {{$user->getName()}}
        Password : {{$user->getPlainPassword()}}
    </body>
</html>
