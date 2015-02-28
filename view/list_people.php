<?php
	require("../config.php");
	config();
?>

<html>
<head>
	<title>List of People</title>
</head>
<body>
<h2>Lecturers: <?php count(LecturerModel::getAllLecturer()) ?></h2>

<h2>Students: <?php echo count(StudentModel::getAllStudent()); ?></h2>
<table>
	<thead>
	<tr>
		<td>name</td>
		<td>surname</td>
		<td>birthday</td>
		<td>title</td>
		<td>workload</td>
		<td>number current courses</td>
		<td>number previous courses</td>
	</tr>
	</thead>
	<?php
	$array = LecturerModel::getAllLecturer();
	foreach ($array as $lecturer) {
		$currCourses = count($lecturer->getCurrentCourses());
		$prevCourses = count($lecturer->getPreviousCourses());

		echo "<tr><td>" . $lecturer->getName() . "</td><td>" . $lecturer->getSurname . "</td><td>" . $lecturer->getBirthday() . "</td><td>" . $lecturer->getTitle() . "</td><td>" . $lecturer->getWorkload . "</td><td>" . $currCourses . "</td><td>" . $prevCourses . "</td></tr>";
	}
	?>
</table>
</body>
</html>

