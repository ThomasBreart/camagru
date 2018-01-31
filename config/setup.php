<?PHP

if (isset($_POST['setup'])) {
	setupDB();
	$_POST['setup'] = null;
}

function setupDB() {
	include 'database.php';

	$isDBCreated = createDB($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
	if ($isDBCreated) {
		createUserTable($DB_DSN, $DB_USER, $DB_PASSWORD);
	}

	echo 'everything fine !<br/>';
	//TODO rajouter la creation des tables
}

function createDB($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD) {
	try {
		$DB = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
		$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$DB->exec('DROP DATABASE IF EXISTS camagru; CREATE DATABASE camagru;');
		echo "Database created successfully<br/>";
	} catch (PDOException $e) {
		echo 'La base de donnée n\'est pas disponible, merci de réessayer plus tard.<br/>';
		echo $e->getMessage();
		return false;//todo tester ce cas
	}
	return true;
}

function createUserTable($DB_DSN, $DB_USER, $DB_PASSWORD) {
		try {
			$DB = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$DB->exec('USE camagru;
			CREATE TABLE user (
				id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
				username NVARCHAR(25) NOT NULL,
				mail NVARCHAR(255) NOT NULL,
				password VARCHAR(255) NOT NULL
			);');
			echo "user table created successfully<br/>";
		} catch(PDOException $e) {
			echo "fail create table user<br/>";
		}
}


?>

<form action="" method="post">
	<input type="submit" name="setup" value="Installer la base de donnée"/>
</form>
