<?php

include('config.php');

foreach (glob("data/*.txt") as $filename)
{
	unlink($filename);
}

$c1 = $courseController->newCourse('AI', '10', 'A', new DateTime('2014-10-01'));
$c2 = $courseController->newCourse('Norsk', '5', 'none', new DateTime('2016-10-01'));
$c3 = $courseController->newCourse('Mobile App Design', '5', 'none', new DateTime('2014-10-01'));
$c4 = $courseController->newCourse('Programming for the Web', '10', 'none', new DateTime('2015-10-01'));
$c5 = $courseController->newCourse('Programming for the Web II', '10', 'A', new DateTime('2014-10-01'));
$c5 = $courseController->newCourse('Programming for the Web II', '10', 'B', new DateTime('2013-10-01'));

$s1 = $studentController->newStudent('Ferdinand', 'Grüner', '21.11.1989');
$s2 = $studentController->newStudent('Tom', 'Rogers', '21.01.1992');
$s3 = $studentController->newStudent('Sascha', 'Jenner', '05.05.1990');
$s4 = $studentController->newStudent('Patrick', 'Heller', '05.07.1987');
$s5 = $studentController->newStudent('Martina', 'Kaiser', '01.04.1991');

$g1 = $gradeController->newGrade($s1->getId(),$c2->getId(),'A');
$g2 = $gradeController->newGrade($s2->getId(),$c1->getId(),'B');
$g3 = $gradeController->newGrade($s3->getId(),$c3->getId(),'C');
$g4 = $gradeController->newGrade($s4->getId(),$c4->getId(),'B');
$g5 = $gradeController->newGrade($s5->getId(),$c5->getId(),'D');
$g6 = $gradeController->newGrade($s1->getId(),$c1->getId(),'D');
$g7 = $gradeController->newGrade($s2->getId(),$c3->getId(),'C');
$g8 = $gradeController->newGrade($s3->getId(),$c4->getId(),'B');
$g9 = $gradeController->newGrade($s4->getId(),$c5->getId(),'A');
$g10 = $gradeController->newGrade($s5->getId(),$c2->getId(),'C');

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
$lecturerController->addCurrentCourse($l1,$c1);
$lecturerController->addPreviousCourse($l1,$c3);
$lecturerController->addPreviousCourse($l2,$c3);

$studentController->addRegisteredCourse($s2,$c4);
