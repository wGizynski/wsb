<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <?php
    $potega=2**10;
    echo $potega,"<br>";

    //systemy bitowe
    $int = 10;
    $hex=0xA;
    $oct=012;
    $bin=0b1011;

    echo $int,"<br>";
    echo $hex,"<br>";
    echo $oct,"<br>";
    echo $bin,"<br>";

    // echo phpinfo();


    $x=1;
    $y=1.0;

    $wynik = ($x==$y) ?  "rowny <br>" :  "nie rwowny <br>";
    echo $wynik;
    

    $wynik = ($x===$y) ?  "identyczny <br>" :  "nieidentyczny <br>";
    echo $wynik;

    echo gettype($x),"<br>";
    echo gettype($y),"<br>";

    $text = "12123dsds";
    $x = (int)$text;
    echo $x;

    echo "<BR>";
    $x = 10;
    echo is_int($x);

    // $_GET, $_SET, $_Cookie, $_$session, $_server
    echo "<Br>";
    echo "Server_PORT: " , $_SERVER['SERVER_PORT'],"<BR>";
    echo "SERVER_NAME: " , $_SERVER['SERVER_NAME'],"<BR>";
    echo "SCRIPT_NAME: " , $_SERVER['SCRIPT_NAME'],"<BR>";
    echo "DOCUMENT_ROOT: " , $_SERVER['DOCUMENT_ROOT'],"<BR>";

    //nazwa stalej z duzej litery
    define("NAME", "Janusz");
    echo NAME;
    define("surname", "FIGIEL", true);
    echo surname;
    define("surname2", "FIGIEL", false);
    echo surname2;

    //stale predefinowane 
    echo "<Br>";
    echo PHP_VERSION;

    ?>

   
</body>

</html>