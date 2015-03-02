<?php

include('config.php');

foreach (glob("data/*.txt") as $filename)
{
	unlink($filename);
}

$c1 = $courseController->newCourse('AI', '10', 'A', '6');
$c2 = $courseController->newCourse('Norsk', '5', 'none', '1');
$c3 = $courseController->newCourse('Mobile App Design', '5', 'none', '2');
$c4 = $courseController->newCourse('Programming for the Web', '10', 'none', '3');
$c5 = $courseController->newCourse('Programming for the Web II', '10', 'none', '4');

$s1 = $studentController->newStudent('Ferdinand', 'Grüner', '21.11.1989');
$s2 = $studentController->newStudent('Tom', 'Rogers', '21.01.1992');
$s3 = $studentController->newStudent('Sascha', 'Jenner', '05.05.1990');
$s4 = $studentController->newStudent('Patrick', 'Heller', '05.07.1987');
$s5 = $studentController->newStudent('Martina', 'Kaiser', '01.04.1991');

$g1 = $gradeController->newGrade($s1->getId(),$c2->getId(),'A','2014');
$g2 = $gradeController->newGrade($s2->getId(),$c1->getId(),'B','2014');
$g3 = $gradeController->newGrade($s3->getId(),$c3->getId(),'C','2014');
$g4 = $gradeController->newGrade($s4->getId(),$c4->getId(),'B','2014');
$g5 = $gradeController->newGrade($s5->getId(),$c5->getId(),'D','2014');
$g6 = $gradeController->newGrade($s1->getId(),$c1->getId(),'D','2014');
$g7 = $gradeController->newGrade($s2->getId(),$c3->getId(),'C','2014');
$g8 = $gradeController->newGrade($s3->getId(),$c4->getId(),'B','2014');
$g9 = $gradeController->newGrade($s4->getId(),$c5->getId(),'A','2014');
$g10 = $gradeController->newGrade($s5->getId(),$c2->getId(),'C','2014');

$l1 = $lecturerController->newLecturer('Dr.','Harald','Junke','20.03.1965');
$l2 = $lecturerController->newLecturer('Prof.','Kenny','McCormick','20.03.1935');
$l3 = $lecturerController->newLecturer('Dr.','Finn','The Human','20.01.1985');
$l4 = $lecturerController->newLecturer('Dr.','Jake','The Dog','27.01.1976');
$l5 = $lecturerController->newLecturer('Dr.','Spongebob','Squarepants','20.03.1965');


$c2->setEcts(8);
$s1->setName('Coolio');
$g1->setCourseId($c3->getId());
$l1->setName('FooBar');

$courseController->updateCourse($c2);
$studentController->updateStudent($s1);
$gradeController->updateGrade($g1);
$lecturerController->updateLecturer($l1);

$lecturerController->addCurrentCourse($l1,$c1);
$lecturerController->addPreviousCourse($l1,$c3);

var_dump($lecturerController->getAllCourseByLecturerCurrent($l1));
var_dump($lecturerController->getAllCourseByLecturerPrevious($l1));

$studentController->addRegisteredCourse($s2,$c4);

var_dump($studentController->getAllRegisteredCourse($s2));