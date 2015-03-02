<?php

define('ROOT_PATH', realpath(__DIR__));

foreach (glob(ROOT_PATH."/controller/*.php") as $filename) {
	include $filename;
}

foreach (glob(ROOT_PATH."/model/*.php") as $filename) {
	include $filename;
}

$gradeController = new GradeController();
$courseController = new CourseController();
$lecturerController = new LecturerController();
$studentController = new StudentController();

?>