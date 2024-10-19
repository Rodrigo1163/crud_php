<?php
session_start();
require_once('conexao.php');


if (isset($_POST['create_usuario'])) {
    if (empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['data_nascimento'])) {
        $_SESSION['mensagem'] = 'Preencha os campos obrigatórios';
        header('Location: usuario-create.php');
        return;
    }

    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
    $senha = isset($_POST['senha']) ?  mysqli_real_escape_string($conexao, password_hash(trim($_POST['senha']), PASSWORD_DEFAULT)) : '';

    $query = "INSERT INTO usuarios (nome, email, data_nascimento, senha) 
              VALUE ('$nome', '$email', '$data_nascimento', '$senha')
    ";

    try {
        mysqli_query($conexao, $query);
        if (mysqli_affected_rows($conexao) > 0) {
            $_SESSION['mensagem'] = 'Usuário criado com sucesso';
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Usuário não foi criado';
            header('Location: index.php');
            exit;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
if (isset($_POST['update_usuario'])) {
    $usuario_id = mysqli_real_escape_string($conexao, $_POST['usuario_id']);

    if (empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['data_nascimento'])) {
        $_SESSION['mensagem'] = 'Preencha os campos obrigatórios';
        header('Location: usuario-create.php');
        return;
    }

    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
    $senha = isset($_POST['senha']) ?  mysqli_real_escape_string($conexao, password_hash(trim($_POST['senha']), PASSWORD_DEFAULT)) : '';

    $sql = "UPDATE usuarios SET nome = '$nome', email = '$email', data_nascimento = '$data_nascimento'";

    if (!empty($senha)) {
        $sql .= ", senha = '" . password_hash($senha, PASSWORD_DEFAULT) . "'";
    }

    $sql .= " WHERE id = '$usuario_id'";

    try {
        mysqli_query($conexao, $sql);
        if (mysqli_affected_rows($conexao) > 0) {
            $_SESSION['mensagem'] = 'Usuário atualizado com sucesso';
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Usuário não foi atualizado';
            header('Location: index.php');
            exit;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST['delete_usuario'])) {
    $usuario_id = mysqli_real_escape_string($conexao, $_POST['delete_usuario']);

    $sql = "DELETE FROM usuarios WHERE id = '$usuario_id'";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION['mensagem'] = 'Usuário deletado com sucesso';
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['mensagem'] = 'Usuário não foi deletado';
        header('Location: index.php');
        exit;
    }
}
