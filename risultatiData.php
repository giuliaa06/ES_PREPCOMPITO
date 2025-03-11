<!DOCTYPE html>  
<html>  
<head>  
    <title>Risultati Ricerca Voli</title>  
</head>  
<body>  
    <h1>Risultati Ricerca Voli</h1>  
    <?php  
    $data = $_GET['data'];  // Recupera il valore della data dalla query string.

    $servername = "localhost";  
    $username = "root";  
    $password = "";  
    $dbname = "AeroportiVoli";  

    // Crea una connessione al database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Controlla se la connessione al database è riuscita
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);  // Termina l'esecuzione in caso di errore di connessione
    }

    // Query SQL per selezionare voli in base alla data
    $sql = "SELECT voli.codice_volo, voli.ora_partenza, voli.ora_arrivo, aeroporti_partenza.citta AS citta_partenza, aeroporti_arrivo.citta AS citta_arrivo
            FROM voli
            JOIN aeroporti AS aeroporti_partenza ON voli.id_aeroporto_partenza = aeroporti_partenza.id_aeroporto
            JOIN aeroporti AS aeroporti_arrivo ON voli.id_aeroporto_arrivo = aeroporti_arrivo.id_aeroporto
            WHERE voli.data = '$data'";  // La query seleziona i voli per la data specificata
    $result = $conn->query($sql);  // Esegue la query

    // Verifica se ci sono risultati
    if ($result->num_rows > 0) {
        echo "<table border='1'>";  // Inizia la tabella per visualizzare i risultati
        echo "<tr><th>Codice Volo</th><th>Ora Partenza</th><th>Ora Arrivo</th><th>Città Partenza</th><th>Città Arrivo</th></tr>";
        // Cicla sui risultati per mostrare ogni volo
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["codice_volo"]."</td><td>".$row["ora_partenza"]."</td><td>".$row["ora_arrivo"]."</td><td>".$row["citta_partenza"]."</td><td>".$row["citta_arrivo"]."</td></tr>";
        }
        echo "</table>";  // Chiude la tabella
    } else {
        echo "Nessun volo trovato per la data inserita.";  // Messaggio di errore se non ci sono risultati
    }

    $conn->close();  // Chiude la connessione al database
    ?>  
</body>  
</html>
