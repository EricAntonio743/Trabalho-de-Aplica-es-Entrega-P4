<!-- editar_inventario.php -->
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
    $nomeItem = $_POST['nome_item'];
    $quantidadeDisponivel = $_POST['quantidade_disponivel'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];

    $sql = "UPDATE Inventario SET NomeItem = ?, QuantidadeDisponivel = ?, Descricao = ?, Categoria = ? WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdssi", $nomeItem, $quantidadeDisponivel, $descricao, $categoria, $id);

    if ($stmt->execute()) {
        echo "Item atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o item: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: inventario.php");
    exit();
} else {
    $id = $_GET['id'];
    $sql = "SELECT NomeItem, QuantidadeDisponivel, Descricao, Categoria FROM Inventario WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nomeItem, $quantidadeDisponivel, $descricao, $categoria);
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
  <title>Editar Item do Inventário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="row mt-5">
      <div class="col">
        <h1 class="text-center">Editar Item do Inventário</h1>
        <form method="post" action="editar_inventario.php">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <div class="mb-3">
            <label for="nome_item" class="form-label">Nome do Item</label>
            <input type="text" class="form-control" id="nome_item" name="nome_item" value="<?php echo $nomeItem; ?>" required>
          </div>
          <div class="mb-3">
            <label for="quantidade_disponivel" class="form-label">Quantidade Disponível</label>
            <input type="number" step="0.01" class="form-control" id="quantidade_disponivel" name="quantidade_disponivel" value="<?php echo $quantidadeDisponivel; ?>" required>
          </div>
          <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $descricao; ?>">
          </div>
          <div class="mb-3">
            <label for="categoria" class="form-label">Categoria</label>
            <input type="text" class="form-control" id="categoria" name="categoria" value="<?php echo $categoria; ?>" required>
          </div>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>