<?php
    $webmaster_email = "info@audiven.lt";

    $klaida_page = "klaida.html";
    $aciu_page = "aciu.html";
    $uzsakymas_page = "uzsakymas.html";

    $vardas= $_REQUEST['vardas'] ;
    $pavarde = $_REQUEST['pavarde'] ;
    $elpastas = $_REQUEST['email'] ;
    $telefonas = $_REQUEST['telefonas'] ;
    $miestas = $_REQUEST['miestas'];

    $apvalus100 = $_REQUEST['apvalus100'];
    $apvalus125 = $_REQUEST['apvalus125'];
    $apvalus160 = $_REQUEST['apvalus160'];
    $kvadratinis100 = $_REQUEST['kvadratinis100'];
    $kvadratinis125 = $_REQUEST['kvadratinis125'];
    $kvadratinis160 = $_REQUEST['kvadratinis160'];


    $msg = 
    "Vardas: " . $vardas . "\r\n" . 
    "Pavarde: " . $pavarde . "\r\n" . 
    "Email: " . $elpastas . "\r\n" . 
    "TEL NR: " . $telefonas . "\r\n" . 
    "Miestas: " . $miestas . "\r\n" . 


    "Apvalus100: " . $apvalus100 . "\r\n" . 
    "Apvalus125: " . $apvalus125 . "\r\n" . 
    "Apvalus160: " . $apvalus160 . "\r\n" . 
    "Kvadratinis100: " . $kvadratinis100 . "\r\n" . 
    "Kvadratinis125: " . $kvadratinis125 . "\r\n" . 
    "Kvadratinis160: " . $kvadratinis160; 



    $prisijungimas = new mysqli("localhost", "username", "passwd");

    

    if ($prisijungimas -> query($irasymas)===TRUE){
    echo "Duomenys įrašyti <br>";
    }else {
        echo "Irašyti nepavyko <br>";
    }



    function isInjected($str) {
        $injections = array('(\n+)',
        '(\r+)',
        '(\t+)',
        '(%0A+)',
        '(%0D+)',
        '(%08+)',
        '(%09+)'
        );
        $inject = join('|', $injections);
        $inject = "/$inject/i";
        if(preg_match($inject,$str)) {
            return true;
        }
        else {
            return false;
        }
    }


    // If the user tries to access this script directly, redirect them to the feedback form,
    if (!isset($_REQUEST['email'])) {
    header( "Location: $uzsakymas_page" );
    }
    // /* 
    // If email injection is detected, redirect to the error page.
    // If you add a form field, you should add it here.
    // */
    elseif ( isInjected($elpastas) || isInjected($vardas) ) {
    header( "Location: $klaida_page" );
    }

    // If we passed all previous tests, send the email then redirect to the thank you page.
    else {
        
        $irasymas = "insert into audiven value ('$vardas', '$pavarde', '$elpastas', '$telefonas', '$miestas', '$apvalus100', '$apvalus125', '$apvalus160', '$kvadratinis100', '$kvadratinis125','$kvadratinis160')";
        if ($prisijungimas -> query($irasymas)===TRUE){
            echo "Duomenys įrašyti <br>";
        }else {
            echo "Error: " . $irasymas . "<br>" . mysqli_error($prisijungimas);
        }

        mail( "$webmaster_email", "Naujas uzsakymas nuo: {$telefonas}", $msg );

        header( "Location: $aciu_page" );
    }



    $prisijungimas->close();
?>