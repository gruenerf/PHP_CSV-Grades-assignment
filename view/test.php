<?php
require("../config.php");
?>

<html>
<head>
	<title>List of People</title>
</head>
<body>

<?php

$a = array('asd','asd','asd','asd');
if($a[0] && $a[1] && $a[2] && $a[3]){
	$studentId = $a[0];
	$courseId = $a[1];
	$grade = $a[2];
	$year = $a[3];
}else{
echo 'asdasd';
}?>
</body>
</html>
