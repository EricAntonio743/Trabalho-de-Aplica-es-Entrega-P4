<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Usuário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h1 class="text-center">Editar Usuário</h1>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "Banco_TA";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM Usuario WHERE ID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
            } else {
                echo "Usuário não encontrado.";
                exit();
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $cargoFuncao = $_POST['cargo_funcao'];

            $sql = "UPDATE Usuario SET Nome=?, Email=?, CargoFuncao=? WHERE ID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $nome, $email, $cargoFuncao, $id);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success' role='alert'>Usuário atualizado com sucesso!</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Erro ao atualizar usuário: " . $stmt->error . "</div>";
            }
        }

        $conn->close();
        ?>
        <form method="post" action="editar_usuario.php">
          <input type="hidden" name="id" value="<?php echo $user['ID']; ?>">
          <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $user['Nome']; ?>" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['Email']; ?>" required>
          </div>
          <div class="mb-3">
            <label for="cargo_funcao" class="form-label">Cargo/Função</label>
            <input type="text" class="form-control" id="cargo_funcao" name="cargo_funcao" value="<?php echo $user['CargoFuncao']; ?>" required>
          </div>
          <button type="submit" class="btn btn-primary">Salvar</button>
          <a href="listar_usuarios.php" class="btn btn-secondary">Voltar</a>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
