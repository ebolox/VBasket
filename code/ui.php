<?php
  include('logic.php');

  $account = get_account();
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
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" /> -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="ext/fontawesome-free-6.4.2-web/css/fontawesome.css">
  <link rel="stylesheet" href="assets/stylesheets/ui.css">
  <link rel="stylesheet" href="assets/stylesheets/account.css">
  <link rel="stylesheet" href="assets/stylesheets/registry.css">
  <link rel="stylesheet" href="assets/stylesheets/book.css">
  <link rel="stylesheet" href="assets/stylesheets/calendar.css">
  <link rel="stylesheet" href="assets/stylesheets/technique.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
</head>
<body>

  <?php include('navbar.php'); ?>

  <div id="ui_content">

    <?php include('calendar.php'); ?>

  </div>
  <?= modal_base('choice'); ?>
  <script src="assets/javascript/ui.js"></script>
</body>
</html>
