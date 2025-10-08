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
    <title>Sistemas Cadastrados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/sistemas.css">
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
        require("conexaoSGBD.php");
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

<div class="d-flex">
  <div class="sidebar">
    <?php 
        if(isset($_SESSION['adm']) and $_SESSION['adm'] == 'administrador') 
        {
          echo '<a href="sistemas.php" class="menu-item">⚙️ Sistemas</a>
                <a href="arquivos.php" class="menu-item logout">📄 Arquivos</a>
                <a href="usuario.php" class="menu-item logout">🙎🏽‍♂️ Usuários</a>';
        } 
        else 
        {
          echo '<a href="sistemas.php" class="menu-item">⚙️ Sistemas</a>
                <a href="arquivos.php" class="menu-item logout">📄 Arquivos</a>';
        }
    ?>
  </div>
   
<?php
    echo '<div id="container-tabela" class="p-3">
            <h3>⚙️ Sistemas</h3>
            <a href="cadastro_sistemas.php" class="btn btn-success mt-2 mt-sm-0">Novo</a> ';
          
              $sql = "select * from sistemas";

              if($resultado = $conexao->query($sql))
              {
                echo '<br><br>';
                echo '<p><b>📋 Registros: '.$resultado->num_rows.'</b></p>';
                echo '<div id="tabela-responsiva">';
                echo '<table class="table table-striped table-hover table-responsive">
                            <thead class="text-center">
                              <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Ações</th>
                              </tr>
                            </thead>
                            <tbody class="text-center">';
                  while($linha = $resultado->fetch_assoc())
                  {
                      $id = $linha['id'];
                      $nome = $linha['nome'];
                      echo '<tr>
                              <td>'.$id.'</td>
                              <td>'.$nome.'</td>
                              <td>
                                <a href="alterar_sistema.php?id='.$id.'" class="btn btn-outline-primary mt-2 mt-sm-0"><i class="bi bi-pencil-square"></i></a>
                                <a href="excluir_sistema.php?id='.$id.'" class="btn btn-outline-danger mt-2 mt-sm-0"><i class="bi bi-x-circle"></i></a>
                              </td>
                            </tr>';
                  }
                  echo '</tbody>
                        </table>
                        </div>';
              }
              else
                  echo '<div class="alert alert-danger mt-4">
                        <strong>Erro na Consulta.</strong>.
                      </div>';
                  $conexao->close();
           echo '</div>';
?>

</div>

</body>
</html>