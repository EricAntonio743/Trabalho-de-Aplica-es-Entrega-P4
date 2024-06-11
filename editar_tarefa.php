<!-- editar_tarefa.php -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Banco_TA";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $descricao = $_POST['descricao'];
    $prazo = $_POST['prazo'];
    $status = $_POST['status'];
    $prioridade = $_POST['prioridade'];

    $sql = "UPDATE Tarefa SET Descricao = ?, Prazo = ?, Status = ?, Prioridade = ? WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $descricao, $prazo, $status, $prioridade, $id);

    if ($stmt->execute()) {
        echo "Tarefa atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar a tarefa: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: alterar_tarefa.php");
    exit();
} else {
    $id = $_GET['id'];
    $sql = "SELECT Descricao, Prazo, Status, Prioridade FROM Tarefa WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($descricao, $prazo, $status, $prioridade);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Tarefa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="row mt-5">
      <div class="col">
        <h1 class="text-center">Editar Tarefa</h1>
        <form method="post" action="editar_tarefa.php">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $descricao; ?>" required>
          </div>
          <div class="mb-3">
            <label for="prazo" class="form-label">Prazo</label>
            <input type="date" class="form-control" id="prazo" name="prazo" value="<?php echo $prazo; ?>" required>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
              <option value="Em andamento" <?php if ($status == 'Em andamento') echo 'selected'; ?>>Em andamento</option>
              <option value="Concluída" <?php if ($status == 'Concluída') echo 'selected'; ?>>Concluída</option>
              <option value="Pendente" <?php if ($status == 'Pendente') echo 'selected'; ?>>Pendente</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="prioridade" class="form-label">Prioridade</label>
            <select class="form-select" id="prioridade" name="prioridade" required>
              <option value="Alta" <?php if ($prioridade == 'Alta') echo 'selected'; ?>>Alta</option>
              <option value="Média" <?php if ($prioridade == 'Média') echo 'selected'; ?>>Média</option>
              <option value="Baixa" <?php if ($prioridade == 'Baixa') echo 'selected'; ?>>Baixa</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>