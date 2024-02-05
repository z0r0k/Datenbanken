<!DOCTYPE html>

<html lang="de-DE">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Skigebiete Bayern</title>
		<link rel="stylesheet" type="text/css" href="./css/style_infos.css">
	</head>
<body>
<h3>Infos zum Skigebiet:</h3>
<table>
    <thead>
        <tr>
            <th>ID_Piste</th>
            <th>Name des Skigebiets</th>
            <th>Schwierigkeit</th>
            <th>Typ</th>
        </tr>
    </thead>
    <tbody>
    <?php
    //Zugangsdaten für Datenbank
    $host = 'localhost';
    $user = 'schlumpf';
    $pass = '123456';
    $name = 'skigebiete_bayern';
    $charset = 'utf8';
    //String zusammenbauen
    $skigebiete=$_POST['skigebiete'];
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $host, $name, $charset);
    //Datenbank Öffnen
    try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    //SQL-Abfrage als String in eine Variable schreiben
    $query = 'SELECT pisten.ID_Piste, skigebiete.Pistenanzahl, skigebiete.Name, pistenart.Schwierigkeit, lifte.Typ
    FROM pisten JOIN skigebiete ON pisten.ID_Skigebiet=skigebiete.ID_Skigebiet
    JOIN pistenart ON pisten.ID_Pistenart=pistenart.ID_Pistenart
    JOIN lifte_pisten ON pisten.ID_Piste=lifte_pisten.ID_Piste
    JOIN lifte ON lifte_pisten.ID_Lift=lifte.ID_Lift
    WHERE skigebiete.ID_Skigebiet='.$skigebiete.';';
    $statement = $pdo->prepare($query);
    $statement->execute();
    } catch (PDOException $e) {
    // beim Herstellen der Datenbankverbindung oder der Vorbereitung der Abfrage ist ein Fehler aufgetreten!
    echo $e->getMessage(); //stellt eine Fehlerbeschreibung bereit
    }
    $pistenanzahl=NULL;
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $pistenanzahl = $row['Pistenanzahl'];
        echo "<tr>";
        echo "<td>" . $row['ID_Piste'] . "</td>";
        echo "<td>" . $row['Name'] . "</td>";
        echo "<td>" . $row['Schwierigkeit'] . "</td>";
        echo "<td>" . $row['Typ'] . "</td>";
        echo "</tr>";
    }


    echo "Anzahl der Pisten im Skigebiet: " . $pistenanzahl;
    
    ?>

    </tbody>
    </table>
    <h5>Legende:</h5>
    <ul>
        <li id="anfaenger">Blau = Anfänger</li>
        <li id="fortgeschritten">Rot = Fortgeschritten</li>
        <li id="experte">Schwarz = Experte</li>
    </ul>
</body>
</html>