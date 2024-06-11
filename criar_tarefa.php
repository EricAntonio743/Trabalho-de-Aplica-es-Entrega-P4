<!-- criar_tarefa.php -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Criar Tarefa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="row mt-5">
      <div class="col">
        <h1 class="text-center">Criar Tarefa</h1>
        <form action="criar_tarefa.php" method="post">
          <div class="mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <input type="text" class="form-control" id="descricao" name="descricao" required>
          </div>
          <div class="mb-3">
            <label for="prazo" class="form-label">Prazo:</label>
            <input type="date" class="form-control" id="prazo" name="prazo" required>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select class="form-select" id="status" name="status" required>
              <option value="" selected disabled>Selecione o status</option>
              <option value="Em andamento">Em andamento</option>
              <option value="Concluída">Concluída</option>
              <option value="Pendente">Pendente</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="prioridade" class="form-label">Prioridade:</label>
            <select class="form-select" id="prioridade" name="prioridade" required>
              <option value="" selected disabled>Selecione a prioridade</option>
              <option value="Alta">Alta</option>
              <option value="Média">Média</option>
              <option value="Baixa">Baixa</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Criar Tarefa</button>
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

      $descricao = $_POST["descricao"];
      $prazo = $_POST["prazo"];
      $status = $_POST["status"];
      $prioridade = $_POST["prioridade"];

      $sql = "INSERT INTO Tarefa (Descricao, Prazo, Status, Prioridade) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);

      if ($stmt === false) {
          die("Preparação da consulta falhou: " . $conn->error);
      }

      $stmt->bind_param("ssss", $descricao, $prazo, $status, $prioridade);

      if ($stmt->execute()) {
          echo "Tarefa criada com sucesso!";
      } else {
          echo "Erro ao criar tarefa: " . $stmt->error;
      }

      $stmt->close();
      $conn->close();
  }
  ?>
</body>
</html>
