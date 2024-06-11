<!-- lista_tarefas_usuario.php -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de Tarefas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="container">
    <div class="row mt-5">
      <div class="col">
        <h1 class="text-center">Lista de Tarefas</h1>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "Banco_TA";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Obter contagens de tarefas
        $sql = "SELECT 
                  (SELECT COUNT(*) FROM Tarefa WHERE Status = 'Em andamento') AS andamento_count,
                  (SELECT COUNT(*) FROM Tarefa WHERE Status = 'Concluída') AS concluida_count";
        $result = $conn->query($sql);
        $counts = $result->fetch_assoc();

        $andamento_count = $counts['andamento_count'];
        $concluida_count = $counts['concluida_count'];
        ?>
        <div class="row mb-4">
          <div class="col-md-6">
            <div class="card text-white bg-warning mb-3">
              <div class="card-body">
                <h5 class="card-title">Tarefas em andamento</h5>
                <p class="card-text"><?php echo $andamento_count; ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card text-white bg-success mb-3">
              <div class="card-body">
                <h5 class="card-title">Tarefas concluídas</h5>
                <p class="card-text"><?php echo $concluida_count; ?></p>
              </div>
            </div>
          </div>
        </div>
        <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="mb-4">
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
          <tbody id="task-list">
            <?php
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $filter = isset($_GET['filter']) ? $_GET['filter'] : 'Descricao';

            // Converte data do formato dd/mm/yyyy para yyyy-mm-dd se o filtro for Prazo
            if ($filter == 'Prazo' && preg_match('/\d{2}\/\d{2}\/\d{4}/', $search)) {
                $date = DateTime::createFromFormat('d/m/Y', $search);
                if ($date) {
                    $search = $date->format('Y-m-d');
                }
            }

            $sql = "SELECT ID, Descricao, Prazo, Status, Prioridade 
                    FROM Tarefa 
                    WHERE $filter LIKE '%$search%'
                    ORDER BY FIELD(Status, 'Em andamento', 'Concluída', 'Pendente')";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $prazo = new DateTime($row['Prazo']);
                    $formattedPrazo = $prazo->format('d/m/Y H:i');
                    $status = $row['Status'];
                    $rowClass = '';
                    if ($status == 'Em andamento') {
                        $rowClass = 'table-warning';
                    } elseif ($status == 'Concluída') {
                        $rowClass = 'table-success';
                    } elseif ($status == 'Pendente') {
                        $rowClass = 'table-danger';
                    }
                    echo "<tr class='{$rowClass}' id='task-{$row['ID']}'>
                            <td>{$row['Descricao']}</td>
                            <td>{$formattedPrazo}</td>
                            <td>{$row['Status']}</td>
                            <td>{$row['Prioridade']}</td>
                            <td>
                              <button class='btn btn-success btn-sm concluir-tarefa' data-id='{$row['ID']}'>Concluir Tarefa</button>
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

  <script>
    $(document).ready(function() {
      $('.concluir-tarefa').on('click', function() {
        var taskId = $(this).data('id');
        $.ajax({
          url: 'concluir_tarefa_ajax.php',
          type: 'POST',
          data: { id: taskId },
          success: function(response) {
            if (response == 'success') {
              // Atualiza a linha da tarefa para Concluída
              var row = $('#task-' + taskId);
              row.removeClass('table-warning table-danger').addClass('table-success');
              row.find('td:eq(2)').text('Concluída');
              // Atualiza o painel de contagem
              var andamentoCount = parseInt($('.bg-warning .card-text').text());
              var concluidaCount = parseInt($('.bg-success .card-text').text());
              $('.bg-warning .card-text').text(andamentoCount - 1);
              $('.bg-success .card-text').text(concluidaCount + 1);
            } else {
              alert('Erro ao concluir a tarefa');
            }
          }
        });
      });
    });
  </script>
</body>
</html>
