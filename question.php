<!-- 問題画面のコード -->

<?php
    session_start();    

    $question = $_POST['question'];

    // 1問目の場合、DB接続し、レコード全取得。連想配列の配列としてセッションに保存
    if($question == 0) {
        $dsn = 'mysql:dbname=questions;host=localhost;charset=utf8';
        $user = 'root';
        $password = '';
            try{
                $dbh = new PDO($dsn, $user, $password);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT * FROM questions";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                $data = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
                $_SESSION['data'] = $data;
                $_SESSION['correctAnswers'] = 0;
            } catch (PDOException $e) {
                print('Connection failed:'.$e->getMessage());
                die();
            }   
        } else { //２～５問目の場合、セッションを使って前問の入力内容が正解か不正解を判定したい
            $answer = $_POST['answer'];
            if($_SESSION['data'][$question - 1]['romaji'] === $answer) {
                echo '正解';
                $_SESSION['correctAnswers'] += 1;
                $_SESSION['data'][$question - 1]['judge'] = '〇';
            } else {
                echo '不正解';
                $_SESSION['data'][$question - 1]['judge'] = '×';
            } 
        }
    
    if($question - 1 == 4) {
        header('Location: judge.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タイピングゲーム</title>
</head>
<body>
    <p><?php echo $_SESSION['data'][$question]['japanese']; ?></p>
    <p><?php echo $_SESSION['data'][$question]['romaji']; ?></p>
    <form action="" method="POST">
        <input type="text" name="answer">
        <button type="submit" name = "question" value= <?php echo $question + 1; ?>>回答</button>
    </form>
</body>
</html>