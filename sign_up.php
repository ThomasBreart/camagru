<!DOCTYPE html>

<?php

function isFieldsFilled($username, $mail, $password) {
  if (empty($username) || empty($mail)|| empty($password)) {
    return false;
  }
  return true;
}


function isUserNameExistInDB($username) {
  include 'config/database.php';

  try {
    $DB = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT username FROM user WHERE username = :username;";
    $pdost = $DB->prepare($query);
    $pdost->bindParam(':username', $username);
    $pdost->execute();
    $result = $pdost->fetch();
    if ($result == FALSE) {
      echo "User username dont exist<br/>";
      return FALSE;
    } else {
      echo "User username exist<br/>";
      return TRUE;
    }
  } catch (PDOException $e) {
    echo 'PDOException - ' . $e->getMessage();
    //http_response_code(500);
    //die('Error establishing connection with database');
  }

}

function isUserMailExistInDB($mail) {
  include 'config/database.php';

  try {
    $DB = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT mail FROM user WHERE mail = :mail;";
    $pdost = $DB->prepare($query);
    $pdost->bindParam(':mail', $mail);
    $pdost->execute();
    $result = $pdost->fetch();

    echo $result;
    if ($result['mail'] == 'breart.thomas@gmail.com') {
      echo "User mail DEBUGG<br/>";
      return FALSE;
    }

    if ($result == FALSE) {
      echo "User mail dont exist<br/>";
      return FALSE;
    } else {
      echo "User mail exist<br/>";
      return TRUE;
    }
  } catch (PDOException $e) {
    echo 'PDOException - ' . $e->getMessage();
    //http_response_code(500);
    //die('Error establishing connection with database');
  }

}

function insertInnactiveAccount($username, $mail, $password, $hash) {
  include 'config/database.php';

  try {
    $DB = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "INSERT INTO user (username, mail, password, hash) VALUES (:username, :mail, :password, :hash);";
    $pdost = $DB->prepare($query);
    $pdost->bindParam(':username', $username);
    $pdost->bindParam(':mail', $mail);
    $pdost->bindParam(':password', md5($password));
    $pdost->bindParam(':hash', $hash);
    if ($pdost->execute() == TRUE) {
      echo "INSERT OK<br />";
      return TRUE;
    } else {
      echo "INSERT FAIL<br />";
      return FALSE;
    }
  } catch (PDOException $e) {
    echo 'PDOException - ' . $e->getMessage();
    //http_response_code(500);
    //die('Error establishing connection with database');
  }
}

function sendVerificationMail($mail, $hash) {
  $subject = "Inscription - Verification";
  $message = "

  Votre compte a bien été créé, cliquez sur le lien pour l'activer :
  http://e3r1p7.42.fr:8080/camagru/verifyAccount.php?mail=" . $mail . "&hash=" . $hash ."

  ";
  $headers = "From:noreply@camagru.com\r\n";
  mail($mail, $subject, $message, $headers);
  echo "MAIL SENDED<br />";
}

if (isset($_POST['inscription'])) {

  $username = $_POST['username'];
  $mail = $_POST['mail'];
  $password = $_POST['password'];

  if (isFieldsFilled($username, $mail, $password)) {
    $isUserMailExist = isUserMailExistInDB($mail);
    $isUserNameExist = isUserNameExistInDB($username);
    if (!$isUserMailExist && !$isUserNameExist) {
      $hash = md5(rand(0, 10000));
      if (insertInnactiveAccount($username, $mail, $password, $hash)) {
        sendVerificationMail($mail, $hash);
      }
      // envoyer mail
      // add dans la Bdd
      // confirmation + indiquer de l'envoi de mail

    } else {
      echo "Certains champs existent deja en bdd<br/>";
    }
  } else {
    echo "Certains champs sont vides<br/>";
  }
}
?>
<html>
<head>
  <title>camagru - tbreart</title>
</head>

<body>
  <h1>Camagru</h1>

  <?php echo "mail = " . $mail . ", password = " . $password . "."; ?>

  <button type="button">Inscription</button>

  <h2>Inscription</h2>

  <form action="" method="post">
    <h5>Nom d'utilisateur :</h5>
    <input type="text" name="username"/><br />
    <h5>Email :</h5>
    <input type="text" name="mail"/><br />
    <h5>Mot de passe :</h5>
    <input type="text" name="password"/><br /><br />
    <input type="submit" name="inscription" value="Inscription"/>
  </form>

</body>

</html>
