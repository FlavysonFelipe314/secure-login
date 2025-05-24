<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Seu link de Verificação</h1>
    <a href="<?= $_SESSION["recovery-link"]?>"><button>Clique Aqui</button></a>
    <br><br>
    <p>Se o botão não funcionar: use este link <a href="<?= $_SESSION["recovery-link"]?>"><?= $_SESSION["recovery-link"]?></a></p>
</body>
</html>