<h2>Lecturers: <?php echo count($lecturerController->getAll()) ?> | Students: <?php echo count($studentController->getAll()); ?></h2>

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
	<tbody>
	<?php
	foreach ($lecturerController->getAll() as $lecturer): ?>
		<tr>
			<td>
				<?= $lecturer->getTitle(); ?>
			</td>
			<td>
				<?= $lecturer->getName(); ?>
			</td>
			<td>
				<?= $lecturer->getSurname(); ?>
			</td>
			<td>
				<?= $lecturer->getBirthday(); ?>
			</td>
			<td>
				<?= $lecturerController->getWorkload($lecturer); ?>
			</td>
			<td>
				<?= count($lecturerController->getAllCourseByLecturerCurrent($lecturer)); ?>
			</td>
			<td>
				<?= count($lecturerController->getAllCourseByLecturerPrevious($lecturer)); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
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
	<tbody><?php
	foreach ($studentController->getAll() as $student): ?>
		<tr>
			<td>
				<?= $student->getName(); ?>
			</td>
			<td>
				<?= $student->getSurname(); ?>
			</td>
			<td>
				<?= $student->getBirthday(); ?>
			</td>
			<td>
				<?= $studentController->getWorkload($student); ?>
			</td>
			<td>
				<?= $studentController->getGpa($student); ?>
			</td>
			<td>
				<?= $studentController->getStatus($student); ?>
			</td>
			<td>
				<?= count($studentController->getAllRegisteredCourse($student)); ?>
			</td>
			<td>
				<?= count($studentController->getAllCompletedCourse($student)); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

