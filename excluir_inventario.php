<!-- excluir_inventario.php -->
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
$sql = "DELETE FROM Inventario WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Item excluído com sucesso!";
} else {
    echo "Erro ao excluir o item: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: inventario.php");
exit();
?>