<!DOCTYPE html>

<?php
include 'config/database.php';

  function checkFieldExist() {

  }

if (isset($_POST['Inscription'])) {
  $username = $_POST['username'];
  $mail = $_POST['mail'];
  $password = $_POST['password'];

  $error = '';
  if (empty($username) || empty($mail)|| empty($password)) {
    $error = "Certains champs sont vides";
    echo $error;
  } else {
  try {
    $DB = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // check addresse mail unique
    $query = "SELECT mail from user WHERE mail = :mail;";
    $pdost = $DB->prepare($query);
    $pdost->bindParam(':mail', $mail);
    $pdost->execute();
    $pdost->setFetchMode(PDO::FETCH_ASSOC);
    $result = $pdost->fetchColumn();
    //print(htmlentities($result));
    $DB = null;

    echo "Success";
    // check username unique
    // add dans la Bdd
    // envoyer mail
    // confirmation + indiquer de l'envoi de mail
  } catch (PDOException $e) {
    echo 'PDOException - ' . $e->getMessage();
    http_response_code(500);
    die('Error establishing connection with database');
  }
} /*else {
  echo "BBBBBB";
}*/

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
    <input type="submit" name="Inscription" value="Inscription"/>
  </form>

</body>

</html>
