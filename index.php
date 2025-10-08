<?php
session_start();

if(!isset($_SESSION['nome']))
  header("location: login.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload e Download Arquivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<nav class="bottom-navigation">
  <?php
      if(isset($_SESSION['adm']) and $_SESSION['adm'] == 'administrador')
      {
        echo '<a href="sistemas.php" class="nav-item">
                <i class="bi bi-gear"></i>
                <span>Sistemas</span>
              </a>
              <a href="arquivos.php" class="nav-item">
                <i class="bi bi-archive"></i>
                <span>Arquivos</span>
              </a>
              <a href="usuario.php" class="nav-item">
                <i class="bi bi-person"></i>
                <span>Usuário</span>
              </a>';
      }
      else
      {
        echo '<a href="sistemas.php" class="nav-item">
                <i class="bi bi-gear"></i>
                <span>Sistemas</span>
              </a>
              <a href="arquivos.php" class="nav-item">
                <i class="bi bi-archive"></i>
                <span>Arquivos</span>
              </a>';
      }
  ?>
</nav>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="height: 70px;">
  <div class="container-fluid">
      <a href="index.php" class="btn btn-outline-secondary btn-sm me-3"><i class="bi bi-house"></i> Página Inicial</a>
      <?php
        if(isset($_SESSION['adm']))
          echo '<div class="ms-auto">
                  <div class="d-flex dropdown">
                    <a href="#" class="d-flex align-items-center text-info text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                      <strong>'.$_SESSION['nome'].'</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser2">
                      <li><a class="dropdown-item text-center" href="trocar_senha.php">Trocar Senha</a></li>
                      <li><a class="dropdown-item text-center text-danger" href="logout.php">🔚 Sair</a></li>
                    </ul>
                  </div>
                </div>';
      ?>
  </div>
</nav>

<?php
    echo '<div class="top-menu-horizontal">
            <ul class="nav nav-pills" style="display: flex; justify-content: center; flex-wrap: nowrap; background-color: black; min-width: max-content;">';
              if(isset($_SESSION['adm']) and $_SESSION['adm'] == 'administrador') 
              {
                echo '<li class="nav-item">
                        <a class="nav-link text-white" id="nav-link" href="sistemas.php">⚙️ Sistemas</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link text-white" id="nav-link" href="arquivos.php">📄 Arquivos</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link text-white" id="nav-link" href="usuario.php">🙎🏽‍♂️ Usuários</a>
                      </li>';
              } 
              else 
              {
                echo '<li class="nav-item">
                        <a class="nav-link text-white" id="nav-link" href="sistemas.php">⚙️ Sistemas</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link text-white" id="nav-link" href="arquivos.php">📄 Arquivos</a>
                      </li>';
              }
     echo '</ul>
          </div>';
?>

<div id="carouselPrincipal" class="carousel slide" data-bs-ride="carousel">

    <div class="carousel-item active">
        <img src="img/download_upload.jpg" class="d-block w-100 img-fluid" style="height: 810px;">
    </div>

</div>

</body>
</html>