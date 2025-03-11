<?php
// Connessione al database
$host = 'localhost';
$dbname = 'romanzi';
$username = 'tuo_username';
$password = 'tua_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connessione al database fallita: " . $e->getMessage());
}

// Recupero degli autori per la casella di selezione
$stmt = $pdo->query('SELECT NomeAutore FROM Autori ORDER BY NomeAutore');
$autori = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gestione della selezione dell'autore
$romanzi = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['autore'])) {
    $autoreSelezionato = $_POST['autore'];
    $stmt = $pdo->prepare('SELECT Titolo, Anno FROM Romanzi WHERE NomeAutore = ? ORDER BY Anno');
    $stmt->execute([$autoreSelezionato]);
    $romanzi = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Elenco Romanzi per Autore</title>
</head>
<body>
    <h1>Seleziona un Autore</h1>
    <form method="post">
        <label for="autore">Autore:</label>
        <select name="autore" id="autore">
            <?php foreach ($autori as $autore): ?>
                <option value="<?= htmlspecialchars($autore['NomeAutore']) ?>" <?= (isset($autoreSelezionato) && $autoreSelezionato === $autore['NomeAutore']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($autore['NomeAutore']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Mostra Romanzi</button>
    </form>

    <?php if (!empty($romanzi)): ?>
        <h2>Romanzi di <?= htmlspecialchars($autoreSelezionato) ?>:</h2>
        <ul>
            <?php foreach ($romanzi as $romanzo): ?>
                <li><?= htmlspecialchars($romanzo['Titolo']) ?> (<?= $romanzo['Anno'] ?>)</li>
            <?php endforeach; ?>
        </ul>
    <?php elseif (isset($autoreSelezionato)): ?>
        <p>Nessun romanzo trovato per l'autore selezionato.</p>
    <?php endif; ?>
</body>
</html>
