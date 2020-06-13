<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>WSbank Rejestracja</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="icon" href="imgs/favicon.ico">
  <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
  <header></header>

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

        <?php
        // Include config file
        require_once "config.php";

        $username = $password = $confirm_password = "";
        $username_err = $password_err = $confirm_password_err = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

          if (empty(trim($_POST["username"]))) {
            $username_err = "Proszę wpisać nazwę użtkownika.";
          } else {
            $sql = "SELECT user_id FROM users WHERE username = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
              mysqli_stmt_bind_param($stmt, "s", $param_username);

              $param_username = trim($_POST["username"]);
              if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                  $username_err = "Nazwa użytkownika jest już zajęta.";
                } else {
                  $username = trim($_POST["username"]);
                }
              } else {
                echo "Oops! Something went wrong. Please try again later.";
              }
              mysqli_stmt_close($stmt);
            }
          }

          // Validate password
          if (empty(trim($_POST["password"]))) {
            $password_err = "Proszę wpisz hasło.";
          } elseif (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Hasło musi mieć conajmniej 6 znaków.";
          } else {
            $password = trim($_POST["password"]);
          }

          if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Proszę potwierdź hasło.";
          } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
              $confirm_password_err = "Hasła nie pasują to siebie.";
            }
          }

          if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $sql2 = "SELECT user_id from users order by created_at desc limit 1";
            $result = mysqli_query($link, $sql2);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_row($result)) {
                echo "<tr ";
                foreach ($row as $field => $value) {
                  $user_id = $value + 1;
                }
              }
            } else $user_id = 1;

            $card_type = $_POST["card_type"];
            $sql3 = "Insert into credit_cards (users_ID, Type, Resources) values ($user_id, $card_type, 1000)";
            mysqli_query($link, $sql3);

            if ($stmt = mysqli_prepare($link, $sql)) {
              mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

              $param_username = $username;
              $param_password = password_hash($password, PASSWORD_DEFAULT);

              if (mysqli_stmt_execute($stmt)) {
                header("location: index.php");
              } else {
                echo "Coś poszło nie tak. Prosze spróbować później";
              }
              mysqli_stmt_close($stmt);
            }
          }
          mysqli_close($link);
        }
        ?>

        <div class="wrapper" style="width:400px; margin-top:20px; margin-left: 10px">
          <h2>Rejestracja</h2>
          <p>Uzupełnij wszystkie informacje by się zarejestrować.</p>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
              <label>Nazwa użytkownika</label>
              <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
              <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
              <label>Hasło</label>
              <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
              <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
              <label>Potwierdź Hasło</label>
              <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
              <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>

            <div class="form-group">
              <label>Rodzaj karty</label> <br>
              <select class="form-control form-control-lg" name="card_type">
                <option value="0">Visa</option>
                <option value="1"> Master Card</option>
              </select>
            </div>

            <div class="form-group">
              <input type="submit" class="btn btn-danger" value="Zarejestruj się">
            </div>
            <p>Masz już konoto? <a href="index.php">Zaloguj się tutaj</a>.</p>
          </form>
        </div>

      </section>
      <section id="mid_right"> </section>
      <?php include('footer.php'); ?>
    </section>
  </section>


</body>

</html>