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
    <title>Arquivos Cadastrados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/arquivos.css">
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
        include_once("conexaoSGBD.php");
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
    echo '<div id="container-tabela">
            <h3>📃 Arquivos</h3>
            <a href="upload.php" class="btn btn-success">Novo</a> 
            <br><br>';

            if(isset($_GET['nome'])) // linha 84, name="nome"
                $selecionado = $_GET['nome']; // guarda o valor da url da opção selecionada
            else 
                $selecionado = '';

            $sql = "select nome from sistemas";
            
            if($dados = $conexao->query($sql))
            {
              echo '<form method="GET" action="arquivos.php">
                        <select name="nome" class="form-select w-50" id="categoria" onchange="this.form.submit()">
                          <option value="" selected disabled hidden>Sistema</option>';
              while($row = $dados->fetch_assoc())
              {
                  $nome = $row['nome'];
                  echo '<option>'.$nome.'</option>';
              }
            }
            echo '</select>
                  </form>';
          
            if(!empty($selecionado))
              $sql = "select arquivos.id, arquivos.nome as nome_arquivo, sistemas.nome as nome_sistema from arquivos join sistemas on arquivos.sistema = sistemas.id where sistemas.nome = '$selecionado'";
            else
              $sql = "select arquivos.id, arquivos.nome as nome_arquivo, sistemas.nome as nome_sistema from arquivos join sistemas on arquivos.sistema = sistemas.id";

              if($resultado = $conexao->query($sql))
              {
                echo '<br>';
                echo '<p><b>📋 Registros: '.$resultado->num_rows.'</b></p>';

                if($resultado->num_rows > 0)
                {
                  echo '<div id="tabela-responsiva">';
                  echo '<table class="table table-striped table-hover table-responsive">
                              <thead class="text-center">
                                <tr>
                                  <th>ID</th>
                                  <th>Nome</th>
                                  <th>Sistema</th>
                                  <th>Ações</th>
                                </tr>
                              </thead>
                              <tbody class="text-center">';
                    while($linha = $resultado->fetch_assoc())
                    {
                        $id = $linha['id'];
                        $nome = $linha['nome_arquivo'];
                        $sistema = $linha['nome_sistema'];
                        echo '<tr>
                                <td>'.$id.'</td>
                                <td>'.$nome.'</td>
                                <td>'.$sistema.'</td>
                                <td>
                                  <a href="alterar_arquivo.php?id='.$id.'" class="btn btn-outline-primary mt-2 mt-sm-0"><i class="bi bi-pencil-square"></i></a>
                                  <a href="excluir_arquivo.php?id='.$id.'" class="btn btn-outline-danger mt-2 mt-sm-0"><i class="bi bi-x-circle"></i></a>
                                  <a href="uploads/'.$nome.'" class="btn btn-outline-info mt-2 mt-sm-0"><i class="bi bi-download"></i></a>
                                </td>
                              </tr>';
                    }
                    echo '</tbody>
                          </table>
                          </div>';
                }
                else
                  echo '<div class="alert alert-warning mt-4">
                          <strong>Nenhum Resultado</strong>.
                        </div>';
              }
              else
                  echo '<div class="alert alert-danger">
                          <strong>Erro na Consulta</strong>.
                        </div>';
           echo '</div>';
          $conexao->close();
?>

</div>

</body>
</html>