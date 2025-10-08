<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alterar Usuário</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/alterar_usuario.css">
</head>
<body>

<?php 
    require("conexaoSGBD.php");
    $id = $_GET['id'];

    $sql = "select * from usuario where id = $id";

    if($result = $conexao->query($sql))
    {
        if($linha = $result->fetch_assoc())
        {
            $nome = $linha['nome'];
            $email = $linha['email'];
        }
    }
    else
        echo "Erro na consulta: " . $conexao->error;
?>

<div class="container-alterar">
    <form action="#" class="was-validated" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- Apenas para pegar o id do cliente e passar para uma variavel post no php -->
        <div class="card bg-primary text-white">
            <div class="card-body text-center"><b>Alterar</b></div>
        </div>
        <div class="mb-4 mt-3">
            <label for="nome" class="form-label">👤 Nome</label>
            <input type="text" class="form-control" placeholder="Digite o Nome" required name="nome" value="<?php echo $nome; ?>">
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4 mt-3">
            <label for="email" class="form-label">✉️ E-mail</label>
            <input type="email" class="form-control" placeholder="Digite o Email" required name="email" value="<?php echo $email; ?>">
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="d-flex gap-2">
            <a href="usuario.php" class="btn btn-secondary w-50">Voltar</a>
            <button type="submit" class="btn btn-success w-50">Alterar</button>
        </div>
    </form>
</div>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $nome = $_POST['nome'];
        $email = trim(strip_tags($_POST['email'])); //trim para remover espaços em branco e strip_tags para remover tags html e php

        $sql = "update usuario set nome = '$nome', email = '$email' where id = $id";

        if($conexao->query($sql))
        {
            header("refresh: 3; url=usuario.php");
            echo '<div id="spinner-overlay">
                    <div id="spinner"></div>
                  </div>';
        }
        else
            echo '<script>alert("Erro ao Alterar Usuário! Tente Novamente.")</script>';
    }
    $conexao->close();
?>

</body>
</html>