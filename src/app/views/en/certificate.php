<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Certificate of completion</title>
    <link rel="shortcut icon" type="image/png" href="<? echo $this->url('src/app/views/images/logo2.jpg'); ?>"/>
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/bootstrap/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aguafina+Script">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aldrich">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alex+Brush">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Architects+Daughter">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/cStyles.css');?>">
</head>

<body style="">
    <div  class="" style="width: 80%;margin-right: 10%;margin-left: 10%;margin-top: 2%; margin-bottom: 2%; height: auto;;background-color: #ffffff;padding: 2%; border: 10px solid transparent; border-image: url(<? echo $this->url("src/app/views/images/border3.png"); ?>) 174 stretch;  border-image-width: 40px;">
        <h1 id="curve" class="text-uppercase text-center" style="font-size: 52px; margin-top: 0px;padding-top: 18px;font-family: Aldrich, sans-serif;">certificate of completion</h1><img class="img-fluid" src="<? echo $this->url('src/app/views/images/logo2.jpg'); ?>" style=" margin-right: auto;margin-left: auto;">
        <h2 class="text-center" style="margin-top: 0px;padding-top: 18px;font-family: Aldrich, sans-serif;">DZ-COURSES administration proudly presents this Certificate of Completion to:&nbsp;</h2>
        <h2 class="text-center" style="margin-top: 0px;padding-top: 18px;font-family: 'Architects Daughter', cursive;"><strong><em><span style="text-decoration: underline;"><? echo strtoupper($certificate->firstname)." ".$certificate->lastname ?></span></em></strong></h2>
        <h2 class="text-center" style="margin-top: 0px;padding-top: 18px;font-family: Aldrich, sans-serif;">For the dedication and hard work that resulted in the successful culmination <strong><em><span style="text-decoration: underline;"><? echo round($certificate->courseTime / 60); ?>Minutes </span></em></strong> of :</h2>
        <h2 class="text-center" style="margin-top: 0px;padding-top: 18px;font-family: 'Architects Daughter', cursive;"><strong><em>
                <span style="text-decoration: underline;"><a href="<? echo $this->url('course'); ?>/<? echo str_replace(' ', '-', $certificate->courseTitle); ?>"><? echo $certificate->courseTitle; ?></a></span></em></strong></h2>
        <h2 class="text-center" style="margin-top: 0px;padding-top: 18px;font-family: Aldrich, sans-serif;">online course .</h2>
        <div class="footer"><img src="<?php echo $this->url('src/app/views/images/Document_35_2-removebg-preview.png');?>" style="width: 258px;">
            <h4>
                <em>
                    <span style="text-decoration: underline;"><? echo $certificate->created_at; ?></span>
                    <small style="opacity: 0.5;">provided by : 
                        <a style="color: black;" href="<? echo $this->url(''); ?>">DZ-COURSES</a>
                
                        <br>online learning platform.</em></h4></small>
        </div>
        <br/>
        <? if($certificate->user_id == $user_id): ?>
            <button id="download" onclick="download()">Download</button>
        <? endif; ?>
    <br/>
    </div>

    <script src="<?php echo $this->url('src/app/views/assets/js/jquery.min.js');?>"></script>
    <script src="<?php echo $this->url('src/app/views/assets/js/jquery.arctext.js');?>"></script>
    <script src="<?php echo $this->url('src/app/views/assets/js/html2canvas.js');?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
    <script src="<?php echo $this->url('src/app/views/assets/bootstrap/js/bootstrap.min.js');?>"></script>
    <script type="text/javascript">
        var $head   = $('#curve').hide();
        $head.show().arctext({radius: 1000});
        function download() {
            $('#download').hide();
            html2canvas(document.body).then(function(canvas) {
                var img = canvas.toDataURL("image/png");
                var doc = new jsPDF();
                doc.addImage(img,"jpeg", 10, 10, 200, 0);
                doc.save('c.pdf');
            });
        }
    </script>
</body>

</html>