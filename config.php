<?php

session_start();

// set session variables
$_SESSION['course_id'];
$_SESSION['grade_id'];
$_SESSION['error_id'];
$_SESSION['student_id'];
$_SESSION['lecturer_id'];



define('ROOT_PATH', realpath(__DIR__));

foreach (glob(ROOT_PATH . "/controller/*.php") as $filename) {
	require_once($filename);
}

$modelInterfaceDir = ROOT_PATH . "/model/interface/ModelInterface.php";
$repositoryInterfaceDir = ROOT_PATH . "/model/interface/RepositoryInterface.php";

require_once($modelInterfaceDir);
require_once($repositoryInterfaceDir);

foreach (glob(ROOT_PATH . "/model/interface/*.php") as $filename) {
	if ($filename == $modelInterfaceDir | $filename == $repositoryInterfaceDir) {
		continue;
	}
	require_once($filename);
}

foreach (glob(ROOT_PATH . "/model/*.php") as $filename) {
	require_once($filename);
}

$errorController = new ErrorController(ErrorRepository::getInstance());
$gradeController = new GradeController(GradeRepository::getInstance());
$courseController = new CourseController(CourseRepository::getInstance());
$lecturerController = new LecturerController(LecturerRepository::getInstance());
$studentController = new StudentController(StudentRepository::getInstance());