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
    $name = "test";
    $surname = "test";
    echo $name;
    //heredoc
    echo <<<SHOW
         <hr>
         Imię: $name <br>
         Naziwsko: $surname
         <hr>
SHOW;

    $text = <<<SHOW
        <hr>
        Imię: $name <br>
        Naziwsko: $surname
        <hr>s
SHOW;
    ?>
</body>

</html>