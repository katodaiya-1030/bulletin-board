<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録画面</title>
</head>
<body>
    <h1>新規登録</h1>
    <form action="register.php" method="post">
        <label>
            名前：
            <input type="text" name="name">
        </label>    
        <br>
        <label>
            パスワード：
            <input type="text" name="pass">
        </label>
        <input type="submit" value="登録" name="signup">
    </form>    
    <a href="login_form.php">登録済みの方はこちらから</a>
</body>
</html>