<?php
require("../config.php");
?>

<html>
<head>
	<title>List of People</title>
</head>
<body>
<h2>Courses</h2>
<table>
	<thead>
	<tr>
		<td>Title</td>
		<td>ECTS</td>
		<td>Current number of Groups</td>
		<td>Times previously taught</td>
	</tr>
	</thead>
	<?php foreach ($courseController->getCurrentCoursesGroupsAndPreviously() as $course):?>
		<tr>
			<td>
				<?= $course['name']; ?>
			</td>
			<td>
				<?= $course['ects']; ?>
			</td>
			<td>
				<?= $course['groups']; ?>
			</td>
			<td>
				<?= $course['previously'] ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

</body>
</html>
