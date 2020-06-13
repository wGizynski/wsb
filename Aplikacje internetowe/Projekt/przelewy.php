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
    <title>WSbank przelew</title>
    <link rel="icon" href="imgs/favicon.ico">
    <link rel="stylesheet" href="styles.css">
    <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>
    <?php
    require_once "config.php";

    $card_id_err = "";
    $adress_err = "";
    $data_err = "";
    $amount_err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Check if username is empty
        if (empty(trim($_POST["card_id"]))) {
            $card_id_err = "Proszę wprowadzić numer karty użytkownika.";
        } else if ($_POST["card_id"] ==  $_SESSION["Main_card_ID"]) {
            $card_id_err = "Nie można utworzyć przelewu na własny rachunek";
        } else {
            $card_id = $_POST["card_id"];
        }

        // Check if password is empty
        if (empty(trim($_POST["adress"]))) {
            $adress_err = "Proszę wprowadzić adres.";
        } else {
            $adress = $_POST["adress"];
        }

        if (empty(trim($_POST["data"]))) {
            $data_err = "Proszę wprowadzić date.";
        } else {
            $rawdate = htmlentities($_POST['data']);
            $data = date("Y-m-d", strtotime($rawdate));
        }

        if (empty(trim($_POST["amount"]))) {
            $amount_err = "Proszę wprowadzić kwote.";
        } else if ($_POST["amount"] > $_SESSION['Resources']) {
            $amount_err = "Nie masz takich środków.";
        } else {
            $amount = $_POST["amount"];
        }


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($card_id_err) && empty($adress_err) && empty($data_err) && empty($amount_err)) {
                $sql3 = "Insert into transakcje (ID_from, ID_TO, DATA, ilosc) values ($_SESSION[Main_card_ID], $card_id, '$data', $amount)  ";
                mysqli_query($link, $sql3);
                $sql4 = "update credit_cards set Resources=(Resources-$amount) where Credit_card_ID = $_SESSION[Main_card_ID]";
                mysqli_query($link, $sql4);
                $sql5 = "update credit_cards set Resources=(Resources+$amount) where Credit_card_ID = $card_id";
                mysqli_query($link, $sql5);
                $_SESSION['Resources'] = ($_SESSION['Resources']- $amount);  
                $Resources=$Resources-$amount;
                header("location: dashboard.php");
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
                        <h3>Przelew</h3>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div style="width:50%; margin-left:auto; margin-right:auto">

                                <div class="form-group <?php echo (!empty($card_id_err)) ? 'has-error' : ''; ?>">
                                    <input type="text" name="card_id" class="form-control" placeholder="nr karty odbiorcy *">
                                    <span class="help-block"><?php echo $card_id_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($adress_err)) ? 'has-error' : ''; ?>">
                                    <input type="text" name="adress" class="form-control" placeholder="Adres *">
                                    <span class="help-block"><?php echo $adress_err; ?></span>
                                </div>

                                <div class="form-group <?php echo (!empty($amount_err)) ? 'has-error' : ''; ?>">
                                    <input type="text" name="amount" class="form-control" placeholder="Kwota *">
                                    <?php echo $amount_err; ?></span>
                                </div>

                                <div class="form-group <?php echo (!empty($data_err)) ? 'has-error' : ''; ?>">
                                    <input type="date" name="data" class="form-control">
                                    <?php echo $data_err; ?></span>
                                </div>

                                <input type="submit" class="btnSubmit" value="Wykonaj">
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