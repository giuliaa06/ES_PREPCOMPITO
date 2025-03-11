<!DOCTYPE html>  
<html>  
<head>  
    <title>Risultati Ricerca Aeroporti</title>  
</head>  
<body>  
    <h1>Risultati Ricerca Aeroporti</h1>  
    <?php  
    $nazione = $_GET['nazione'];  // Recupera la nazione dalla query string.

    $servername = "localhost";  
    $username = "root";  
    $password = "";  
    $dbname = "AeroportiVoli";  

    // Crea una connessione al database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Controlla se la connessione al database è riuscita
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);  // Termina in caso di errore
    }

    // Query SQL per selezionare aeroporti in base alla nazione
    $sql = "SELECT * FROM aeroporti WHERE nazione = '$nazione'";  // La query seleziona aeroporti dalla nazione specificata
    $result = $conn->query($sql);  // Esegue la query

    // Verifica se ci sono risultati
    if ($result->num_rows > 0) {
        echo "<table border='1'>";  // Inizia la tabella per visualizzare i risultati
        echo "<tr><th>Nome</th><th>Città</th><th>Via</th><th>Numero Terminali</th><th>Numero Piste</th></tr>";
        // Cicla sui risultati per mostrare ogni aeroporto
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["nome"]."</td><td>".$row["citta"]."</td><td>".$row["via"]."</td><td>".$row["num_terminali"]."</td><td>".$row["num_piste"]."</td></tr>";
        }
        echo "</table>";  // Chiude la tabella
    } else {
        echo "Nessun aeroporto trovato per la nazione inserita.";  // Messaggio di errore se non ci sono risultati
    }

    $conn->close();  // Chiude la connessione al database
    ?>  
</body>  
</html>
