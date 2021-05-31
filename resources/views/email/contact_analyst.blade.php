<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Analyst</title>
    <meta charset="utf-8">
</head>
    <body>
    <span style="color: #1F497D; font-family: calibri; font-size: 11pt;">Hi, </span>
    <br><br>

    @if(!empty($test_dateTime))
        <span style="color: #1F497D; font-family: calibri; font-size: 11pt;"> i would like to schedule a call with you, please find my available time slots </span>
        <br><br>

        @foreach ($test_dateTime as $date)
            <p>{{ $date }}</p>
        @endforeach
        @if(!empty($test_link))
            <span style="color: #1F497D; font-family: calibri; font-size: 11pt;"> Conference Link : {{$test_link}} </span>
        @endif
        <br>
        @if(!is_null($test_message))
            <span style="color: #1F497D; font-family: calibri; font-size: 11pt;"> <br> Client Message : {{$test_message}} </span>
        @endif

    @else
        @if(!is_null($test_message))
            <span style="color: #1F497D; font-family: calibri; font-size: 11pt;"> {{$test_message}} </span>
        @endif
    @endif
    <br><br>
    <span style="color:#1F497D; font-family: calibri; font-size: 11pt;">Kind Regards,</span>
    </body>
</html>
