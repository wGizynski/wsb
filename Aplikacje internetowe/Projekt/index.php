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

  <?php
  // Initialize the session
  session_start();

  // Check if the user is already logged in, if yes then redirect him to welcome page
  if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: dashboard.php");
    exit;
  }

  // Include config file
  require_once "config.php";

  // Define variables and initialize with empty values
  $username = $password = "";
  $username_err = $password_err = "";

  // Processing form data when form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
      $username_err = "Proszę wprowadzić nazwę użytkownika.";
    } else {
      $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
      $password_err = "Proszę wprowadzić hasło.";
    } else {
      $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
      // Prepare a select statement
      $sql = "SELECT user_id, username, srodki, password FROM users WHERE username = ?";

      if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        // Set parameters
        $param_username = $username;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
          // Store result
          mysqli_stmt_store_result($stmt);

          // Check if username exists, if yes then verify password
          if (mysqli_stmt_num_rows($stmt) == 1) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $user_id, $username, $srodki, $hashed_password);
            if (mysqli_stmt_fetch($stmt)) {
              if (password_verify($password, $hashed_password)) {
                // Password is correct, so start a new session
                session_start();

                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["user_id"] = $user_id;
                $_SESSION["login_user"] = $username;
                $_SESSION["srodki"] = $srodki;

                // Redirect user to welcome page
                header("location: dashboard.php");
              } else {
                // Display an error message if password is not valid
                $password_err = "Wprowadzone hasło jest nieprawidłowe.";
              }
            }
          } else {
            // Display an error message if username doesn't exist
            $username_err = "Nie znaleziono takiego konta.";
          }
        } else {
          echo "Oops! Coś poszło nie tak. Proszę spróbować później.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
      }
    }

    // Close connection
    mysqli_close($link);
  }
  require_once "config.php";
  ?>



  <section id="content">
    <section id="top">
      <section id="top_left"> </section>
      <section id="top_middle"> <a href="index.php"> <img src="imgs/banner.jpg"></a> </section>
      <section id="top_right"> </section>
    </section>

    <section id="mid">
      <section id="mid_left"> </section>
      <section id="middle">

        <nav class="navbar navbar-expand-lg navbar-light" style="margin-left: 10px; background-color: #c00000; border-radius: 3px;">
          <a class="navbar-brand" style="color:whitesmoke" href="#">Nowości</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" style="color:whitesmoke" href="#">Oferta <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" style="color:whitesmoke" href="#">Promocje</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" style="color:whitesmoke" href="#">Pomoc i kontakt</a>
              </li>
            </ul>
          </div>
        </nav>

        <div class="container login-container" style="float: left; width: 100%; max-width: 570px;">
          <div class="col-md-6 login-form-1" style="max-width: 100%;">
            <h3>Zaloguj się do banku</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input type="text" name="username" class="form-control" placeholder="Twój login *" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="password" class="form-control" placeholder="Twoje hasło *">
                <span class="help-block"><?php echo $password_err; ?></span>
              </div>
              <div class="form-group">
                <input type="submit" c class="btnSubmit" value="Login">
              </div>
              <p>Nie masz jeszcze konta? <a href="register.php">zarejestruj się</a>.</p>
            </form>
          </div>
        </div>

        </div>


        <div class="col-md-6 offset-md-3" style="float: left; width: 50%; margin: 0em;  padding: 1em; max-height: 100%; ">
          <div class="container mt-5 mb-5">
            <h4>komunikaty</h4>
            <ul class="timeline">
              <li>
                <a href="#" href="#">Drogi studencie!</a>
                <a href="#" class="float-right">24 kwiecień 2020</a>
                <p>Brakuje Ci pieniędzy? Opłata za studia zabiera całą Twoją wypłate i nie stać Cię na najmniejsze
                  przyjemności?
                  Przygotowaliśmy dla Ciebie specjalną ofertę pożyczki....</p>
              </li>
              <li>
                <a href="#">100 zł za założenie konta</a>
                <a href="#" class="float-right">12 marzec 2020</a>
                <p>Dołącz do nas już teraz i zyskaj 100zł extra za darmo!...</p>
              </li>
              <li>
                <a href="#">Zupełenie randomowe wyrazy</a>
                <a href="#" class="float-right">05 luty 2020</a>
                <p>Bułka, kiebłasa, krety, szczotka, telefon, nośniki danych, data, auto, stożek, trawa,
                  pszczółki, septagon, octagon, dokąd nocą tupta jeż? wiesz? nie wiesz...</p>
              </li>
            </ul>
          </div>
        </div>
        <div class="container cta-100 " style="float:left">
          <div class="container">
            <div class="row blog">
              <div class="col-md-12">
                <div id="blogCarousel" class="carousel slide container-blog" data-ride="carousel">

                  <!-- Carousel items -->
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="item-box-blog">
                            <div class="item-box-blog-image">
                              <!--Date-->
                              <div class="item-box-blog-date bg-blue-ui white"> <span class="mon">STY 21</span>
                              </div>
                              <!--Image-->
                              <figure> <img alt="" src="imgs/blog1.jpg">
                              </figure>
                            </div>
                            <div class="item-box-blog-body">
                              <!--Heading-->
                              <div class="item-box-blog-heading">
                                <a href="#" tabindex="0">
                                  <h5>Wakacje 2020</h5>
                                </a>
                              </div>
                              <!--Text-->
                              <div class="item-box-blog-text">
                                <p>Lorem ipsum dolor sit amet, adipiscing. Lorem ipsum dolor sit amet, consectetuer
                                  adipiscing. Lorem ipsum dolor sit amet, adipiscing. Lorem ipsum dolor sit amet,
                                  adipiscing. Lorem ipsum dolor sit amet, consectetuer adipiscing. Lorem ipsum dolor.
                                </p>
                              </div>
                              <div class="mt"> <a href="#" tabindex="0" class="btn bg-blue-ui white read">read
                                  more</a> </div>
                              <!--Read More Button-->
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="item-box-blog">
                            <div class="item-box-blog-image">
                              <!--Date-->
                              <div class="item-box-blog-date bg-blue-ui white"> <span class="mon">LUT 21</span>
                              </div>
                              <!--Image-->
                              <figure> <img alt="" src="imgs/blog2.jpg">
                              </figure>
                            </div>
                            <div class="item-box-blog-body">
                              <!--Heading-->
                              <div class="item-box-blog-heading">
                                <a href="#" tabindex="0">
                                  <h5>Twoja emerytura</h5>
                                </a>
                              </div>
                              <!--Text-->
                              <div class="item-box-blog-text">
                                <p>Lorem ipsum dolor sit amet, adipiscing. Lorem ipsum dolor sit amet, consectetuer
                                  adipiscing. Lorem ipsum dolor sit amet, adipiscing. Lorem ipsum dolor sit amet,
                                  adipiscing. Lorem ipsum dolor sit amet, consectetuer adipiscing. Lorem ipsum dolor.
                                </p>
                              </div>
                              <div class="mt"> <a href="#" tabindex="0" class="btn bg-blue-ui white read">read
                                  more</a> </div>
                              <!--Read More Button-->
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="item-box-blog">
                            <div class="item-box-blog-image">
                              <!--Date-->
                              <div class="item-box-blog-date bg-blue-ui white"> <span class="mon">MAR 12</span>
                              </div>
                              <!--Image-->
                              <figure> <img alt="" src="imgs/blog3.jpg">
                              </figure>
                            </div>
                            <div class="item-box-blog-body">
                              <!--Heading-->
                              <div class="item-box-blog-heading">
                                <a href="#" tabindex="0">
                                  <h5>Pożyczka 0%</h5>
                                </a>
                              </div>
                              <!--Text-->
                              <div class="item-box-blog-text">
                                <p>Lorem ipsum dolor sit amet, adipiscing. Lorem ipsum dolor sit amet, consectetuer
                                  adipiscing. Lorem ipsum dolor sit amet, adipiscing. Lorem ipsum dolor sit amet,
                                  adipiscing. Lorem ipsum dolor sit amet, consectetuer adipiscing. Lorem ipsum dolor.
                                </p>
                              </div>
                              <div class="mt"> <a href="#" tabindex="0" class="btn bg-blue-ui white read">read
                                  more</a> </div>
                              <!--Read More Button-->
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--.row-->
                    </div>
                    <!--.item-->
                  </div>
                  <!--.carousel-inner-->
                </div>
                <!--.Carousel-->
              </div>
            </div>
          </div>
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


</body>

</html>