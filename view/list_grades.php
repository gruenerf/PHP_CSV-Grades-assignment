<h2>Grades</h2>
<table>
	<thead>
	<tr>
		<td>CourseTitle<a href="?route=list_grades&attr=title&dir=asc"><img class="arrow"
		                                                                    src="<?php echo imgPath; ?>arrowup.png"></a><a
				href="?route=list_grades&attr=title&dir=desc"><img class="arrow"
		                                                           src="<?php echo imgPath; ?>arrowdown.png"></a> </input></a>
		</td>
		<td>Group<a href="?route=list_grades&attr=group&dir=asc"><img class="arrow"
		                                                              src="<?php echo imgPath; ?>arrowup.png"></a><a
				href="?route=list_grades&attr=group&dir=desc"><img class="arrow"
		                                                           src="<?php echo imgPath; ?>arrowdown.png"></a></a>
		</td>
		<td>Student Name<a href="?route=list_grades&attr=name&dir=asc"><img class="arrow"
		                                                                    src="<?php echo imgPath; ?>arrowup.png"></a><a
				href="?route=list_grades&attr=name&dir=desc"><img class="arrow"
		                                                          src="<?php echo imgPath; ?>arrowdown.png"></a></a>
		</td>
		<td>Student Surname<a href="?route=list_grades&attr=surname&dir=asc"><img class="arrow"
		                                                                          src="<?php echo imgPath; ?>arrowup.png"></a><a
				href="?route=list_grades&attr=surname&dir=desc"><img class="arrow"
		                                                             src="<?php echo imgPath; ?>arrowdown.png"></a></a>
		</td>
		<td>CourseSemester<a href="?route=list_grades&attr=semester&dir=asc"><img class="arrow"
		                                                                          src="<?php echo imgPath; ?>arrowup.png"></a><a
				href="?route=list_grades&attr=semester&dir=desc"><img class="arrow"
		                                                              src="<?php echo imgPath; ?>arrowdown.png"></a></a>
		</td>
		<td>ExamSemester<a href="?route=list_grades&attr=date&dir=asc"><img class="arrow"
		                                                                    src="<?php echo imgPath; ?>arrowup.png"></a><a
				href="?route=list_grades&attr=date&dir=desc"><img class="arrow"
		                                                          src="<?php echo imgPath; ?>arrowdown.png"></a></a>
		</td>
		<td>Grade<a href="?route=list_grades&attr=grade&dir=asc"><img class="arrow"
		                                                              src="<?php echo imgPath; ?>arrowup.png"></a><a
				href="?route=list_grades&attr=grade&dir=desc"><img class="arrow"
		                                                           src="<?php echo imgPath; ?>arrowdown.png"></a></a>
		</td>
	</tr>
	</thead>
	<tbody>
	<?php
	$attrdir = $validatorController->checkGradeSort();

	foreach ($gradeController->getAllSorted($attrdir[0], $attrdir[1]) as $grade): ?>
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
				<?= $grade['date']; ?>
			</td>
			<td>
				<?= $grade['grade']; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>