<?PHP


	function createDB() {
		include 'database.php';

		try {
			$DB = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
			$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$DB->exec('DROP DATABASE IF EXISTS camagru; CREATE DATABASE camagru;');
			echo "Database created successfully\n";
		} catch (PDOException $e) {
			echo 'La base de donnée n\'est pas disponible, merci de réessayer plus tard.' . PHP_EOL;
			echo $e->getMessage();
			return;//todo tester ce cas
		}

		try {
			//$DB->exec('DROP DATABASE IF EXISTS camagru; CREATE DATABASE camagru;');
			$DB = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
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

	createDB();

?>
