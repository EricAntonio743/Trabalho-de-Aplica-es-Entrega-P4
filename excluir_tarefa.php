<!-- excluir_tarefa.php -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Banco_TA";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "DELETE FROM Tarefa WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Tarefa excluída com sucesso!";
} else {
    echo "Erro ao excluir a tarefa: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: alterar_tarefa.php");
exit();
?>