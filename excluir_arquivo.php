<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Arquivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/excluir_arquivo.css">
</head>
<body>

<?php
    require("conexaoSGBD.php");
    $id = $_GET['id'];
    $sql = "select * from arquivos where id = $id";
    $result = $conexao->query($sql);
    $linha = $result->fetch_assoc();

    $nome = $linha['nome'];
?>

<div class="container-excluir">
    <form action="#" method="post">
        <div class="card bg-danger text-white">
            <div class="card-body text-center"><b>Deletar Arquivo</b></div>
        </div>
        <div class="mt-3 p-3 border rounded bg-light text-center">
            <p class="text-danger mb-3">Isso resultará na perda dos dados!</p>
            <h5 class="text-primary fw-bold"><?php echo $nome; ?></h5>
        </div>
        <div class="d-flex mt-3 gap-2">
            <a href="arquivos.php" class="btn btn-secondary w-50">Voltar</a>
            <button type="submit" class="btn btn-danger w-50">Excluir</button>
        </div>
    </form>
</div>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $sql = "delete from arquivos where id = ". $_GET['id'];

        if($conexao->query($sql))
        {
            header("refresh: 3; url=arquivos.php"); 
            echo '<div id="spinner-overlay">
                    <div id="spinner"></div>
                  </div>';
        }
        else
            echo '<div class="alert alert-danger mt-4">
                     <strong>Erro ao deletar arquivo.</strong>.
                  </div>';
    }
    $conexao->close();
?>
    
</body>
</html>