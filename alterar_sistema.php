<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alterar Sistema</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/alterar_sistemas.css">
</head>
<body>

<?php 
    require("conexaoSGBD.php");
    $id = $_GET['id'];

    $sql = "select * from sistemas where id = $id";

    if($result = $conexao->query($sql))
    {
        if($linha = $result->fetch_assoc())
        {
            $nome = $linha['nome'];
        }
    }
    else
        echo "Erro na consulta: " . $conexao->error;
?>

<div class="container-alterar">
    <form action="#" class="was-validated" method="post">
        <div class="card bg-primary text-white">
            <div class="card-body text-center"><b>Alterar</b></div>
        </div>
        <div class="mb-3 mt-3">
            <label for="sistema" class="form-label">⚙️ Sistema</label>
            <input type="text" class="form-control" placeholder="Digite o Sistema" required name="sistema" value="<?php echo $nome; ?>">
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="d-flex gap-2">
            <a href="sistemas.php" class="btn btn-secondary w-50">Voltar</a>
            <button type="submit" class="btn btn-success w-50">Alterar</button>
        </div>
    </form>
</div>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $nome = $_POST['sistema'];

        $sql = "update sistemas set nome = '$nome' where id = $id";

        if($conexao->query($sql))
        {
            header("refresh: 3; url=sistemas.php");
            echo '<div id="spinner-overlay">
                    <div id="spinner"></div>
                  </div>';
        }
        else
            echo '<script>alert("Erro ao Alterar Sistema! Tente Novamente.")</script>';
    }
    $conexao->close();
?>

</body>
</html>