<?php
session_start();
include 'db.php';

// Simulação de usuário logado (troque por $_SESSION futuramente)
$id_usuario = 1;

// Dados do formulário
$id_pergunta = (int)$_POST['id_pergunta'];
$total_perguntas = (int)$_POST['total_perguntas'];
$acao = $_POST['acao'];
$respostas = isset($_POST['id_resposta']) ? $_POST['id_resposta'] : [];

// Remove as respostas antigas do usuário para essa pergunta
$sql_delete = "DELETE FROM respostas_usuario 
               WHERE id_usuario = $id_usuario AND id_pergunta = $id_pergunta";
$mysqli->query($sql_delete);

// Insere as novas respostas
foreach ($respostas as $id_resposta) {
    $id_resposta = (int)$id_resposta;
    $sql_insert = "INSERT INTO respostas_usuario (id_usuario, id_pergunta, id_resposta) 
                   VALUES ($id_usuario, $id_pergunta, $id_resposta)";
    $mysqli->query($sql_insert);
}

// Define próxima página
if ($acao === 'avancar') {
    $next = $id_pergunta + 1;
    header("Location: /quiz/perguntas.php?p=$next");
    exit;
} elseif ($acao === 'voltar') {
    $prev = $id_pergunta - 1;
    header("Location: /quiz/perguntas.php?p=$prev");
    exit;
} else {
    echo "<h2>✅ Questionário finalizado! Obrigado por responder.</h2>";
    echo "<p><a href='/quiz/perguntas.php?p=1'>Reiniciar questionário</a></p>";
    exit;
}
