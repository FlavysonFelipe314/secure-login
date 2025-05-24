<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?= BASE_DIR?>/cadastroAction" method="POST">        
        <label for="name">
            <span>Name*</span>
            <input type="text" name="name" placeholder="Name..." id="name" >
        </label>
        <label for="email">
            <span>Email*</span>
            <input type="email" name="email" placeholder="Email..." id="email" >
        </label>
        <label for="password">
            <span>Password*</span>
            <input type="password" name="password" placeholder="Password..." id="password" >
        </label>
        <input type="hidden" name="csrf_token" value="<?= $token?>">
        <button type="submit">Entrar</button>
    </form>
</body>
</html>