<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro Sistemas</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/cadastro_sistemas.css">
</head>
<body>

<script src="js/sistemas.js"></script>

<div class="container-cadastro">
    <form action="#" class="was-validated" method="post">
        <div class="card bg-primary text-white">
            <div class="card-body text-center"><b>Cadastro</b></div>
        </div>
        <div class="mb-3 mt-3">
            <label for="sistema" class="form-label">⚙️ Sistema</label>
            <input type="text" class="form-control" placeholder="Digite o Sistema" required name="sistema" autofocus>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="d-flex gap-2">
            <a href="sistemas.php" class="btn btn-secondary w-50">Voltar</a>
            <button type="submit" class="btn btn-success w-50">Cadastrar</button>
        </div>
    </form>
</div>

<?php
    if($_SERVER["REQUEST_METHOD"] == 'POST')
    {
        require("conexaoSGBD.php");
        $sistema = $_POST['sistema'];

        $sql = "insert into sistemas (nome) values ('$sistema')";
        
        if($conexao->query($sql))
        {
            header("refresh: 3; url=sistemas.php");
            echo '<div id="spinner-overlay">
                    <div id="spinner"></div>
                  </div>';
        }
        else
            echo '<div class="alert alert-danger mt-4">
                     <strong>Erro ao cadastrar sistema.</strong>.
                  </div>';
        $conexao->close();
    }
?>

</body>
</html>