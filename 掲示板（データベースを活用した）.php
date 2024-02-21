<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>掲示板</title>
</head>
<body>
    <?php
        // データベース接続
        $dsn="mysql:dbname=データベース名;host=localhost";
        $user="ユーザー名";
        $password="パスワード";
        $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
        $sql="CREATE TABLE IF NOT EXISTS board"
        ."("
        ."id INT AUTO_INCREMENT PRIMARY KEY,"
        ."name CHAR(32),"
        ."comment TEXT,"
        ."password TEXT,"
        ."date TEXT"
        .");";
        $stmt=$pdo->query($sql);
    ?>
    <!--入力フォーム-->
    <form action="" method="post">
        <h1>新規投稿</h1>
        <label>
            名前
            <input type="text" value="名前を入力" name="new_name">
        </label>
        <br>
        <label>
            コメント
            <input type="text" value="コメントを入力" name="new_str">    
        </label>
        <input type="submit" value="投稿" name="submit">
        <br>
        <label>
            パスワード設定
            <input type="text" name="new_pass">
        </label>
        <hr>
        <h1>削除</h1>
        <label>
            削除番号指定
            <input type="number" name="delete_num">
        </label>
        <input type="submit" value="削除" name="delete">
        <br>
        <label>
            パスワード入力
            <input type="text" name="delete_pass">
        </label>
        <hr>
        <h1>編集</h1>
        <label>
            編集番号指定
            <input type="number" name="edit_num">
        </label>
        <br>
        <label>
            名前
            <input type="text" value="名前を入力" name="edit_name">
        </label>
        <br>
        <label>
            コメント
            <input type="text" value="コメントを入力" name="edit_str">
        </label>
        <input type="submit" value="編集" name="edit">
        <br>
        <label>
            パスワード入力
            <input type="text" name="edit_pass">
        </label>
        <hr>
    </form>
    <h1>掲示板</h1>
    <?php
        // 削除機能
        if(isset($_POST["delete"])){
            $delete_num=$_POST["delete_num"];
            $delete_pass=$_POST["delete_pass"];
            $stmt=$pdo->prepare("DELETE FROM board where id=:id and password=:password");
            $stmt->bindParam(":id",$delete_num,PDO::PARAM_INT);
            $stmt->bindParam(":password",$delete_pass,PDO::PARAM_STR);
            $stmt->execute();
        }
        
        // 編集機能
        else if(isset($_POST["edit"])){
            $date=date("Y年m月d日 H時i分s秒");
            $edit_num=$_POST["edit_num"];
            $edit_pass=$_POST["edit_pass"];
            $edit_name=$_POST["edit_name"];
            $edit_str=$_POST["edit_str"];
            $stmt=$pdo->prepare("UPDATE board SET name=:name,comment=:comment,date=:date where id=:id and password=:password");
            $stmt->bindParam(":name",$edit_name,PDO::PARAM_STR);
            $stmt->bindParam(":comment",$edit_str,PDO::PARAM_STR);
            $stmt->bindParam(":date",$date,PDO::PARAM_STR);
            $stmt->bindParam(":id",$edit_num,PDO::PARAM_INT);
            $stmt->bindParam(":password",$edit_pass,PDO::PARAM_STR);
            $stmt->execute();
            
        }
        
        // テキストファイルに書き込み
        else{
            if(isset($_POST["new_str"]) && isset($_POST["new_name"])){
                $date=date("Y年m月d日 H時i分s秒");
                $str=$_POST["new_str"];
                $name=$_POST["new_name"];
                $pass=$_POST["new_pass"];
                if(isset($pass)){
                    $sql="INSERT INTO board(name,comment,date,password) VALUES(:name,:comment,:date,:password)";
                    $stmt=$pdo->prepare($sql);
                    $stmt->bindParam(":name",$name,PDO::PARAM_STR);
                    $stmt->bindParam(":comment",$str,PDO::PARAM_STR);
                    $stmt->bindParam(":date",$date,PDO::PARAM_STR);
                    $stmt->bindParam(":password",$pass,PDO::PARAM_STR);
                    $stmt->execute();                       
                }
                else{
                    $sql="INSERT INTO board(name,comment,date) VALUES(:name,:comment,:date)";
                    $stmt=$pdo->prepare($sql);
                    $stmt->bindParam(":name",$name,PDO::PARAM_STR);
                    $stmt->bindParam(":comment",$str,PDO::PARAM_STR);
                    $stmt->bindParam(":date",$date,PDO::PARAM_STR);
                    $stmt->execute();    
                }
            }
        }
        
        // ブラウザに出力
        $sql="SELECT * FROM board";
        $stmt=$pdo->query($sql);
        $results=$stmt->fetchAll();
        foreach($results as $row){
            echo $row["id"].",";
            echo $row["name"].",";
            echo $row["comment"].",";
            echo $row["date"]."<br>";
        echo "<hr>";
        }
    ?>
</body>
</html>
