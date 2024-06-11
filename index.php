<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-4 offset-md-4">
        <h1 class="text-center">Login</h1>
        <?php
        if (isset($_GET['cadastro']) && $_GET['cadastro'] == 'sucesso') {
            echo '<div class="alert alert-success" role="alert">Cadastro realizado com sucesso!</div>';
        }
        ?>
        <form method="post" action="login.php">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
          </div>
          <div class="mb-3">
            <label for="role" class="form-label">Selecione o seu papel</label>
            <select class="form-select" id="role" name="role" required>
              <option value="Administrador">Administrador</option>
              <option value="Funcionario">Funcionário</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <a class="icon-link" href="cadastro.html">
  Fazer um cadastro
  <svg class="bi" aria-hidden="true"><use xlink:href="#arrow-right"></use></svg>
</a>
      </div>
    </div>
  </div>
</body>
</html>
