<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン画面</title>
</head>
<body>
    <h1>ログイン</h1>
    <form action="login.php" method="post">
        <label>
            名前：
            <input type="text" name="name">
        </label>    
        <br>
        <label>
            パスワード：
            <input type="text" name="pass">
        </label>
        <input type="submit" value="ログイン" name="login">
    </form>    
</body>
</html>