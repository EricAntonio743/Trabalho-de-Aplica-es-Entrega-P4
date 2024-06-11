<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Usuários</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col">
        <h1 class="text-center">Lista de Usuários</h1>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nome</th>
              <th scope="col">Email</th>
              <th scope="col">Cargo/Função</th>
              <th scope="col">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "Banco_TA";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }

            $sql = "SELECT ID, Nome, Email, CargoFuncao FROM Usuario";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['ID']}</td>
                            <td>{$row['Nome']}</td>
                            <td>{$row['Email']}</td>
                            <td>{$row['CargoFuncao']}</td>
                            <td>
                              <a href='editar_usuario.php?id={$row['ID']}' class='btn btn-warning btn-sm'>Editar</a>
                              <a href='deletar_usuario.php?id={$row['ID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja deletar este usuário?\");'>Deletar</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Nenhum usuário encontrado</td></tr>";
            }

            $conn->close();
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
