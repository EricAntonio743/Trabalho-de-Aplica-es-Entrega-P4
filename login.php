<!-- login.php -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Banco_TA";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $role = $_POST['role'];

    // Verificação fixa para administradores
    if ($role == 'Administrador' && $email == 'admin@example.com' && $senha == 'admin123') {
        header("Location: tela_principal.html");
        exit();
    }

    // Verificação fixa para funcionários
    if ($role == 'Funcionario' && $email == 'funcionario@example.com' && $senha == 'func123') {
        header("Location: tela_usuario.html");
        exit();
    }

    // Verificação no banco de dados
    $sql = "SELECT * FROM Usuario WHERE Email='$email' AND Senha='$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($role == "Administrador") {
            header("Location: tela_principal.html");
        } else if ($role == "Funcionario") {
            header("Location: tela_usuario.html");
        }
    } else {
        echo "<script>alert('Credenciais inválidas ou função incorreta.'); window.location.href='index.php';</script>";
    }
}

$conn->close();
?>
?>