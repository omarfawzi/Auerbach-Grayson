<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Analyst</title>
    <meta charset="utf-8">
</head>
    <body>
        Hi {{$analyst->Analyst}}
        I would like to arrange a reference call on {{$dateTime}}
        @if(!is_null($link))
            Conference Link : {{$link}}
        @endif
        @if(!is_null($message))
            Message : {{$message}}
        @endif
    </body>
</html>
