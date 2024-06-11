<!-- inventario.php -->
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
        <h1 class="text-center">Inventário</h1>
        <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="mb-4">
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

        $sql = "SELECT ID, NomeItem, QuantidadeDisponivel, Descricao, Categoria 
                FROM Inventario 
                WHERE $filter LIKE '%$search%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $lowStockItems = [];
            echo '<table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Nome do Item</th>
                        <th scope="col">Quantidade Disponível</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Categoria</th>
                      </tr>
                    </thead>
                    <tbody>';
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['NomeItem']}</td>
                        <td>{$row['QuantidadeDisponivel']}</td>
                        <td>{$row['Descricao']}</td>
                        <td>{$row['Categoria']}</td>
                      </tr>";
                if ($row['QuantidadeDisponivel'] < 5) {  // Define o limiar aqui
                    $lowStockItems[] = "{$row['NomeItem']} (Quantidade: {$row['QuantidadeDisponivel']})";
                }
            }
            echo '</tbody>
                </table>';
            if (!empty($lowStockItems)) {
                echo '<div class="alert alert-danger mt-4" role="alert">
                        <h4 class="alert-heading">Atenção!</h4>
                        <p>Os seguintes itens estão com a quantidade baixa:</p>
                        <ul>';
                foreach ($lowStockItems as $item) {
                    echo "<li>{$item}</li>";
                }
                echo '  </ul>
                      </div>';
            }
        } else {
            echo "<div class='alert alert-warning text-center' role='alert'>Nenhum item encontrado</div>";
        }

        $conn->close();
        ?>
      </div>
    </div>
  </div>
</body>
</html>