<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistemas Cadastrados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/upload.css">
</head>
<body>

<div class="container-upload">
            <div class="card bg-primary text-white mb-2">
                <div class="card-body text-center"><b>📄 Upload Arquivo</b></div>
            </div>
            <form action="upload.php" method="post" enctype="multipart/form-data" class="was-validated mb-3">
                <div class="mb-4 mt-3">
                    <label for="sistema" class="form-label">⚙️ Sistema</label>
                    <select name="sistema" class="form-select" id="sistema" required>
                       <?php 
                          require("conexaoSGBD.php");
                          $sql = "select * from sistemas order by nome";

                          if($resultado = $conexao->query($sql))
                          {
                            while($linha = $resultado->fetch_assoc())
                            {
                                $id = $linha['id'];
                                $sistema = $linha['nome'];
                                echo '<option value="'.$id.'">'.$sistema.'</option>';
                            }
                          }
                       ?>
                    </select>
                    <div class="valid-feedback">Válido.</div>
                    <div class="invalid-feedback">Por favor, preencha este campo.</div>
                </div>
                <div class="mb-4">
                    <label for="sistema" class="form-label">⬆️ Upload Arquivo</label>
                    <input type="file" name="arquivo" class="form-control" required>
                    <div class="valid-feedback">Válido.</div>
                    <div class="invalid-feedback">Por favor, preencha este campo.</div>
                </div>
                <div class="d-flex gap-2">
                    <a href="arquivos.php" class="btn btn-secondary w-50">Voltar</a>
                    <button type="submit" class="btn btn-success w-50">Upload</button>
                </div>
            </form>
</div>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $uploaddir = "uploads/";

        if(!is_dir($uploaddir))
            mkdir($uploaddir);

        $arquivo = $_FILES['arquivo']['name'];
        $uploadfile = $uploaddir . $arquivo;

        $sistema = $_POST['sistema'];

        if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadfile))
        {
            $sql = "insert into arquivos (nome, sistema) values('$arquivo','$sistema')";

            if($conexao->query($sql))
            {
                header("refresh: 3; url=arquivos.php");
                echo '<div id="spinner-overlay">
                        <div id="spinner"></div>
                      </div>';
            }
            else
                echo '<div class="alert alert-danger mt-4">
                        <strong>Erro ao Cadastrar arquivo no Banco Dados.</strong>.
                    </div>';
        }
        else
            echo '<div class="alert alert-danger mt-4">
                     <strong>Erro mover Arquivo.</strong>.
                  </div>';
    }
    $conexao->close();
?>
   
</body>
</html>