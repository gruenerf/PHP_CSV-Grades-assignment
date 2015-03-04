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
	<tbody>
	<?php foreach ($courseController->getCurrentCoursesGroupsAndPreviously() as $course): ?>
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
	</tbody>
</table>
