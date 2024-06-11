<!-- alterar_inventario.php -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="row mt-5">
      <div class="col">
        <h1 class="text-center">Alterar Inventario</h1>
        <form method="get" action="inventario.php" class="mb-4">
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
                            <td>{$row['NomeItem']}</td>
                            <td>{$row['QuantidadeDisponivel']}</td>
                            <td>{$row['Descricao']}</td>
                            <td>{$row['Categoria']}</td>
                            <td>
                              <a href='editar_inventario.php?id={$row['ID']}' class='btn btn-warning btn-sm'>Editar</a>
                              <a href='excluir_inventario.php?id={$row['ID']}' class='btn btn-danger btn-sm'>Excluir</a>
                            </td>
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