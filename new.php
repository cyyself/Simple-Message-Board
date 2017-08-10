<?php
	include_once 'config.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1, user-scalable=0">
		<meta charset="utf-8" />
		<title>提交留言</title>
	</head>
	<body>
		<center>
		<form action="submit.php" method="POST">
			留言类型：
			<select name="type">
				<?php
					foreach($types as $each) echo '<option value="' . $each .'">' . $each . '</option>';
				?>
			</select>
			<br />
			你想说的话：<br />
			<textarea name="text" rows="10" cols="32"></textarea>
			<br />
			<input type="submit" value="提交">
		</form>
		</center>
	</body>
</html>
