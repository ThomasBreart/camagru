<?php
function checkInnactiveAccount() {
  include 'config/database.php';

  try {
    $DB = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT mail, hash, active FROM user WHERE mail=:mail AND hash=:hash AND active='0';";
    $pdost = $DB->prepare($query);
    $pdost->bindParam(':mail', $_GET['mail']);
    $pdost->bindParam(':hash', $_GET['hash']);
    if ($pdost->execute() == TRUE) {
      echo "COMPTE TROUVE DANS LA BDD<br />";
      return TRUE;
    } else {
      echo "COMPTE NON TROUVE DANS LA BDD OU COMPTE DEJA ACTIF<br />";
      return FALSE;
    }
  } catch (PDOException $e) {
    echo 'PDOException - ' . $e->getMessage();
    //http_response_code(500);
    //die('Error establishing connection with database');
  }
}

function activateAccount() {
  include 'config/database.php';

  try {
    $DB = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "UPDATE user SET active='1' WHERE mail=:mail AND hash=:hash AND active='0';";
    $pdost = $DB->prepare($query);
    $pdost->bindParam(':mail', $_GET['mail']);
    $pdost->bindParam(':hash', $_GET['hash']);
    if ($pdost->execute() == TRUE) {
      echo "COMPTE ACTIVAY<br />";
      return TRUE;
    } else {
      echo "COMPTE NON ACTIVAY<br />";
      return FALSE;
    }
  } catch (PDOException $e) {
    echo 'PDOException - ' . $e->getMessage();
    //http_response_code(500);
    //die('Error establishing connection with database');
  }
}

  if (!empty($_GET['mail']) && !empty($_GET['hash'])){
    echo "MAIL AND HASH NOT EMPTY<br />";
    if (checkInnactiveAccount()) {
      activateAccount();
    }
  } else {
    echo "MAIL AND/OR HASH EMPTY<br />";
  }
 ?>

<html>
<head>
  <title>camagru - tbreart</title>
</head>

<body>
  <h1>Camagru</h1>

  <h2>Activation compte</h2>

</body>

</html>
