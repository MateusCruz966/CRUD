<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuário - Visualizar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>   
    <body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <div class="row">
         <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Visualizar Usuário
                        <a href="index.php" class="btn btn-danger float-end">Voltar</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php
                    if(isset($_GET['id'])) {
                        include 'conexao.php';
                        $id = mysqli_real_escape_string($conn, $_GET['id']);
                        $sql = "SELECT * FROM usuarios WHERE id='$id'";
                        $resultado = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($resultado) > 0) {
                            $usuario = mysqli_fetch_array($resultado);
                            ?>
                            <p><strong>ID:</strong> <?php echo $usuario['id']; ?></p>
                            <p><strong>Nome:</strong> <?php echo $usuario['nome']; ?></p>
                            <p><strong>Email:</strong> <?php echo $usuario['email']; ?></p>
                            <p><strong>Data de Nascimento:</strong> <?php echo date('d/m/Y', strtotime($usuario['data_nascimento'])); ?></p>
                            <?php
                        } else {
                            echo "<h4>Nenhum usuário encontrado</h4>";
                        }
                    } else {
                        echo "<h4>ID do usuário não fornecido</h4>";
                    }
                    ?>
                </div>
            </div>
        </div>
      </div>
    </div>
      
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
  </html>