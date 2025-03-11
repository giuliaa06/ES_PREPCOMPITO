<?php
// Connessione al database (utilizzare la stessa connessione del punto 1)

// Gestione della ricerca per codice
$romanzo = null;
$autore = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codice'])) {
    $codice = $_POST['codice'];
    $stmt = $pdo->prepare('SELECT r.Titolo, r.Anno, a.NomeAutore, a.AnnoN, a.AnnoM, a.Nazione
                           FROM Romanzi r
                           JOIN Autori a ON r.NomeAutore = a.NomeAutore
                           WHERE r.CodiceR = ?');
    $stmt->execute([$codice]);
    $romanzo = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Ricerca Romanzo per Codice</title>
</head>
<body>
    <h1>Ricerca Romanzo</h1>
    <form method="post">
        <label for="codice">Codice Romanzo:</label>
        <input type="text" name="codice" id="codice" required>
        <button type="submit">Cerca</button>
    </form>

    <?php if ($romanzo): ?>
        <h2>Dettagli Romanzo:</h2>
        <p><strong>Titolo:</strong> <?= htmlspecialchars($romanzo['Titolo']) ?></p>
        <p><strong>Anno di Pubblicazione:</strong> <?= $romanzo['Anno'] ?></p>
        <h3>Dettagli Autore:</h3>
        <p><strong>Nome:</strong> <?= htmlspecialchars($romanzo['NomeAutore']) ?></p>
        <p><strong>Anno di Nascita:</strong> <?= $romanzo['AnnoN'] ?></p>
        <p><strong>Anno di Morte:</strong> <?= $romanzo['AnnoM'] ? $romanzo['AnnoM'] : 'In vita' ?></p>
        <p><strong>Nazione:</strong> <?= htmlspecialchars($romanzo['Nazione']) ?></p>
    <?php elseif (isset($codice)): ?>
        <p>Nessun romanzo trovato con il codice fornito.</p>
    <?php endif; ?>
</body>
</html>
