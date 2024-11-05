$conn = new mysqli("localhost", "root", "", "clinica_estetica");

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
