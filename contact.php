<?php 
require_once('./config.php');
?>

<html>
    <head>
        <title> Contact </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
            Contact page
            <br>
            Email: <a href="mailto:victor.toporan@student.upt.ro"> support@floofs.com </a>
            <br>
            Phone: <a href="tel:+40712345678"> +40 412-FLOOFS-400 </a>
            <br>
            Location: 
            <br>
            <div class="mapouter">
            <div class="gmap_canvas">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1137.3044984704547!2d21.22434289859076!3d45.7462704780722!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47455d8303f55439%3A0xbe8d0248f81cb2a9!2sFacultatea%20de%20Electronic%C4%83%2C%20Telecomunica%C8%9Bii%20%C8%99i%20Tehnologii%20Informa%C8%9Bionale!5e0!3m2!1sro!2sro!4v1641729030479!5m2!1sro!2sro" width="600" height="600" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>        
            </div>
            </div>
	</body>
</html>

<?php
mysqli_close($link);
