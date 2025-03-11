<?php
// Connessione al database (utilizzare la stessa connessione dei punti precedenti)

// Recupero degli autori in vita e del numero di romanzi
$stmt = $pdo->query('SELECT a.NomeAutore, COUNT(r.CodiceR) AS NumeroRomanzi
                     FROM Autori a
                     LEFT JOIN Romanzi r ON a.NomeAutore = r.NomeAutore
                     WHERE a.AnnoM IS NULL
                     GROUP BY a.NomeAutore
                     ORDER BY a.NomeAutore');
$autoriInVita = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Autori in Vita e Numero di Romanzi</title>
</head>
<body>
    <h1>Autori in Vita</h1>
    <table border="1">
        <tr>
            <th>Nome Autore</th>
            <th>Numero di Romanzi</th>
        </tr>
        <?php foreach ($autoriInVita as $autore): ?>
            <tr>
                <td><?= htmlspecialchars($autore['NomeAutore']) ?></td>
                <td><?= $autore['NumeroRomanzi'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
