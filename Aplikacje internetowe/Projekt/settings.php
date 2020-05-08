<?php
session_start();
if (isset($_SESSION['user_id'])) {
} else {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WSBank ustawienia</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="imgs/favicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

</head>

<body>
    <?php
    require_once "config.php";

    $Imie_err = "";
    $Nazwisko_err = "";
    $succes = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Check if username is empty
        if (empty(trim($_POST["Imie"]))) {
            $Imie_err = "Proszę wprowadzić imię użytkownika.";
        } else {
            $Imie = $_POST["Imie"];
        }

        if (empty(trim($_POST["Nazwisko"]))) {
            $Nazwisko_err = "Proszę wprowadzić nazwisko użytkownika.";
        } else {
            $Nazwisko = $_POST["Nazwisko"];
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($Imie_err) && empty($Nazwisko_err)) {
                $sql = "update users set Imie='$Imie', Nazwisko='$Nazwisko' where user_id = $_SESSION[user_id]";
                $_SESSION['Imie'] = $Imie;
                $_SESSION['Nazwisko'] = $Nazwisko;
                $wybik = mysqli_query($link, $sql);
                $succes = "Dane zostały zmodyfikowane";
            }
        }
    }
    ?>

    <header></header>
    <section id="content">
        <section id="top">
            <section id="top_left"> </section>
            <section id="top_middle"> <a href="index.php"> <img src="imgs/banner2.jpg"></a> </section>
            <section id="top_right"> </section>
        </section>

        <section id="mid">
            <section id="mid_left"> </section>
            <section id="middle">

                <?php include('menu.php') ?>

                <div class="container login-container" style="float: left; width: 100%; max-width: 1270px;">
                    <div class="col-md-6 login-form-1" style="max-width: 100%;">
                        <h3>Ustawienia konta</h3>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div style="width:50%; margin-left:auto; margin-right:auto">

                                <div class="form-group <?php echo (!empty($Imie_err)) ? 'has-error' : ''; ?>">
                                    <a> Imie </a> <input type="text" name="Imie" class="form-control" placeholder=<?php echo $_SESSION['Imie'] ?>>
                                    <span class="help-block"><?php echo $Imie_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($Nazwisko_err)) ? 'has-error' : ''; ?>">
                                    <a> Nazwisko </a> <input type="text" name="Nazwisko" class="form-control" placeholder=<?php echo $_SESSION['Nazwisko'] ?>>
                                    <span class="help-block"><?php echo $Nazwisko_err; ?></span>
                                </div>

                                <input type="submit" class="btnSubmit" value="Wykonaj">
                                <br> <span class="help-block"><?php echo $succes; ?></span>
                            </div>
                        </form>
                    </div>
                </div>

            </section>
            <section id="mid_right"> </section>
            <?php include ('footer.php'); ?>
        </section>
    </section>
</body>

</html>