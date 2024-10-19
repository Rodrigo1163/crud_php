<?php
session_start();

require 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container mt-4">
        <?php include('mensagem.php'); ?>
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
                            <a href="geraexcel.php" class="btn btn-success float-end me-3">
                                Gerar excel
                            </a>
                        </h4>
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
                                $query = 'SELECT * FROM usuarios';
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
                                                <form action="acoes.php" method="POST" class="d-inline">
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
</body>

</html>