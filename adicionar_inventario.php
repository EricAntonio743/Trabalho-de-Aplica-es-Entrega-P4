<!-- adicionar_inventario.php -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Adicionar Item ao Inventário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="row mt-5">
      <div class="col">
        <h1 class="text-center">Adicionar Item ao Inventário</h1>
        <form action="adicionar_inventario.php" method="post">
          <div class="mb-3">
            <label for="nome_item" class="form-label">Nome do Item:</label>
            <input type="text" class="form-control" id="nome_item" name="nome_item" required>
          </div>
          <div class="mb-3">
            <label for="quantidade_disponivel" class="form-label">Quantidade Disponível:</label>
            <input type="number" step="0.01" class="form-control" id="quantidade_disponivel" name="quantidade_disponivel" required>
          </div>
          <div class="mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <input type="text" class="form-control" id="descricao" name="descricao">
          </div>
          <div class="mb-3">
            <label for="categoria" class="form-label">Categoria:</label>
            <input type="text" class="form-control" id="categoria" name="categoria" required>
          </div>
          <button type="submit" class="btn btn-primary">Adicionar Item</button>
        </form>
      </div>
    </div>
  </div>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "Banco_TA";

      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error) {
          die("Conexão falhou: " . $conn->connect_error);
      }

      $nomeItem = $_POST["nome_item"];
      $quantidadeDisponivel = $_POST["quantidade_disponivel"];
      $descricao = $_POST["descricao"];
      $categoria = $_POST["categoria"];

      $sql = "INSERT INTO Inventario (NomeItem, QuantidadeDisponivel, Descricao, Categoria) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);

      if ($stmt === false) {
          die("Preparação da consulta falhou: " . $conn->error);
      }

      $stmt->bind_param("sdss", $nomeItem, $quantidadeDisponivel, $descricao, $categoria);

      if ($stmt->execute()) {
          echo "<div class='alert alert-success mt-3'>Item adicionado com sucesso!</div>";
      } else {
          echo "<div class='alert alert-danger mt-3'>Erro ao adicionar item: " . $stmt->error . "</div>";
      }

      $stmt->close();
      $conn->close();
  }
  ?>
</body>
</html>