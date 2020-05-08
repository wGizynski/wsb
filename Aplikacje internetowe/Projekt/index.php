<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>WSBank</title>
  <link rel="icon" href="imgs/favicon.ico">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>

<body>

  <header></header>

  <?php
  session_start();

  if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: dashboard.php");
    exit;
  }

  require_once "config.php";

  $username = $password = "";
  $username_err = $password_err = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
      $username_err = "Proszę wprowadzić nazwę użytkownika.";
    } else {
      $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
      $password_err = "Proszę wprowadzić hasło.";
    } else {
      $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
      $sql = "SELECT user_id, username, srodki, Imie, Nazwisko, Main_card_ID, password FROM users WHERE username = ?";

      if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_username);

        $param_username = $username;

        if (mysqli_stmt_execute($stmt)) {

          mysqli_stmt_store_result($stmt);

          if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $user_id, $username, $srodki, $Imie, $Nazwisko, $Main_card_ID, $hashed_password);
            if (mysqli_stmt_fetch($stmt)) {
              if (password_verify($password, $hashed_password)) {
                session_start();

                $_SESSION["loggedin"] = true;
                $_SESSION["user_id"] = $user_id;
                $_SESSION["login_user"] = $username;
                $_SESSION["srodki"] = $srodki;
                $_SESSION["Imie"] = $Imie;
                $_SESSION["Nazwisko"] = $Nazwisko;
                $_SESSION["Main_card_ID"] = $Main_card_ID;

                header("location: dashboard.php");
              } else {
                $password_err = "Wprowadzone hasło jest nieprawidłowe.";
              }
            }
          } else {
            $username_err = "Nie znaleziono takiego konta.";
          }
        } else {
          echo "Oops! Coś poszło nie tak. Proszę spróbować później.";
        }
        mysqli_stmt_close($stmt);
      }
    }
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

        <?php include('menu.php') ?>

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

        <?php include('news.php'); ?>

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
      <?php include('footer.php'); ?>
    </section>
  </section>


</body>

</html>