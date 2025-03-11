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
