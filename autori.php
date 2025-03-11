<?php
    $mysqli = new mysqli("localhost", "root", "", "Autori");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Risultati</title>
</head>
<body>

<?php
    // Ricerca romanzi di un autore
    if (isset($_GET['autore'])) {
        $autore = $mysqli->real_escape_string($_GET['autore']);  // real_escape_string(): Rimuove o neutralizza caratteri speciali che potrebbero alterare la query.
        $query = "SELECT Titolo, Anno FROM Romanzi WHERE NomeAutore='$autore'";
        $result = $mysqli->query($query);

        echo "<h2>Romanzi di " . htmlspecialchars($autore) . ":</h2>"; // htmlspecialchars($autore): Protegge il contenuto trasformando caratteri speciali in entità HTML.
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . $row['Titolo'] . " (" . $row['Anno'] . ")</li>";
        }
        echo "</ul>";
    }

    // Ricerca romanzo per codice
    if (isset($_GET['codice'])) {
        $codice = $mysqli->real_escape_string($_GET['codice']);
        $query = "SELECT R.Titolo, A.NomeAutore, A.Nazione, A.AnnoN, A.AnnoM
                  FROM Romanzi R
                  JOIN Autori A ON R.NomeAutore = A.NomeAutore
                  WHERE R.CodiceR = '$codice'";
        $result = $mysqli->query($query);

        if ($row = $result->fetch_assoc()) {
            echo "<h2>Dettagli Romanzo</h2>";
            echo "<p><strong>Titolo:</strong> " . $row['Titolo'] . "</p>";
            echo "<p><strong>Autore:</strong> " . $row['NomeAutore'] . "</p>";
            echo "<p><strong>Nazione:</strong> " . $row['Nazione'] . "</p>";
            echo "<p><strong>Anno di nascita:</strong> " . $row['AnnoN'] . "</p>";
            echo "<p><strong>Anno di morte:</strong> " . ($row['AnnoM'] ? $row['AnnoM'] : "Ancora in vita") . "</p>";
        } else {
            echo "<p>Nessun romanzo trovato per il codice " . htmlspecialchars($codice) . ".</p>";
        }
    }

    // Elenco autori in vita con numero di romanzi
    if (isset($_GET['viventi'])) {
        $query = "SELECT A.NomeAutore, COUNT(R.CodiceR) AS NumeroRomanzi
                  FROM Autori A
                  LEFT JOIN Romanzi R ON A.NomeAutore = R.NomeAutore
                  WHERE A.AnnoM IS NULL
                  GROUP BY A.NomeAutore";
        $result = $mysqli->query($query);

        echo "<h2>Autori in Vita e Numero di Romanzi</h2>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . $row['NomeAutore'] . " - " . $row['NumeroRomanzi'] . " romanzi</li>";
        }
        echo "</ul>";
    }
?>

<a href="index.php">Torna Indietro</a>

</body>
</html>

<?php $mysqli->close(); ?>
