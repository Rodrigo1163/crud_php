<?php
session_start();
require_once('../../connection/conexao.php');

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

    $sqlUserExist = "SELECT email FROM usuarios WHERE email = '$email'";
    $queryUserExist = mysqli_query($conexao, $sqlUserExist);
    if (mysqli_num_rows($queryUserExist) > 0) {
        $_SESSION['mensagem'] = 'Esse usuário ja existe';
        header('Location: ../../pages/dashboard.php');
        return;
    }

    $query = "INSERT INTO usuarios (nome, email, data_nascimento, senha) 
                  VALUE ('$nome', '$email', '$data_nascimento', '$senha')
        ";

    try {
        mysqli_query($conexao, $query);
        if (mysqli_affected_rows($conexao) > 0) {
            $_SESSION['mensagem'] = 'Usuário criado com sucesso';
            header('Location: ../../pages/dashboard.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Usuário não foi criado';
            header('Location: ../../pages/dashboard.php');
            exit;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
