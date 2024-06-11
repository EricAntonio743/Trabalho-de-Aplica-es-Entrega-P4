<!-- concluir_tarefa.php -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Banco_TA";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE Tarefa SET Status='Concluída' WHERE ID=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Status da tarefa atualizado com sucesso.";
    } else {
        echo "Erro ao atualizar status: " . $conn->error;
    }
}

$conn->close();
header("Location: lista_tarefas.php");
exit();
?>
