<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>New Published Report</title>
    <meta charset="utf-8">


</head>
<body>
    <span style="color: #1F497D">Dear {{$user_name}}</span>
    <br><br>
    <span style="color: #1F497D">We’ve just released a new report. Please find the link to the report below as well as key highlights summarized in this email. </span>
    <br><br><br><br>
    <b>
        <span style="color:#1F497D;">
            <a target="_blank" href="http://Production_URL/reports/{{$report->ReportID}}"> {{$report->Title}} ({{$report->Pages}}pgs)</a>
        </span>
    </b>
    <br><br>
    <span style="color: #1F497D; margin-left: 50px">{!! $report->ReportSummary !!} </span>
    <br><br>
    <span style="color: #1F497D">Please let us know if you have any questions or would like a call with our analyst on the name.  </span>
    <br><br><br>
    <span style="color:#E46C0A;">You are receiving this email because of your research subscription preferences.</span>
    <br><br>
    <i>
        <span style="color:#1F497D;">
            <a rel="nofollow noopener noreferrer" target="_blank" href="http://Production_URL/subscriptions/">Click here to amend those preferences to your core interests/holdings.</a>
        </span>
    </i>
    <br><br><br>
    <span style="color:#1F497D;">Kind Regards,</span>
    <br><br>
    <span style="font-size:12.0pt;color:dimgray;">Auerbach Grayson Research Team</span>
    <br><br>
    <span style="font-size:10.0pt;color:dimgray;letter-spacing:.5pt;">Auerbach Grayson &amp; Company</span>
    <br>
    <span style="font-size:10.0pt;color:dimgray;letter-spacing:.5pt;">25 West 45th Street</span>
    <br>
    <span style="font-size:10.0pt;color:dimgray;letter-spacing:.5pt;">New York, NY 10036&nbsp;USA</span>
    <br>
    <span style="font-size:10.0pt;color:dimgray;letter-spacing:.5pt;">Tel.&nbsp; 1-212-453-3571</span>
    <br>
    <span style="font-size:10.0pt;color:dimgray;letter-spacing:.5pt;">Fax. 1-212-557-9066</span>
    <br>
    <span style="color:#1F497D;">
        <a rel="nofollow noopener noreferrer" target="_blank" href="http://www.agco.com/" title="blocked::http://www.agco.com/
http://www.agco.com/">
            <span lang="FR" style="font-size:10.0pt;color:blue;">www.agco.com</span>
        </a>
    </span>
    <br>
    <span style="color:#1F497D;">
        <a rel="noreferrer" target="_blank" href="http://www.agco.com/agco_disclaimer1.aspx" title="blocked::http://www.agco.com/agco_disclaimer1.aspx
http://www.agco.com/agco_disclaimer1.aspx">
            <span style="color:blue;">Research Distribution Disclosure</span>
        </a>
    </span>
    <br><br>
    <span style="color:#1F497D;">To access our research platform on Bloomberg, enter “AGCO”. You can use it to also search by keyword through over 250K reports across 120+ markets.&nbsp;</span>

</body>
</html>
