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

        // Define variables and initialize with empty values
        $username = $password = $confirm_password = "";
        $username_err = $password_err = $confirm_password_err = "";

        // Processing form data when form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

          // Validate username
          if (empty(trim($_POST["username"]))) {
            $username_err = "Proszę wpisać nazwę użtkownika.";
          } else {
            // Prepare a select statement
            $sql = "SELECT user_id FROM users WHERE username = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "s", $param_username);

              // Set parameters
              $param_username = trim($_POST["username"]);

              // Attempt to execute the prepared statement
              if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                  $username_err = "Nazwa użytkownika jest już zajęta.";
                } else {
                  $username = trim($_POST["username"]);
                }
              } else {
                echo "Oops! Something went wrong. Please try again later.";
              }

              // Close statement
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

          // Validate confirm password
          if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Proszę potwierdź hasło.";
          } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
              $confirm_password_err = "Hasła nie pasują to siebie.";
            }
          }

          // Check input errors before inserting in database
          if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

            // Prepare an insert statement
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

              // Set parameters
              $param_username = $username;
              $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

              // Attempt to execute the prepared statement
              if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: index.php");
              } else {
                echo "Coś poszło nie tak. Prosze spróbować później";
              }

              // Close statement
              mysqli_stmt_close($stmt);
            }
          }

          // Close connection
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
              <input type="submit" class="btn btn-danger" value="Zarejestruj się">
            </div>
            <p>Masz już konoto? <a href="index.php">Zaloguj się tutaj</a>.</p>
          </form>
        </div>

      </section>
      <section id="mid_right"> </section>
      <?php include ('footer.php'); ?>
    </section>
  </section>


</body>

</html>