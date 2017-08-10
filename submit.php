<?php
	include_once 'config.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1, user-scalable=0">
		<meta charset="utf-8" />
	</head>
	<body>
	<?php
		if ($_POST['text'] == "") {
			echo '请输入内容<a href="new.html">点击返回</a>';
		}
		else {
			$findtype = false;
			foreach ($types as $each) 
				if ($_POST['type'] == $each) {
					$findtype = true;
				}
			if ($findtype) {
				$db = new PDO('sqlite:msg.db');
				$stmt = $db->prepare("INSERT INTO msg VALUES(null,:type,:c,:t,:ua,:addr);");
				$stmt->bindParam(':type',$_POST['type']);
				$stmt->bindParam(':c',$_POST['text']);
				$stmt->bindParam(':t',time());
				$stmt->bindParam(':ua',$_SERVER['HTTP_USER_AGENT']);
				$stmt->bindParam(':addr',$_SERVER['REMOTE_ADDR']);
				//$stmt->bindParam(':ipaddress',$_SERVER['HTTP_X_FORWARDED_FOR'],SQLITE3_TEXT);
				$stmt->execute();
				echo '<a href="index.php">提交成功！点击返回。</a>';
			}
			else echo '类型不正确<a href="new.html">点击返回</a>';
		}
	?>
	</body>
</html>
