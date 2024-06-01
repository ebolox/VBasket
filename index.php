<?php
  $logged = (isset($_SESSION) && !empty($_SESSION["account_id"]));
?>
<?php
  if ($logged) {

    // Mettiamo lo pseudoPost in sessione
    $_POST["action"] = "login";
    $_SESSION["POST"] = $_POST;
?>
    <?= include("ui.php"); ?>
<?php
  } else {

    // Mettiamo lo pseudoPost in sessione
    $_POST["action"] = "logout";
    $_SESSION["POST"] = $_POST;
?>
    <?= include("login.php"); ?>
<?php
  }
?>