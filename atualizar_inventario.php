<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atualizar Inventário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="row mt-5">
      <div class="col">
        <h1 class="text-center">Atualizar Inventário</h1>
        <?php
        // Verifica se o formulário foi submetido
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname = "Banco_TA";

          $conn = new mysqli($servername, $username, $password, $dbname);

          if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
          }

          $id = $_POST['id'];
          $quantidade = $_POST['quantidade'];

          $sql = "UPDATE Inventario SET QuantidadeDisponivel = ? WHERE ID = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ii", $quantidade, $id);

          if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Quantidade atualizada com sucesso!</div>";
          } else {
            echo "<div class='alert alert-danger'>Erro ao atualizar a quantidade: " . $stmt->error . "</div>";
          }

          $stmt->close();
          $conn->close();
        }
        ?>
        <form method="get" action="atualizar_inventario.php" class="mb-4">
          <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Pesquisar...">
            <select class="form-select" name="filter">
              <option value="NomeItem">Nome do Item</option>
              <option value="QuantidadeDisponivel">Quantidade Disponível</option>
              <option value="Descricao">Descrição</option>
              <option value="Categoria">Categoria</option>
            </select>
            <button class="btn btn-primary" type="submit">Pesquisar</button>
          </div>
        </form>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Nome do Item</th>
              <th scope="col">Quantidade Disponível</th>
              <th scope="col">Descrição</th>
              <th scope="col">Categoria</th>
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

            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $filter = isset($_GET['filter']) ? $_GET['filter'] : 'NomeItem';

            $sql = "SELECT ID, NomeItem, QuantidadeDisponivel, Descricao, Categoria FROM Inventario 
                    WHERE $filter LIKE '%$search%'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <form method='post' action='atualizar_inventario.php'>
                              <td>{$row['NomeItem']}</td>
                              <td><input type='number' class='form-control' name='quantidade' value='{$row['QuantidadeDisponivel']}' required></td>
                              <td>{$row['Descricao']}</td>
                              <td>{$row['Categoria']}</td>
                              <td>
                                <input type='hidden' name='id' value='{$row['ID']}'>
                                <button type='submit' class='btn btn-primary btn-sm'>Salvar</button>
                              </td>
                            </form>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Nenhum item encontrado</td></tr>";
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
