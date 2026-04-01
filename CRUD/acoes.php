<?php
session_start();
require 'conexao.php'; // Certifique-se que o arquivo conexao.php está na mesma pasta

if (isset($_POST['create_usuario'])) {
    
    // 1. Limpeza e captura dos dados (usando $conn conforme seu conexao.php)
    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conn, trim($_POST['data_nascimento']));
    
    // 2. Correção da Senha: Captura o campo correto e aplica criptografia (Hash)
    if (!empty($_POST['senha'])) {
        $senha_pura = trim($_POST['senha']);
        $senha_hash = password_hash($senha_pura, PASSWORD_DEFAULT);
    } else {
        // Caso a senha não tenha sido enviada
        $_SESSION['mensagem'] = "Erro: A senha é obrigatória.";
        header("Location: index.php");
        exit;
    }

    // 3. Montagem da Query SQL
    $sql = "INSERT INTO usuarios (nome, email, data_nascimento, senha) 
            VALUES ('$nome', '$email', '$data_nascimento', '$senha_hash')";

    // 4. Execução e Redirecionamento
    if (mysqli_query($conn, $sql)) {
        $_SESSION['mensagem'] = "Usuário criado com sucesso!";
        header("Location: index.php"); // Altere para a sua página principal
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao criar usuário: " . mysqli_error($conn);
        header("Location: index.php");
        exit;
    }

}
if (isset($_POST['edit_usuario'])) {
    
    // 1. Captura o ID e limpa os dados
    $usuario_id = mysqli_real_escape_string($conn, $_POST['usuario_id']);
    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conn, trim($_POST['data_nascimento']));
    
    // 2. Montagem da Query Base
    $sql = "UPDATE usuarios SET 
            nome = '$nome', 
            email = '$email', 
            data_nascimento = '$data_nascimento'";
    
    // 3. Verifica se o usuário digitou uma nova senha
    if (!empty($_POST['senha'])) {
        $senha_pura = trim($_POST['senha']);
        $senha_hash = password_hash($senha_pura, PASSWORD_DEFAULT);
        $sql .= ", senha = '$senha_hash'"; // Adiciona a senha na query se não estiver vazia
    }

    // 4. Finaliza a query com o WHERE
    $sql .= " WHERE id = '$usuario_id'";

    // 5. Execução e Redirecionamento
    if (mysqli_query($conn, $sql)) {
        $_SESSION['mensagem'] = "Usuário atualizado com sucesso!";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar usuário: " . mysqli_error($conn);
        header("Location: index.php");
        exit;
    }

}
if (isset($_POST["delete_usuario"])) {
    $usuario_id = mysqli_real_escape_string($conn, $_POST['delete_usuario']);
    $sql = "DELETE FROM usuarios WHERE id='$usuario_id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['mensagem'] = "Usuário excluído com sucesso!";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir usuário: " . mysqli_error($conn);
        header("Location: index.php");
        exit;
    }

}




?>