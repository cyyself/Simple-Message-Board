<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1, user-scalable=0">
		<meta charset="utf-8" />
	</head>
	<body>
<?php
	include_once 'config.php';
	if ($_GET['key'] == $detialkey) {
		if ($_GET['id'] == "") echo "ID不存在。";
		else {
			$db = new PDO('sqlite:msg.db');
			if ($db) {
				$stmt = $db->prepare("DELETE FROM msg WHERE ID=:id");
				$stmt->bindParam(':id',$_GET['id']);
				$stmt->execute();
				echo '<a href="index.php?key=' . $_GET['key'] . '">点击返回</a>';
			}
			else echo "数据库连接失败";
		}
	}
	else echo '密码不正确';
?>
	</body>
</html>
