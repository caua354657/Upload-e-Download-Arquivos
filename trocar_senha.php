<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trocar Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/trocar_senha.css">
</head>
<body>

<script src="js/trocar_senha.js"></script>

<div class="container-alterar">
    <form action="#" method="post">
    <div class="card bg-primary text-white">
        <div class="card-body text-center"><b>🔐 Alterar</b></div>
    </div>
    <div class="mb-4 mt-3">
        <label for="senha" class="form-label">🗝️ Senha Atual</label>
        <input type="password" class="form-control" placeholder="Digite a Senha Atual" name="senha_atual" required autofocus>
    </div>
    <div class="mb-4">
        <label for="senha" class="form-label">🗝️ Nova Senha</label>
        <input type="password" class="form-control" placeholder="Digite a Senha Nova" name="nova_senha" required>
    </div>

<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        require("conexaoSGBD.php");
        $senha_atual = $_POST['senha_atual']; 
        $nova_senha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);

        //pegar senha atual do banco
        $id = $_SESSION['id'];
        $sql = "select senha from usuario where id = $id";
        if($result = $conexao->query($sql))
        {
            $linha = $result->fetch_assoc();
            $senha_BD = $linha['senha'];
        }

        //se o que digitei for o mesmo que no banco, vai atualizar a senha que eu digitar
        if(password_verify($senha_atual, $senha_BD))
        {
            $sql = "update usuario set senha = '$nova_senha' where id = $id";

            if($result = $conexao->query($sql))
            {
                header ("refresh: 2; url=index.php");
                session_unset();
                echo '<div id="spinner-overlay">
                        <div id="spinner"></div>
                      </div>';
            }
            else 
                echo '<div class="alert alert-danger mt-4">
                        <strong>Erro na Consulta.</strong>.
                    </div>';
        }
        else
            echo '<div class="alert alert-danger mt-4 text-center">
                     <strong>Senha atual Incorreta.</strong>.
                  </div>';
            $conexao->close();
    }
?>

    <div class="d-flex gap-2">
        <a href="index.php" class="btn btn-secondary w-50">Voltar</a>
        <button type="submit" class="btn btn-success w-50">Alterar</button>
    </div>
    </form>
</div>

</body>
</html>