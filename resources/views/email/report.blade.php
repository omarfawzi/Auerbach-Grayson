<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>New Published Report</title>
    <meta charset="utf-8">
</head>
<body>
    <span style="color: #1F497D; font-family: calibri; font-size: 11pt;">Dear {{$user_name}}</span>
    <br><br>
    <span style="color: #1F497D; font-family: calibri; font-size: 11pt;">We’ve just released a new report. Please find the link to the report below as well as key highlights summarized in this email. </span>
    <br><br>
    <b>
        <span style="color:#1F497D; font-family: calibri; font-size: 11pt;">
            <a target="_blank" href="https://researchportal.agco.com/reports/{{$report->ReportID}}"> {{$report->report_title}} ({{$report->Pages}}pgs)</a>
        </span>
    </b>
    <br><br>
    <div style="color: #1F497D; width:100%; font-family: calibri; font-size: 11pt;">{!! $report->ReportSummary !!} </div>
    <br>
    <span style="color: #1F497D; font-family: calibri; font-size: 11pt;">Please let us know if you have any questions or would like a call with our analyst on the name.  </span>
    <br><br>
    <span style="color:#E46C0A; font-family: calibri; font-size: 11pt;">You are receiving this email because of your research subscription preferences.</span>
    <br>
    <i>
        <span style="color:#1F497D; font-family: calibri; font-size: 11pt;">
            <a rel="nofollow noopener noreferrer" target="_blank" href="https://researchportal.agco.com/my-subscriptions/">Click here to amend those preferences to your core interests/holdings.</a>
        </span>
    </i>
    <br><br>
    <span style="color:#1F497D; font-family: calibri; font-size: 11pt;">Kind Regards,</span>
    <br><br>
    <span style="font-size:12.0pt;color:dimgray; font-family: arial;">Auerbach Grayson Research Team</span>
    <br>

    <span>
        <img src="{{ $message->embed(base_path() . '/public/logo.jpeg') }}" style="" />
    </span>


    <br><br>
    <span style="font-size:10.0pt;color:dimgray;letter-spacing:.5pt;font-family: arial;">Auerbach Grayson &amp; Company</span>
    <br>
    <span style="font-size:10.0pt;color:dimgray;letter-spacing:.5pt;font-family: arial;">25 West 45th Street</span>
    <br>
    <span style="font-size:10.0pt;color:dimgray;letter-spacing:.5pt;font-family: arial;">New York, NY 10036&nbsp;USA</span>
    <br>
    <span style="font-size:10.0pt;color:dimgray;letter-spacing:.5pt;font-family: arial;">Tel.&nbsp; 1-212-453-3571</span>
    <br>
    <span style="font-size:10.0pt;color:dimgray;letter-spacing:.5pt;font-family: arial;">Fax. 1-212-557-9066</span>
    <br>
    <span style="color:#1F497D;font-family: arial;">
        <a rel="nofollow noopener noreferrer" target="_blank" href="http://www.agco.com/" title="blocked::http://www.agco.com/
http://www.agco.com/">
            <span lang="FR" style="font-size:10.0pt;color:blue;font-family: arial;">www.agco.com</span>
        </a>
    </span>
    <br>
    <span style="color:#1F497D;font-family: arial;">
        <a rel="noreferrer" target="_blank" href="http://www.agco.com/agco_disclaimer1.aspx" title="blocked::http://www.agco.com/agco_disclaimer1.aspx
http://www.agco.com/agco_disclaimer1.aspx">
            <span style="color:blue;font-family: arial;">Research Distribution Disclosure</span>
        </a>
    </span>
    <br><br>
    <span style="color:#1F497D;font-family: arial; font-size: 10pt;">To access our research platform on Bloomberg, enter “AGCO”. You can use it to also search by keyword through over 250K reports across 120+ markets.&nbsp;</span>

</body>
</html>
