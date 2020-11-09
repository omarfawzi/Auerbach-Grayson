<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Analyst</title>
    <meta charset="utf-8">
</head>
    <body>
        Hi {{$analyst->Analyst}}
        I would like to pencil in a call with you on one of the following slots:
        <br>
        @foreach ($test_dateTime as $date)
            <p>{{ $date }}</p>
            <br>
        @endforeach
        <br>
        <br>

        @if(!is_null($test_link))
            Conference Link : {{$test_link}}
        @endif
        @if(!is_null($test_message))
            Message : {{$test_message}}
        @endif
    </body>
</html>
