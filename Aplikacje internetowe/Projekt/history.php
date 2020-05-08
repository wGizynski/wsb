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
  <title>WSBank Historia  </title>  
  <link rel="icon" href="imgs/favicon.ico">
  <link rel="stylesheet" href="styles.css">
  <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
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

        <?php include('menu.php') ?>

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
                      <th>ID_karty</th>
                      <th>ID_do</th>
                      <th>Data</th>
                      <th>Ilość</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    require_once "config.php";
                    $sql = "SELECT ID_From, ID_To, data, ilosc FROM transakcje join credit_cards on transakcje.ID_from = credit_cards.Credit_card_ID or transakcje.ID_TO = credit_cards.Credit_card_ID where credit_cards.Credit_card_ID=$_SESSION[Main_card_ID];";
                    $result = mysqli_query($link, $sql);

                    if (mysqli_num_rows($result) > 0) {
                      // output data of each row
                      while ($row = mysqli_fetch_row($result)) {
                        echo "<tr ";
                        foreach ($row as $field => $value) {
                          if ($field == "ID_From") {
                            if ($value == $_SESSION["Main_card_ID"]) {
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

      <?php include ('footer.php'); ?>

    </section>
  </section>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
</body>

</html>