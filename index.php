<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/style.css">
    <link rel="stylesheet" href="/styles/index.css">
    <title>YParking</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>


<body class="body-index">

    <div class="box1">
        <div class="title-login">
            <h1>Faça Login</h1>
            <div class="line-box-login"></div>
        </div>

        <img src="/assets/imgs/logo.png" alt="Logo da YParking">

        <div class="circle-login">
            <i class="fa-solid fa-angle-right"></i>
        </div>
    </div>

    <div class="box2">
        <form action="index.php" method="POST">
            <div class="user">
                <label for="input_user">EMAIL:</label>
                <input type="email" placeholder="Digite seu email" name="input_user" maxlength="35" required>
            </div>

            <div class="password">
                <label for="input_password">SENHA:</label>
                <input type="password" placeholder="Digite sua senha" name="input_password" maxlength="35" required>
            </div>

            <p class="password-recovery">Para alterar sua senha, <a href="#">clique aqui!</a></p>

            <input type="submit" value="ENTRAR" class="submit-button">
        </form>
    </div>

</body>

</html>