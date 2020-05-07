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
  <title>Document</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>
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

        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #c00000; border-radius: 3px;">
          <a class="navbar-brand" style="color:whitesmoke" href="dashboard.php">Dashboard</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" style="color:whitesmoke" href="przelewy.php">Przelewy </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" style="color:whitesmoke" href="#">Doładowania</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" style="color:whitesmoke" href="#">Pomoc i kontakt</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" style="color:whitesmoke" href="history.php">Historia</a>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li> <a href="settings.php" class="nav-link" style="color:whitesmoke"> Ustawienia <img src="imgs/settings.png" width="24px" height="24px"> </a> </li>
              <li><a href="logout.php" class="nav-link" style="color:whitesmoke"> wyloguj sie</a></li>
            </ul>
          </div>
        </nav>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h1 mb-2 text-gray-800" style="margin-top:20px">Historia przelewów</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4" style="margin-top:40px">
            <div class="card-header py-3">
              <h4 style="color:red">Przelewy</h4>
            </div>
            <div class="card-body">
              <div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID_od</th>
                      <th>ID_do</th>
                      <th>Data</th>
                      <th>Ilość</th>
                    </tr>
                  </thead>
                  <tbody>

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

                    $sql = "SELECT ID_From, ID_To, data, ilosc FROM transakcje where $_SESSION[user_id]=ID_From OR $_SESSION[user_id]=ID_To;";
                    $result = mysqli_query($conn, $sql);

                    $sql = "SELECT ID_From, ID_To, data, ilosc FROM transakcje join credit_cards on transakcje.ID_from = credit_cards.Credit_card_ID and transakcje.ID_TO-credit_cards.Credit_card_ID where users_ID=$_SESSION[user_id];";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                      // output data of each row

                      while ($row = mysqli_fetch_row($result)) {
                        echo "<tr ";
                        foreach ($row as $field => $value) {
                          if ($field == "ID_From") {
                            if ($value == $_SESSION["user_id"]) {
                              echo "style='color:red'><td>" . $value . "</td>";
                            } else {
                              echo "style='color:green'><td>" . $value . "</td>";
                            }
                          } else {
                            echo "<td>" . $value . "</td>";
                          }
                        }
                        echo "</tr>";
                      }
                    }
                    mysqli_close($conn);
                    ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->


      </section>
      <section id="mid_right"> </section>
      <section id="footer">
        <section id="footer_left"> </section>
        <section id="footer_middle">
          <p> 2020 © Wielski Super Bank S.A.
            Wielski Super Bank S.A. z siedzibą w Warszawie, przy al. Jana Pawła II 17, 00-854 Warszawa,
            zarejestrowana w Sądzie Rejonowym dla m. st. Warszawy w Warszawie, XII Wydział Gospodarczy Krajowego
            Rejestru Sądowego pod nr KRS 0000008723. NIP 896-000-56-73. REGON 930041341. Wysokość kapitału zakładowego 1
            020 883 050 zł. Wysokość kapitału wpłaconego 1 020 883 050 zł.
            Opłata za połączenie z infolinią banku zgodna z taryfą danego operatora. Słowniczek pojęć i definicji
            dotyczących usług reprezentatywnych, wynikających z rozporządzenia Ministra Rozwoju i Finansów z dnia 14
            lipca 2017 r. w sprawie wykazu usług reprezentatywnych powiązanych z rachunkiem płatniczym, dostępny jest na
            stronie santander.pl/PAD oraz w placówkach banku.
            Santander Bank Polska (dawniej BZ WBK) oferuje m.in.: rachunki płatnicze: konta osobiste (w tym konto dla
            młodych), konta walutowe, konta oszczędnościowe oraz lokaty terminowe, kredyty gotówkowe, kredyty
            hipoteczne, karty debetowe, karty kredytowe, a także fundusze inwestycyjne i ubezpieczenia. W ofercie dla
            firm znajdą Państwo m.in.: konta firmowe, kredyty na bieżącą działalność, kredyty inwestycyjne oraz usługi
            faktoringu i leasingu.
          </p>
          <p>

            Regulamin serwisu
            Polityka prywatności
            Polityka przetwarzania danych osobowych
            Pliki cookie
            Kod SWIFT: WSBPPLPP</p>

        </section>
        <section id="footer_right"> </section>
      </section>
    </section>
  </section>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>


  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
</body>

</html>