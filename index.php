<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ホーム画面</title>
</head>
<body>
    <?php
        // データベース接続
        $dsn="mysql:dbname=tb250668db;host=localhost";
        $user="tb-250668";
        $password="4BashzfAUf";
        $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
        $sql="CREATE TABLE IF NOT EXISTS food_menu"
        ."("
        ."food_name TEXT,"
        ."food_img TEXT,"
        ."material TEXT,"
        ."type TEXT,"
        ."category TEXT,"
        ."memo TEXT"
        .");";
        $stmt=$pdo->query($sql);
    ?>
    <h1>献立登録</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label>
            料理名
            <input type="text" name="add_food_name">
        </label>    
        <br>
        <label>
            料理の画像
            <input type="file" name="uploaded_img">
        </label>
        <br>
        <label>
            材料
            <input type="text" name="add_material">
        </label>
        <br>
        <label>
            ジャンル
            <input type="text" name="add_type">
        </label>
        <br>
        <label>
            カテゴリー
            <input type="text" name="add_category">
        </label>
        <br>
        <label>
            ひとことメモ
            <input type="text" name="add_memo">
        </label>
        <br>
        <input type="submit" value="献立を登録する" name="menu_add">
    </form>  
    <hr>
    <h1>献立検索</h1>
    <h2>絞り込まずに検索する</h2>
    <form action="" method="post">
        <input type="submit" value="献立を探す" name="menu_search">
    </form>
    <hr>
    <h2>材料で絞り込む</h2>
    <form action="" method="post">
        <label>
            材料
            <input type="text" name="search_material">
        </label>
        <br>
        <input type="submit" value="献立を探す" name="material_search">
    </form>
    <hr>
    <h2>ジャンルで絞り込む</h2>
    <form action="" method="post">
        <label>
            ジャンル
            <input type="text" name="search_type">
        </label>
        <br>
        <input type="submit" value="献立を探す" name="type_search">
    </form>
    <hr>
    <h2>カテゴリーで絞り込む</h2>
    <form action="" method="post">
        <label>
            カテゴリー
            <input type="text" name="search_category">
        </label>
        <br>
        <input type="submit" value="献立を探す" name="category_search">
    </form>
    <hr>
    <h1>献立削除</h1>
    <form action="" method="post">
        <label>
            料理名
            <input type="text" name="delete_food_name">
        </label>
        <br>
        <input type="submit" value="献立を削除する" name="menu_delete">
    </form>
    <hr>
    <?php
    // 献立登録機能
        if(isset($_POST["menu_add"]) && isset($_POST["add_food_name"])){
            $food_name=$_POST["add_food_name"];
            $material=$_POST["add_material"];
            $type=$_POST["add_type"];
            $category=$_POST["add_category"];
            $memo=$_POST["add_memo"];
            if(!empty($_FILES)){
                $filename=$_FILES["uploaded_img"]["name"];
                $uploaded_path="images/".$filename;
                $result=move_uploaded_file($_FILES["uploaded_img"]["tmp_name"],$uploaded_path);
                if($result){
                    $img_path=$uploaded_path;
                }
            }
            $sql="INSERT INTO food_menu(food_name,material,type,category,memo,food_img) VALUES(:food_name,:material,:type,:category,:memo,:food_img)";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(":food_name",$food_name,PDO::PARAM_STR);
            $stmt->bindParam(":material",$material,PDO::PARAM_STR);
            $stmt->bindParam(":type",$type,PDO::PARAM_STR);
            $stmt->bindParam(":category",$category,PDO::PARAM_STR);
            $stmt->bindParam(":memo",$memo,PDO::PARAM_STR);
            $stmt->bindParam(":food_img",$img_path,PDO::PARAM_STR);
            $stmt->execute();                       
        }
    // 献立検索機能（絞り込みなし）
        else if(isset($_POST["menu_search"])){
            $sql="SELECT * FROM food_menu";
            $stmt=$pdo->query($sql);
            $results=$stmt->fetchAll();
            foreach($results as $row){
                echo "料理名：".$row["food_name"]."　";
                echo "材料：".$row["material"]."　";
                echo "ジャンル：".$row["type"]."　";
                echo "カテゴリー：".$row["category"]."　";
                echo "ひとことメモ：".$row["memo"]."<br>";
                ?>
                <img src="<?php echo $row["food_img"];?>" alt="画像未登録" width=20% height=20%>
                <?php
                echo "<hr>";   
            }
        }
    // 献立検索機能（材料による絞り込み）
        else if(isset($_POST["material_search"])){
            $material=$_POST["search_material"];
            $sql="SELECT * FROM food_menu where material like '%$material%'";
            $stmt=$pdo->prepare($sql);
            $stmt->bindValue(":material",$material,PDO::PARAM_STR);
            $stmt->execute();
            $results=$stmt->fetchAll();
            foreach($results as $row){
                echo "料理名：".$row["food_name"]."　";
                echo "材料：".$row["material"]."　";
                echo "ジャンル：".$row["type"]."　";
                echo "カテゴリー：".$row["category"]."　";
                echo "ひとことメモ：".$row["memo"]."<br>";
                ?>
                <img src="<?php echo $row["food_img"];?>" alt="画像未登録" width=20% height=20%>
                <?php
                echo "<hr>";     
            }
        }
    // 献立検索機能（ジャンルによる絞り込み）
        else if(isset($_POST["type_search"])){
            $type=$_POST["search_type"];
            $sql="SELECT * FROM food_menu where type like '%$type%'";
            $stmt=$pdo->prepare($sql);
            $stmt->bindValue(":type",$type,PDO::PARAM_STR);
            $stmt->execute();
            $results=$stmt->fetchAll();
            foreach($results as $row){
                echo "料理名：".$row["food_name"]."　";
                echo "材料：".$row["material"]."　";
                echo "ジャンル：".$row["type"]."　";
                echo "カテゴリー：".$row["category"]."　";
                echo "ひとことメモ：".$row["memo"]."<br>";
                ?>
                <img src="<?php echo $row["food_img"];?>" alt="画像未登録" width=20% height=20%>
                <?php
                echo "<hr>";     
            }
        }
    // 献立検索機能（カテゴリーによる絞り込み）
        else if(isset($_POST["category_search"])){
            $category=$_POST["search_category"];
            $sql="SELECT * FROM food_menu where category like '%$category%'";
            $stmt=$pdo->prepare($sql);
            $stmt->bindValue(":category",$category,PDO::PARAM_STR);
            $stmt->execute();
            $results=$stmt->fetchAll();
            foreach($results as $row){
                echo "料理名：".$row["food_name"]."　";
                echo "材料：".$row["material"]."　";
                echo "ジャンル：".$row["type"]."　";
                echo "カテゴリー：".$row["category"]."　";
                echo "ひとことメモ：".$row["memo"]."<br>";
                ?>
                <img src="<?php echo $row["food_img"];?>" alt="画像未登録" width=20% height=20%>
                <?php
                echo "<hr>";      
            }
        }
    // 献立削除機能
        else if(isset($_POST["delete_food_name"]) && isset($_POST["menu_delete"])){
            $food_name=$_POST["delete_food_name"];
            $stmt=$pdo->prepare("DELETE FROM food_menu where food_name=:food_name");
            $stmt->bindParam(":food_name",$food_name,PDO::PARAM_STR);
            $stmt->execute();
        }
    ?>
    
    
    
</body>
</html>