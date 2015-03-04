<?php
require("../config.php");
?>

<html>
<head>
	<title>List of People</title>
</head>
<body>

<form action="upload_grades.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<input type="file" name="file">
	<input type="submit" name="btn_submit" value="Upload File"/>
</form>

<?php
$fh = fopen($_FILES['file']['tmp_name'], 'r+');

$lines = array();
while (($row = fgetcsv($fh, 8192)) !== FALSE) {
	$lines[] = $row;
}
var_dump($lines);
?></body>
</html>
