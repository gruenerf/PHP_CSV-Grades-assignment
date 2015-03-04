<?php
require("../config.php");
?>

<html>
<head>
	<title>List of People</title>
</head>
<body>

<table>
	<thead>
	<tr>
		<td><a href="?attr=title&dir=asc">^</a><a href="?attr=title&dir=desc">v</a> CourseTitle</input></a></td>
		<td><a href="?attr=group&dir=asc">^</a><a href="?attr=group&dir=desc">v</a>Group</a></td>
		<td><a href="?attr=name&dir=asc">^</a><a href="?attr=name&dir=desc">v</a>Student Name</a></td>
		<td><a href="?attr=surname&dir=asc">^</a><a href="?attr=surname&dir=desc">v</a>Student Surname</a></td>
		<td><a href="?attr=semester&dir=asc">^</a><a href="?attr=semester&dir=desc">v</a>Semester</a></td>
		<td><a href="?attr=grade&dir=asc">^</a><a href="?attr=grade&dir=desc">v</a>Grade</a></td>
	</tr>
	</thead>
	<?php

	$attr = null;
	$dir = null;

	/**
	 * Validation
	 */
	$attrArray = array(
		'title', 'group', 'name', 'surname', 'semester', 'grade'
	);

	$dirArray = array(
		'asc', 'desc'
	);

	if (isset($_GET['attr']) & isset($_GET['dir'])) {
		if (in_array($_GET['attr'], $attrArray) & in_array($_GET['dir'], $dirArray)) {
			$attr = $_GET['attr'];
			$dir = $_GET['dir'];
		} else {
			header("#"); /* Redirect browser */
		}
	} else {
		header("#"); /* Redirect browser */
	}


	foreach ($gradeController->getAllSorted($attr, $dir) as $grade): ?>
		<tr>
			<td>
				<?= $grade['title']; ?>
			</td>
			<td>
				<?= $grade['group']; ?>
			</td>
			<td>
				<?= $grade['name']; ?>
			</td>
			<td>
				<?= $grade['surname']; ?>
			</td>
			<td>
				<?= $grade['semester']; ?>
			</td>
			<td>
				<?= $grade['grade']; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
</body>
</html>
