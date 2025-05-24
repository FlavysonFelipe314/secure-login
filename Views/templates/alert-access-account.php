<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Existe alguém tentando entrar em sua conta nesse momento!</h1>
    <ul>
        <li>IP:</li>
        <li><?=$_SESSION["ip_user_trying"]?></li>
        <li>Navegador:</li>
        <li><?=$_SESSION["browser_user_trying"]?></li>
    </ul>
    <a href=""><button>Fui eu</button></a>
    <br><br>
    <p>Se o botão não funcionar: use este link <a href=""></a></p>
</body>
</html>