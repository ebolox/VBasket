<?php
  include('logic.php');

  $login_failed = false;

  // Recupera i dati dalla form di login
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query per verificare le credenziali dell'utente nel database
    $sql = "SELECT * FROM accounts WHERE (email='$username' OR phone='$username') AND password='$password'";
    $result = $db_conn->query($sql);

    if (isset($result) || $result->num_rows < 1) {
      $login_failed = true;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Valdicornia Basket</title>

<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

  <link rel="shortcut icon" type="image/png" href="assets/images/logo_big.jpg">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="ext/fontawesome-free-6.4.2-web/css/fontawesome.css">

  <link rel="stylesheet" href="assets/stylesheets/ui.css">
  <link rel="stylesheet" href="assets/stylesheets/login.css">

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<?php
  if ((isset($result) && $result->num_rows == 1) || (isset($_COOKIE["remembered"]) && $_COOKIE["remembered"] != "")) {

    if (isset($_COOKIE["remembered"]) && $_COOKIE["remembered"] != "") {
      $account_id = $_COOKIE["remembered"];
    } else {
      $account = $result->fetch_array();
      $account_id = $account["id"];
    }

    // Imposta il cookie per 30 giorni o lo annulla
    (isset($_POST["remembered"]) && $_POST["remembered"] != "") ?
      setcookie('remembered', $account["id"], time() + (86400 * 30), '/') : 
      setcookie('remembered', "", time() - 3600, '/');

    // Mettiamo lo pseudoPost in sessione
    $_POST["action"] = "edit";
    $_POST["account_id"] = $account_id;
    $_SESSION["POST"] = $_POST;
?>
    <?= header("Location: ui.php"); ?>
<?php
  } else {

    // Mettiamo lo pseudoPost in sessione
    $_POST["action"] = "edit";
    $_SESSION["POST"] = $_POST;
?>
  <form class="form-signin" method="post" action="login.php">
    <div class="mr-5">
      <img id="logo" src="assets/images/logo_big.jpg" />
      <p class="mt-2 mb-2 text-center text-white">Valdicornia Basket © 2017-2024</p>
    </div>
    <div>
      <h1 class="h3 mb-3 font-weight-normal text-white text-center">AREA RISERVATA</h1>
      <label for="username" class="sr-only">Email o telefono</label>
      <input type="text" id="username" name="username" class="form-control<?= $login_failed ? " failed" : "" ?>" placeholder="Email o telefono" required="" autofocus="">
      <label for="password" class="sr-only">Password</label>
      <input type="password" id="password" name="password" class="form-control<?= $login_failed ? " failed" : "" ?>" placeholder="Password" required="">
      <div class="checkbox text-white mb-3">
        <label>
          <input type="checkbox" id="remember_me" name="remembered" value="remember-me"> Ricordami su questo dispositivo
        </label>
      </div>
      <button id="login" class="btn btn-lg btn-<?= $login_failed ? "danger" : "success" ?> btn-block" type="submit"><?= $login_failed ? "Chi?" : "Accedi" ?></button>
    </div>
  </form>
<?php
  }
?>
  <script src="assets/javascript/login.js"></script>
<?php
  if (isset($_COOKIE["remembered"]) && $_COOKIE["remembered"] != "") {

    $sql = "SELECT * FROM accounts WHERE id=" . $_COOKIE["remembered"];
    $result = $conn->query($sql);

    $account = $result->fetch_array();
?>
  <script>
    $("#username").val("<?php $account["phone"] ?>");
    $("#password").val("<?php $account["password"] ?>");
    $("#remember_me").click();
  </script>
<?php
  }
?>
</body>
</html>
