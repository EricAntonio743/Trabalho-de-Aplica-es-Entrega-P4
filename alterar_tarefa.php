<!-- alterar_tarefa.php -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de Tarefas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="row mt-5">
      <div class="col">
        <h1 class="text-center">Alterar Tarefas</h1>
        <form method="get" action="lista_tarefas.php" class="mb-4">
          <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Pesquisar...">
            <select class="form-select" name="filter">
              <option value="Descricao">Descrição</option>
              <option value="Prazo">Prazo</option>
              <option value="Status">Status</option>
              <option value="Prioridade">Prioridade</option>
            </select>
            <button class="btn btn-primary" type="submit">Pesquisar</button>
          </div>
        </form>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Descrição</th>
              <th scope="col">Prazo</th>
              <th scope="col">Status</th>
              <th scope="col">Prioridade</th>
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
            $filter = isset($_GET['filter']) ? $_GET['filter'] : 'Descricao';

            // Converte data do formato dd/mm/yyyy para yyyy-mm-dd se o filtro for Prazo
            if ($filter == 'Prazo' && preg_match('/\d{2}\/\d{2}\/\d{4}/', $search)) {
                $date = DateTime::createFromFormat('d/m/Y', $search);
                if ($date) {
                    $search = $date->format('Y-m-d');
                }
            }

            $sql = "SELECT ID, Descricao, Prazo, Status, Prioridade FROM Tarefa 
                    WHERE $filter LIKE '%$search%'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $prazo = new DateTime($row['Prazo']);
                    echo "<tr>
                            <td>{$row['Descricao']}</td>
                            <td>{$prazo->format('d/m/Y H:i')}</td>
                            <td>{$row['Status']}</td>
                            <td>{$row['Prioridade']}</td>
                            <td>
                              <a href='editar_tarefa.php?id={$row['ID']}' class='btn btn-warning btn-sm'>Editar</a>
                              <a href='excluir_tarefa.php?id={$row['ID']}' class='btn btn-danger btn-sm'>Excluir</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Nenhuma tarefa encontrada</td></tr>";
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