<?php
    $name=$_POST["name"];
    $pass=password_hash($_POST["pass"],PASSWORD_DEFAULT);
    $dsn="mysql:dbname=tb250668db;host=localhost";
    $user="tb-250668";
    $password="4BashzfAUf";
    $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
    $sql="CREATE TABLE IF NOT EXISTS users"
    ."("
    ."name CHAR(32),"
    ."pass TEXT"
    .");";
    $stmt=$pdo->query($sql);
    $sql="SELECT * FROM users WHERE name=:name";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(":name",$name,PDO::PARAM_STR);
    $stmt->execute();
    $member=$stmt->fetch();
    if($member["name"]==$name){
        $msg="すでに登録済みです";
        $link="<a href='login_form.php'>ログイン画面</a>";
    }
    else{
        $sql="INSERT INTO users(name,pass) VALUES(:name,:pass)";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(":name",$name,PDO::PARAM_STR);
        $stmt->bindParam(":pass",$pass,PDO::PARAM_STR);
        $stmt->execute();
        $msg="会員登録が完了しました";
        $link="<a href='login_form.php'>ログイン画面</a>";
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