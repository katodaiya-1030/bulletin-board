<?php
    session_start();
    $name=$_POST["name"];
    $dsn="mysql:dbname=tb250668db;host=localhost";
    $user="tb-250668";
    $password="4BashzfAUf";
    $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
    $sql="SELECT * FROM users WHERE name=:name";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(":name",$name,PDO::PARAM_STR);
    $stmt->execute();
    $member=$stmt->fetch();
    if(password_verify($_POST["pass"],$member["pass"])){
        $msg="ログイン成功！";
        $link="<a href='index.php'>ホーム画面</a>";
    }
    else{
        $msg="名前もしくはパスワードが間違っています";
        $link="<a href='login_form.php'>ログイン画面に戻る</a>";
    }
?>
<h1>
    <?php
        echo $msg;
    ?>
</h1>
<h2>
    <?php
        echo $link;
    ?>
</h2>