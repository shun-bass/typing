<!-- 正答率と結果画面のコード -->
<?php 
session_start();   
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>結果画面</title>
</head>
<body>
    <p>正答率:<?php echo $_SESSION['correctAnswers'] / 5 * 100; ?>%</p>
    <p>5問中<?php echo $_SESSION['correctAnswers']; ?>問正解</p>

<table border="1">
    <tr><th>No</th><th>正答率</th><th>お題</th></tr>
        <?php for($i = 0; $i < 5; $i++) { ?>
        <tr>
            <td><?php echo $_SESSION['data'][$i]['id']; ?></td>
            <td><?php echo $_SESSION['data'][$i]['judge']; ?></td>
            <td><?php echo $_SESSION['data'][$i]['romaji']; ?></td>
        </tr>   
        <?php } ?> 
</table>

<form action="start.php" method="POST">
    <button type="submit">もう一度遊ぶ</button>
</form>