<?PHP

	include 'database.php';

	function createDB($DB_DSN, $DB_USER, $DB_PASSWORD) {
		try {
			$DB = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo 'La base de donnée n\'est pas disponible, merci de réessayer plus tard.' . PHP_EOL;
		}

		try {
			$DB->exec('DROP DATABASE IF EXISTS camagru; CREATE DATABASE camagru;');
			$DB->exec('USE camagru;
			CREATE TABLE user (
				id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
				username NVARCHAR(25) NOT NULL,
				mail NVARCHAR(255) NOT NULL,
				password VARCHAR(255) NOT NULL
			);');
		} catch(PDOException $e) {
			echo 'fail requete.' . PHP_EOL;
		}

		echo 'everything fine !' . PHP_EOL;
		//TODO rajouter la creation des tables
	}

	createDB($DB_DSN, $DB_USER, $DB_PASSWORD);

?>
