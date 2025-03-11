<!DOCTYPE html>
<html>
<head>
    <title>Risultati Ricerca Voli</title>
</head>
<body>
    <h1>Risultati Ricerca Voli</h1>
    <?php
    $data = $_GET['data'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "AeroportiVoli";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    $sql = "SELECT voli.codice_volo, voli.ora_partenza, voli.ora_arrivo, aeroporti_partenza.citta AS citta_partenza, aeroporti_arrivo.citta AS citta_arrivo
            FROM voli
            JOIN aeroporti AS aeroporti_partenza ON voli.id_aeroporto_partenza = aeroporti_partenza.id_aeroporto
            JOIN aeroporti AS aeroporti_arrivo ON voli.id_aeroporto_arrivo = aeroporti_arrivo.id_aeroporto
            WHERE voli.data = '$data'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Codice Volo</th><th>Ora Partenza</th><th>Ora Arrivo</th><th>Città Partenza</th><th>Città Arrivo</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["codice_volo"]."</td><td>".$row["ora_partenza"]."</td><td>".$row["ora_arrivo"]."</td><td>".$row["citta_partenza"]."</td><td>".$row["citta_arrivo"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "Nessun volo trovato per la data inserita.";
    }

    $conn->close();
    ?>
</body>
</html>