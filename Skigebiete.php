<!DOCTYPE html>

<html lang="de-DE">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Skigebiete Bayern</title>
		<link rel="stylesheet" type="text/css" href="./css/style.css">
	</head>
<body>
    <h1>Skigebiete Bayern</h1>
    <h4>Bitte wählen Sie Ihr Skigebiet aus um die Informationen einzusehen</h4>
    <?php
    //Zugangsdaten für Datenbank
    $host = 'localhost';
    $user = 'schlumpf';
    $pass = '123456';
    $name = 'skigebiete_bayern';
    $charset = 'utf8';
    //String zusammenbauen
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $host, $name, $charset);
    //Datenbank Öffnen
    try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    //SQL-Abfrage als String in eine Variable schreiben
    $query = 'SELECT skigebiete.ID_Skigebiet,skigebiete.name FROM skigebiete';
    $statement = $pdo->prepare($query);
    $statement->execute();
    } catch (PDOException $e) {
    // beim Herstellen der Datenbankverbindung oder der Vorbereitung der Abfrage ist ein Fehler aufgetreten!
    echo $e->getMessage(); //stellt eine Fehlerbeschreibung bereit
    }
    //Daten von der Datenbank entgegennehmen und Als html ausgeben.
    //echo "<html><head></head<body> Das sind die Kundendaten der Abfrage:<br>";
    echo "<form method='POST' action='Infos.php'>";
    echo "<select name='skigebiete'>";
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    //echo "ID Kunde: ".$row['ID_Kunde']."<br>";
    echo "<option  value='".$row['ID_Skigebiet']."'>".$row['name']."</option>";
    }
    echo"</select>";
   
    ?>
     <input type="submit">
</form>
</body>