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
    <title>WSBank</title>
    <link rel="icon" href="imgs/favicon.ico">
    <link rel="stylesheet" href="styles.css">
    <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "WSBank";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT sum(ilosc) FROM transakcje where $_SESSION[user_id]=ID_To and MONTH(data) = MONTH(CURRENT_DATE())
    AND YEAR(data) = YEAR(CURRENT_DATE());";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_row($result)) {
            foreach ($row as $field => $value) {
                if ($value != "") $_SESSION["wplywy"] = $value;
                else $_SESSION["wplywy"] = 0;
            }
        }
    } else $_SESSION["wplywy"] = "0 zł";

    $sql2 = "SELECT sum(ilosc) FROM transakcje where $_SESSION[user_id]=ID_From and MONTH(data) = MONTH(CURRENT_DATE())
    AND YEAR(data) = YEAR(CURRENT_DATE());";
    $result2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($result2) > 0) {
        while ($row = mysqli_fetch_row($result2)) {
            foreach ($row as $field => $value) {
                if ($value != "") $_SESSION["wyplywy"] = $value;
                else $_SESSION["wyplywy"] = 0;
            }
        }
    } else $_SESSION["wyplywy"] = "0 zł";

    $sql3 = "SELECT Type, Resources, create_date, Credit_card_ID  FROM credit_cards where $_SESSION[user_id]=users_ID;";
    $result3 =  mysqli_query($conn, $sql3);

    $sql4 = "SELECT Resources from credit_cards where credit_cards.Credit_card_ID=$_SESSION[Main_card_ID] LIMIT 1;";
    $result4 =  mysqli_query($conn, $sql4);
    if (mysqli_num_rows($result4) > 0) {
        $row = mysqli_fetch_row($result4);
        foreach ($row as $field => $value) {
            $Resources = $value;
            $_SESSION['Resources'] = $Resources;
        }
    } else $Resources = 0;

    if (isset($_POST['submit'])) {
        $_SESSION["Main_card_ID"] = $_POST['submit'];
        $sql5 = "Update users set Main_card_ID=$_POST[submit] where $_SESSION[user_id]=users.user_id";
        mysqli_query($conn, $sql5);

        header("location: index.php");
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

                <div class="row" style="margin-top:20px; margin-left:5px">
                    <h1> <span class="badge badge-warning" style="color:white">Twój Panel</span></h1>

                </div>
                <div style="margin-left:5px">
                    <a class="badge badge-primary" style="color:white">#pieniadze</a>
                    <a class="badge badge-success" style="color:white">#konto</a>
                    <a class="badge badge-danger" style="color:white">#bank</a>
                    <a class="badge badge-info" style="color:white">#kredyt</a>
                    <a class="badge badge-dark" style="color:white">#wsbank</a>
                </div>

                <div class="row" style="margin-top:20px">

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Stan konta</div>
                                        <div class="h5 mb-0 font-weight-bold text-primary-800"><?php echo $Resources . " zł"; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success    text-uppercase mb-1">Wpływy (ten miesiąc)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $_SESSION["wplywy"] . " zł"; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Wydatki (ten miesiąc)</div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $_SESSION["wyplywy"] . " zł"; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Różnica (ten miesiąc)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo ($_SESSION["wplywy"] - $_SESSION["wyplywy"]) . " zł"; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <!-- Area Chart -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Twoje karty</h6>
                            </div>
                            <!-- Card Body -->
                            <?php
                            if (mysqli_num_rows($result3) > 0) {
                                while ($row = mysqli_fetch_row($result3)) {
                                    echo "<div class='card-header py-3 d-flex flex-row align-items-center justify-content-between'>";
                                    foreach ($row as $field => $value) {
                                        if ($field == 0) {
                                            if ($value == 0) echo "<div class='visa_card'> </div> <div class='card_name'> VISA </div>";
                                            else echo "<div class='master_card'> </div> <div class='card_name'> MASTER CARD </div>";
                                        } else if ($field == 1) {
                                            echo "<div class='card_info'> Środki: <br> $value <br> ";
                                        } else if ($field == 2) {
                                            echo "Data utworzenia: <br> $value </div>";
                                        } else {
                                            if ($value == $_SESSION["Main_card_ID"]) echo "<div class='card_info'>  używasz <br><br> <br>id karty: $value <br> </div>";
                                            else echo " 
                                            <div class='card_info'> 
                                                 <form method='POST'> 
                                                    <button class='btn btn-primary' type='submit' onclick='change_card($value)' name='submit' value=$value> zmien </button>
                                                </form> 
                                                <br> id karty: $value  </div>";
                                        }
                                    }
                                    echo "</div>";
                                }
                            } ?>
                        </div>
                    </div>

                    <!-- Pie Chart -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Dropdown Header:</div>
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="myPieChart"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-primary"></i> Direct
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-success"></i> Social
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-info"></i> Referral
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
            <section id="mid_right"> </section>
            <?php include('footer.php'); ?>
        </section>
    </section>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-pie-demo.js"></script>
</body>

</html>