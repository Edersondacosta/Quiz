<?php
session_start();
include 'db.php';

// Simulação de usuário logado (substitua por $_SESSION futuramente)
$id_usuario = 1;

// Total de perguntas
$sql_total = "SELECT COUNT(*) as total FROM perguntas";
$res_total = $mysqli->query($sql_total);
$total_perguntas = $res_total->fetch_assoc()['total'];

// Pergunta atual (via GET)
$pagina = isset($_GET['p']) ? (int)$_GET['p'] : 1;
if ($pagina < 1) $pagina = 1;
if ($pagina > $total_perguntas) $pagina = $total_perguntas;

// Busca a pergunta
$sql_pergunta = "SELECT * FROM perguntas WHERE id_pergunta = $pagina";
$res_pergunta = $mysqli->query($sql_pergunta);
$pergunta = $res_pergunta->fetch_assoc();

// Busca respostas possíveis
$sql_respostas = "SELECT * FROM respostas WHERE id_pergunta = $pagina";
$respostas = $mysqli->query($sql_respostas);

// Busca respostas que o usuário já selecionou
$sql_resp_user = "SELECT id_resposta FROM respostas_usuario 
                  WHERE id_usuario = $id_usuario AND id_pergunta = $pagina";
$res_user = $mysqli->query($sql_resp_user);

$respostas_usuario = [];
while ($row = $res_user->fetch_assoc()) {
    $respostas_usuario[] = $row['id_resposta'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pergunta <?= $pagina ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .container { max-width: 600px; margin: auto; }
        .pergunta { font-size: 18px; margin-bottom: 20px; }
        .opcao { margin-bottom: 10px; }
        button { padding: 10px 15px; margin-top: 20px; cursor: pointer; }
        .nav-btns { display: flex; justify-content: space-between; }
    </style>
</head>
<body>
<div class="container">
    <form action="salvar.php" method="post">
        <input type="hidden" name="id_pergunta" value="<?= $pagina ?>">
        <input type="hidden" name="total_perguntas" value="<?= $total_perguntas ?>">

        <div class="pergunta">
            <strong>Pergunta <?= $pagina ?>:</strong> <?= htmlspecialchars($pergunta['enunciado']) ?>
        </div>

        <?php while ($row = $respostas->fetch_assoc()) : ?>
            <div class="opcao">
                <label>
                    <input type="checkbox" name="id_resposta[]" value="<?= $row['id_resposta'] ?>"
                        <?= in_array($row['id_resposta'], $respostas_usuario) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($row['texto_resposta']) ?>
                </label>
            </div>
        <?php endwhile; ?>

        <div class="nav-btns">
            <?php if ($pagina > 1): ?>
                <button type="submit" name="acao" value="voltar">Voltar</button>
            <?php endif; ?>

            <?php if ($pagina < $total_perguntas): ?>
                <button type="submit" name="acao" value="avancar">Avançar</button>
            <?php else: ?>
                <button type="submit" name="acao" value="finalizar">Finalizar</button>
            <?php endif; ?>
        </div>
    </form>
</div>
</body>
</html>
