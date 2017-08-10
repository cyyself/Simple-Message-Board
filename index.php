<?php
	include_once('config.php');
	function show_msg($type,$time,$content) {
		date_default_timezone_set('Asia/Shanghai');
		echo '<table border="1" width="256px">' . "\n";
		echo '	<tr>' . "\n";
		echo '		<td>' . "\n";
		echo '			' . $type . "\n";
		echo '		</td>' . "\n";
		echo '		<td>' . "\n";
		echo '			' . date('Y-m-d H:i',$time) . "\n";
		echo '		</td>' . "\n";
		echo '	</tr>' . "\n";
		echo '	<tr>' . "\n";
		echo '		<td colspan="2">' . "\n";
		echo '			' . htmlspecialchars($content) . "\n";
		echo '		</td>' . "\n";
		echo '	</tr>' . "\n";
		echo '</table>' . "\n";
	}
	function show_detailed_msg($type,$time,$content,$ua,$ip,$id) {
		date_default_timezone_set('Asia/Shanghai');
		echo '<table border="1" width="256px">' . "\n";
		echo '	<tr>' . "\n";
		echo '		<td>' . "\n";
		echo '			' . $type . "\n";
		echo '		</td>' . "\n";
		echo '		<td>' . "\n";
		echo '			' . date('Y-m-d H:i',$time) . "\n";
		echo '		</td>' . "\n";
		echo '	</tr>' . "\n";
		echo '	<tr>' . "\n";
		echo '		<td colspan="2">' . "\n";
		echo '			' . htmlspecialchars($content) . "\n";
		echo '		</td>' . "\n";
		echo '	</tr>' . "\n";
		echo '	<tr>' . "\n";
		echo '		<td colspan="2">' . "\n";
		echo '			' . htmlspecialchars($ua) . "\n";
		echo '		</td>' . "\n";
		echo '	</tr>' . "\n";
		echo '	<tr>' . "\n";
		echo '		<td colspan="2">' . "\n";
		echo '			' . htmlspecialchars($ip) . "\n";
		echo '		</td>' . "\n";
		echo '	</tr>' . "\n";
		echo '	<tr>' . "\n";
		echo '		<td colspan="2">' . "\n";
		echo '			<a href="delete.php?key=' . $_GET['key'] . '&id=' . $id . '">删除</a>' . "\n";
		echo '		</td>' . "\n";
		echo '	</tr>' . "\n";
		echo '</table>' . "\n";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1, user-scalable=0">
		<meta charset="utf-8" />
		<title>简易留言板</title>
	</head>
	<body>
		<center>
		<h1>简易留言板</h1>
		<h2>欢迎来这里给我留言</h2>
		<a href="new.php">新建留言</a>
		<hr>
		<form action="index.php" method="GET">
			<select name="type">
				<option value="">全部</option>
				<?php
					foreach($types as $each) {
						if ($each == $_GET['type']) 
							echo '<option value="' . $each .'" selected>' . $each . '</option>';
						else
							echo '<option value="' . $each .'">' . $each . '</option>';
					}
				?>
			</select>
			<input name="key" type="text" value="<?php echo $_GET['key']; ?>" hidden>
			<input type="submit" value="筛选">
		</form>
		<?php
			$db = new PDO('sqlite:msg.db');
			if ($db) {
				$db->exec('CREATE TABLE IF NOT EXISTS msg (
					ID INTEGER PRIMARY KEY,
					TYPE TEXT,
					CONTENT TEXT,
					TIME TEXT,
					USERAGENT TEXT,
					IPADDRESS TEXT
				);');
				$stmt = $db->prepare("SELECT * FROM msg WHERE TYPE LIKE :t ORDER BY ID desc");
				$typestring = $_GET['type'];
				if ($typestring == "") $typestring = "%";
				$stmt->bindParam(':t',$typestring);
				$stmt->execute();
				$result = $stmt->fetchAll();
				foreach($result as $each) {
					if ($_GET['key'] == $detialkey) show_detailed_msg($each['TYPE'],$each['TIME'],$each['CONTENT'],$each['USERAGENT'],$each['IPADDRESS'],$each['ID']);
					else show_msg($each['TYPE'],$each['TIME'],$each['CONTENT']);
					echo '<br />';
				}
			}
			else echo "Error 500 数据库连接失败。";
		?>
		</center>
	</body>
</html>
