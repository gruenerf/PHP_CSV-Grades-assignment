<?php

// Start Session
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

// Define Root Path
define('ROOT_PATH', realpath(__DIR__));

// Include all classes
foreach (glob(ROOT_PATH . "/controller/interface/*.php") as $filename) {
	require_once($filename);
}

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

//set Constants
define('stylePath' , 'assets/css/');
define('imgPath' , 'assets/img/');
define('fontsPath', 'assets/fonts/');
define('jsPath' , 'assets/js/');

// Initialize Controllers
$errorController = new ErrorController(ErrorRepository::getInstance());
$gradeController = new GradeController(GradeRepository::getInstance());
$courseController = new CourseController(CourseRepository::getInstance());
$lecturerController = new LecturerController(LecturerRepository::getInstance());
$studentController = new StudentController(StudentRepository::getInstance());
$validatorController = new ValidatorController($errorController , $gradeController);