<?php
session_start();
require_once('../../connection/conexao.php');

if (isset($_POST['delete_usuario'])) {
    $usuario_id = mysqli_real_escape_string($conexao, $_POST['delete_usuario']);

    $sql = "DELETE FROM usuarios WHERE id = '$usuario_id'";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION['mensagem'] = 'Usuário deletado com sucesso';
        header('Location: ../../pages/dashboard.php');
        exit;
    } else {
        $_SESSION['mensagem'] = 'Usuário não foi deletado';
        header('Location: ../../pages/dashboard.php');
        exit;
    }
}
