<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alterar Arquivo</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/alterar_arquivo.css">
</head>
<body>

<?php 
    require("conexaoSGBD.php");
    $id = $_GET['id'];

    $sql = "select * from arquivos where id = $id";

    if($result = $conexao->query($sql))
    {
        if($linha = $result->fetch_assoc())
        {
            $arquivo = $linha['nome'];
            $sistema = $linha['sistema'];
        }
    }
    else
        echo "Erro na consulta: " . $conexao->error;
?>

<div class="container-alterar">
    <form action="#" enctype="multipart/form-data" class="was-validated" method="post">
        <div class="card bg-primary text-white">
            <div class="card-body text-center"><b>Alterar</b></div>
        </div>
        <div class="mt-2 mb-4">
            <label for="sistema" class="form-label">⬆️ Arquivo</label>
            <input type="file" name="arquivo" class="form-control">
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <?php
            $sql = "select id, nome from sistemas order by nome";

            if($dados = $conexao->query($sql))
            {
                echo '<select name="sistema" class="form-select w-100">';

                while($row = $dados->fetch_assoc())
                {
                    $id_sistema = $row['id'];
                    $sistemas = $row['nome'];
                    echo '<option value="'.$id_sistema.'">'.$sistemas.'</option>';
                }

                echo '</select>';
            }
        ?>
        <div class="d-flex mt-4 gap-2">
            <a href="arquivos.php" class="btn btn-secondary w-50">Voltar</a>
            <button type="submit" class="btn btn-success w-50">Alterar</button>
        </div>
    </form>
</div>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $uploaddir = 'uploads/';

        if(!is_dir($uploaddir))
            mkdir($uploaddir);

        $arquivo = $_FILES['arquivo']['name'];
        $uploadfile = $uploaddir . $arquivo;

        $sistema = $_POST['sistema'];

        if(!empty($_FILES['arquivo']['name']))
        {
            if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadfile))
            {    
                $sql = "update arquivos set nome = '$arquivo', sistema = '$sistema' where id = $id";

                if($conexao->query($sql))
                {
                    header("refresh: 3; url=arquivos.php");
                    echo '<div id="spinner-overlay">
                            <div id="spinner"></div>
                        </div>';
                }
                else
                    echo '<div class="alert alert-danger">
                            <strong>Enviado com arquivo</strong>.
                          </div>';
            }
        }
        else
        {
            $sql = "update arquivos set sistema = '$sistema' where id = $id";

            if($conexao->query($sql))
            {
                header("refresh: 3; url=arquivos.php");
                echo '<div id="spinner-overlay">
                        <div id="spinner"></div>
                    </div>';
            }
            else
                echo '<div class="alert alert-danger">
                        <strong>Enviado sem arquivo</strong>.
                        </div>';
        }
    }
    $conexao->close();
?>

</body>
</html>