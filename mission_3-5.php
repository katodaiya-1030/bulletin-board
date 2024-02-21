<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
</head>
<body>
    <?php
        // 投稿番号
        $count=0;
        if(isset($_POST["count"])){
            $count=$_POST["count"];
        }
        if(isset($_POST["submit"])){
            $count++;
        }
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
        <input type="hidden" name="count" value="<?=$count?>">
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
        $filename="mission_3-5.txt";
        $pass_filename="pass_3-5.txt";
        // 削除機能
        if(isset($_POST["delete"])){
            $delete_right=false;
            $pass_lines=file($pass_filename,FILE_IGNORE_NEW_LINES);
            $fp=fopen($pass_filename,"w");
            for($i=0;$i<count($pass_lines);$i++){
                $line=explode("<>",$pass_lines[$i]);
                if($line[0]==$_POST["delete_num"] && $line[1]==$_POST["delete_pass"]){
                    $delete_right=true;
                }
                else{
                    fwrite($fp,$pass_lines[$i].PHP_EOL);
                }
            }
            fclose($fp);
            if($delete_right){
                $lines=file($filename,FILE_IGNORE_NEW_LINES);
                $fp=fopen($filename,"w");
                for($i=0;$i<count($lines);$i++){
                    $line=explode("<>",$lines[$i]);
                    if($line[0]!=$_POST["delete_num"]){
                        fwrite($fp,$lines[$i].PHP_EOL);
                    }
                }
                fclose($fp);    
            }
        }
        
        // 編集機能
        else if(isset($_POST["edit"])){
            $edit_right=false;
            $pass_lines=file($pass_filename,FILE_IGNORE_NEW_LINES);
            $fp=fopen($pass_filename,"w");
            for($i=0;$i<count($pass_lines);$i++){
                $line=explode("<>",$pass_lines[$i]);
                if($line[0]==$_POST["edit_num"] && $line[1]==$_POST["edit_pass"]){
                    $edit_right=true;
                    fwrite($fp,$pass_lines[$i].PHP_EOL);
                }
                else{
                    fwrite($fp,$pass_lines[$i].PHP_EOL);
                }
            }
            fclose($fp);
            if($edit_right){
                $edit_bool=true;
                $lines=file($filename,FILE_IGNORE_NEW_LINES);
                $fp=fopen($filename,"w");
                for($i=0;$i<count($lines);$i++){
                    $line=explode("<>",$lines[$i]);
                    if($line[0]!=$_POST["edit_num"]){
                        fwrite($fp,$lines[$i].PHP_EOL);
                    }
                    else{
                        $date=date("Y年m月d日 H時i分s秒");
                        $str=$_POST["edit_str"];
                        $name=$_POST["edit_name"];
                        fwrite($fp,$_POST["edit_num"]."<>".$name."<>".$str."<>".$date.PHP_EOL);
                        $edit_bool=false;
                    }
                }
                if($edit_bool){
                    $date=date("Y年m月d日 H時i分s秒");
                    $str=$_POST["edit_str"];
                    $name=$_POST["edit_name"];
                    fwrite($fp,$_POST["edit_num"]."<>".$name."<>".$str."<>".$date.PHP_EOL);  
                }
                fclose($fp);    
            }
        }
        
        // テキストファイルに書き込み
        else{
            if(file_exists($filename)){
                $fp = fopen($filename,"a");
                if(isset($_POST["new_str"]) && isset($_POST["new_name"])){
                    $date=date("Y年m月d日 H時i分s秒");
                    $str=$_POST["new_str"];
                    $name=$_POST["new_name"];
                    fwrite($fp, $count."<>".$name."<>".$str."<>".$date.PHP_EOL);
                }
                fclose($fp);
            }
            else{
                echo "テキストファイルが存在しません";
            }  
            if(file_exists($pass_filename)){
                $fp=fopen($pass_filename,"a");
                if(isset($_POST["new_pass"])){
                    fwrite($fp,$count."<>".$_POST["new_pass"].PHP_EOL);    
                } 
                fclose($fp);
            }
        }
        
        // ブラウザに出力
        $lines = file($filename,FILE_IGNORE_NEW_LINES);
        for($i=0;$i<count($lines);$i++){
            $line=explode("<>",$lines[$i]);
            for($j=0;$j<4;$j++){
                echo $line[$j]; 
                echo " ";
            }
            echo "<br>";
        }    
    ?>
</body>
</html>