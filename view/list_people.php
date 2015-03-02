<?php
	require("../config.php");
?>

<html>
<head>
	<title>List of People</title>
</head>
<body>
<h2>Lecturers: <?php echo count($lecturerController->getAllLecturer()) ?></h2>

<h2>Students: <?php echo count($studentController->getAllStudent()); ?></h2>

<!-- Lecturer Table -->
<table>
	<thead>
	<tr>
		<td>title</td>
		<td>name</td>
		<td>surname</td>
		<td>birthday</td>
		<td>workload</td>
		<td>number current courses</td>
		<td>number previous courses</td>
	</tr>
	</thead>
	<?php
	$array = $lecturerController->getAllLecturer();
	foreach ($array as $lecturer) {
		$currCourses = count($lecturer->getCurrentCourse());
		$prevCourses = count($lecturer->getPreviousCourse());

		echo "<tr><td>" . $lecturer->getTitle() . "</td><td>" . $lecturer->getName() . "</td><td>" . $lecturer->getSurname() . "</td><td>" . $lecturer->getBirthday() . "</td><td>" . $lecturerController->getWorkload($lecturer) . "</td><td>" . $currCourses . "</td><td>" . $prevCourses . "</td></tr>";
	}
	?>
</table>

<!-- Student Table -->
<table>
	<thead>
	<tr>
		<td>name</td>
		<td>surname</td>
		<td>birthday</td>
		<td>workload</td>
		<td>GPA</td>
		<td>status</td>
		<td>number registered courses</td>
		<td>number completed courses</td>
	</tr>
	</thead>
	<?php
	$array = $studentController->getAllStudent();
	foreach ($array as $student) {
		$regCourses = count($studentController->getAllRegisteredCourse($student));
		$compCourses = count($studentController->getAllCompletedCourse($student));
		echo "<tr><td>" . $student->getName() . "</td><td>" . $student->getSurname() . "</td><td>" . $student->getBirthday() . "</td><td>" . $studentController->getWorkload($student) . "</td><td>" . $studentController->getGpa($student) . "</td><td>" . $studentController->getStatus($student) . "</td><td>" . $regCourses . "</td><td>" . $compCourses . "</td></tr>";
	}
	?>
</table>
</body>
</html>


