<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Credentials</title>
    <meta charset="utf-8">
</head>
<body>
Dear {{$user->getName()}}
<br>
<br>

<i>Welcome to AGCO AI powered research portal</i>
<br>
<br>
The Portal has all the published research as well as a customised page for the reports / companies that are of interest to you. Kindly enter below a user name & a password as shown below
<br>
<br>
<b><i>Email :</i></b> {{$user->getEmail()}}
<br>

<b><i>Password :</i></b> {{$user->getPlainPassword()}}
<br>
<br>

</body>
Regards,
<br>
AGCO Support Team.

</html>
