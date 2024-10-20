<?php
session_start();
require '../connection/conexao.php';

$inputSearch = isset($_GET['search']) ? $_GET['search'] : '';
if (empty($_GET['search'])) {
    $query = 'SELECT * FROM usuarios';
} else {
    $query = "SELECT * FROM usuarios WHERE nome LIKE '%" . $inputSearch . "%'";
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - PHP</title>

    <!-- Todas as importações estão nesse crude -->
    <?php include('../components/imports.php') ?>
</head>

<body>
    <?php include('../components/navbar.php'); ?>

    <div class="container mt-4">
        <?php include('../components/mensagem.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Lista de Usuários
                            <a
                                href="usuario-create.php"
                                class="btn btn-primary float-end">
                                Adicionar usuário
                            </a>
                            <a href="../functions/excel/geraexcel.php" class="btn btn-success float-end me-3">
                                Gerar excel
                            </a>
                        </h4>
                    </div>
                    <div class="d-flex card-body gap-1">
                        <input type="search" class="form-control" placeholder="Pesquisar" id="pesquisar" value="<?= $inputSearch ?>">
                        <button onclick="searchRedirect()" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                            </svg>
                        </button>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Data Nascimento</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $usuarios = mysqli_query($conexao, $query);
                                if (mysqli_num_rows($usuarios) > 0) {
                                    foreach ($usuarios as $usuario) {

                                ?>
                                        <tr>
                                            <td><?= $usuario['id'] ?></td>
                                            <td><?= $usuario['nome'] ?></td>
                                            <td><?= $usuario['email'] ?></td>
                                            <td><?= date('d/m/Y', strtotime($usuario['data_nascimento'])) ?></td>
                                            <td>
                                                <a href="usuario-view.php?id=<?= $usuario['id'] ?>" class="btn btn-secondary btn-sm">
                                                    Visualizar
                                                </a>
                                                <a href="usuario-edit.php?id=<?= $usuario['id'] ?>" class="btn btn-success btn-sm">
                                                    editar
                                                </a>
                                                <form action="../functions/usuarios/delete_usuario.php" method="POST" class="d-inline">
                                                    <button
                                                        onclick="return confirm('Tem certeza que deseja excluir?')"
                                                        type="submit"
                                                        name="delete_usuario"
                                                        value="<?= $usuario['id']; ?>"
                                                        class="btn btn-danger btn-sm">
                                                        Excluir
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo '<h5>Nenhum usuário encontrado</h5>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../assets/js/searchDashboard.js"></script>
</body>

</html>