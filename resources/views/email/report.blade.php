<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>New Published Report</title>
    <meta charset="utf-8">


</head>
<body>
Dear {{$user_name}}
<br>
We just published a new report <i><u><b>{{$report->Title}}</b></u></i> which is of interest to you, link to the report is below
<br>
http://Production_URL/reports/{{$report->ReportID}}
<br>
<br>
Regards,
<br>
AGCO Team
</body>
</html>
