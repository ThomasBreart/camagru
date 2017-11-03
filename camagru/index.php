<!DOCTYPE html>

<?php
  if (isset($_POST['Connexion'])) {
    $mail = $_POST['mail'];
    $password = $_POST['password'];

  } else {
    echo "BBBBBB";
  }
 ?>
<html>
<head>
  <title>camagru - tbreart</title>
</head>

<body>
  <h1>Camagru</h1>

  <?php echo "mail = " . $mail . ", password = " . $password . "."; ?>

  <button type="button" id="inscription">Inscription</button>

<script type="text/javascript">
  document.getElementById("inscription").onclick = function () {
    location.href = "sign_up.php";
  };
</script>

  <form action="" method="post">
    <h5>Email :</h5>
    <input type="text" name="mail"/><br />
    <h5>Mot de passe :</h5>
    <input type="text" name="password"/><br /><br />
    <input type="submit" name="Connexion" value="Connexion"/>
  </form>

</body>

</html>
