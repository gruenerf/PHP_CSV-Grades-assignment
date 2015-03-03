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
	<?php foreach ($courseController->getAllCourse() as $course):?>
		<tr>
			<td>
				<?= $lecturer->getTitle(); ?>
			</td>
			<td>
				<?= $lecturer->getName(); ?>
			</td>
		</tr>

		$currCourses = count($lecturer->getCurrentCourse());
		$prevCourses = count($lecturer->getPreviousCourse());
		echo "<tr><td>" . $lecturer->getTitle() . "</td><td>" . $lecturer->getName() . "</td><td>" . $lecturer->getSurname() . "</td><td>" . $lecturer->getBirthday() . "</td><td>" . $lecturerController->getWorkload($lecturer) . "</td><td>" . $currCourses . "</td><td>" . $prevCourses . "</td></tr>";

	<?php endforeach; ?>
</table>

</body>
</html>
