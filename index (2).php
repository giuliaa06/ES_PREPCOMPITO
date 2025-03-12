<?php
    $mysqli = new mysqli("localhost", "root", "", "Autori");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Recupera gli autori per la select
    $query_autori = "SELECT NomeAutore FROM Autori";
    $result_autori = $mysqli->query($query_autori);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestione Autori e Romanzi</title>
</head>
<body>
    <h2>Seleziona un autore per vedere i suoi romanzi:</h2>
    <form action="autori.php" method="GET">
        <select name="autore">
            <?php while ($row = $result_autori->fetch_assoc()) { ?>
                <option value="<?= $row['NomeAutore']; ?>"><?= $row['NomeAutore']; ?></option> // shorthand per < ?php echo ... ?>, usata per stampare qualcosa direttamente in HTML.
            <?php } ?>
        </select>
        <button type="submit">Cerca</button>
    </form>

    <h2>Ricerca per codice ISBN:</h2>
    <form action="autori.php" method="GET">
        <input type="text" name="codice" placeholder="Inserisci codice ISBN" required>
        <button type="submit">Cerca</button>
    </form>

    <h2>Visualizza autori in vita:</h2>
    <a href="autori.php?viventi=1">Clicca qui</a>
</body>
</html>

<?php $mysqli->close(); ?>







<?php
// Connessione al database
$host = "localhost";
$user = "root"; // Cambia se necessario
$password = ""; // Cambia se necessario
$dbname = "CompagniaAerea";

$conn = new mysqli($host, $user, $password, $dbname);

// Creazione del database e delle tabelle se non esistono
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS CompagniaAerea";
$conn->query($sql);

$conn->select_db("CompagniaAerea");

// Creazione tabelle
$sql = "
CREATE TABLE IF NOT EXISTS Aeroporto (
    CodiceAeroporto VARCHAR(10) PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Citta VARCHAR(100) NOT NULL,
    Nazione VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS Volo (
    NumeroVolo VARCHAR(10) PRIMARY KEY,
    OraPartenza TIME NOT NULL,
    OraArrivo TIME NOT NULL,
    Durata INT NOT NULL,
    AeroportoPartenza VARCHAR(10) NOT NULL,
    AeroportoArrivo VARCHAR(10) NOT NULL,
    FOREIGN KEY (AeroportoPartenza) REFERENCES Aeroporto(CodiceAeroporto),
    FOREIGN KEY (AeroportoArrivo) REFERENCES Aeroporto(CodiceAeroporto)
);
";

if ($conn->multi_query($sql)) {
    while ($conn->next_result()) {;} // Svuota il buffer
}

// Inserimento del volo se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numeroVolo = $_POST['numeroVolo'];
    $oraPartenza = $_POST['oraPartenza'];
    $oraArrivo = $_POST['oraArrivo'];
    $durata = $_POST['durata'];
    $aeroportoPartenza = $_POST['aeroportoPartenza'];
    $aeroportoArrivo = $_POST['aeroportoArrivo'];

    $stmt = $conn->prepare("INSERT INTO Volo (NumeroVolo, OraPartenza, OraArrivo, Durata, AeroportoPartenza, AeroportoArrivo) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiss", $numeroVolo, $oraPartenza, $oraArrivo, $durata, $aeroportoPartenza, $aeroportoArrivo);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Volo inserito con successo!</p>";
    } else {
        echo "<p style='color:red;'>Errore: " . $conn->error . "</p>";
    }
    $stmt->close();
}

// Recupero i voli esistenti per visualizzarli
$result = $conn->query("SELECT * FROM Volo");

$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Voli</title>
</head>
<body>
    <h2>Inserisci un nuovo volo</h2>
    <form action="" method="POST">
        Numero Volo: <input type="text" name="numeroVolo" required><br>
        Ora Partenza: <input type="time" name="oraPartenza" required><br>
        Ora Arrivo: <input type="time" name="oraArrivo" required><br>
        Durata (minuti): <input type="number" name="durata" required><br>
        Aeroporto Partenza (Codice): <input type="text" name="aeroportoPartenza" required><br>
        Aeroporto Arrivo (Codice): <input type="text" name="aeroportoArrivo" required><br>
        <input type="submit" value="Inserisci Volo">
    </form>

    <h2>Voli Registrati</h2>
    <table border="1">
        <tr>
            <th>Numero Volo</th>
            <th>Ora Partenza</th>
            <th>Ora Arrivo</th>
            <th>Durata</th>
            <th>Aeroporto Partenza</th>
            <th>Aeroporto Arrivo</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["NumeroVolo"]; ?></td>
                <td><?php echo $row["OraPartenza"]; ?></td>
                <td><?php echo $row["OraArrivo"]; ?></td>
                <td><?php echo $row["Durata"]; ?> min</td>
                <td><?php echo $row["AeroportoPartenza"]; ?></td>
                <td><?php echo $row["AeroportoArrivo"]; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

