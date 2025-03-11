<!DOCTYPE html>
<html>
<head>
    <title>Risultati Ricerca Aeroporti</title>
</head>
<body>
    <h1>Risultati Ricerca Aeroporti</h1>
    <?php
    $nazione = $_GET['nazione'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "AeroportiVoli";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM aeroporti WHERE nazione = '$nazione'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Nome</th><th>Città</th><th>Via</th><th>Numero Terminali</th><th>Numero Piste</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["nome"]."</td><td>".$row["citta"]."</td><td>".$row["via"]."</td><td>".$row["num_terminali"]."</td><td>".$row["num_piste"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "Nessun aeroporto trovato per la nazione inserita.";
    }

    $conn->close();
    ?>
</body>
</html>