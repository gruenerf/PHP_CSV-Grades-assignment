<?php

require_once('config.php');

foreach (glob("data/*.txt") as $filename)
{
	unlink($filename);
}

session_unset();

$c1 = $courseController->create('AI', '10', '1', new DateTime('2014-10-01'));
$c2 = $courseController->create('Norsk', '5', '2', new DateTime('2016-10-01'));
$c3 = $courseController->create('Mobile App Design', '5', '1', new DateTime('2014-10-01'));
$c4 = $courseController->create('Programming for the Web', '10', '2', new DateTime('2015-10-01'));
$c5 = $courseController->create('Programming for the Web II', '10', '1', new DateTime('2014-10-01'));
$c6 = $courseController->create('Programming for the Web II', '10', '2', new DateTime('2013-10-01'));
$c7 = $courseController->create('Programming for the Web II', '10', '1', new DateTime('2015-10-01'));
$c8 = $courseController->create('Programming for the Web II', '10', '2', new DateTime('2015-10-01'));

$s1 = $studentController->create('Ferdinand', 'Gr&uuml;ner', '21.11.1989');
$s2 = $studentController->create('Tom', 'Rogers', '21.01.1992');
$s3 = $studentController->create('Sascha', 'Jenner', '05.05.1990');
$s4 = $studentController->create('Patrick', 'Heller', '05.07.1987');
$s5 = $studentController->create('Martina', 'Kaiser', '01.04.1991');

$studentController->addCourse($s2,$c1);
$studentController->addCourse($s2,$c2);
$studentController->addCourse($s2,$c3);
$studentController->addCourse($s2,$c4);
$studentController->addCourse($s2,$c5);
$studentController->addCourse($s2,$c8);

$studentController->addCourse($s1,$c1);
$studentController->addCourse($s1,$c4);
$studentController->addCourse($s1,$c7);
$studentController->addCourse($s1,$c1);

$studentController->addCourse($s3,$c1);
$studentController->addCourse($s3,$c8);
$studentController->addCourse($s3,$c5);

$studentController->addCourse($s4,$c3);
$studentController->addCourse($s4,$c4);
$studentController->addCourse($s4,$c5);
$studentController->addCourse($s4,$c6);

$studentController->addCourse($s5,$c3);
$studentController->addCourse($s5,$c8);
$studentController->addCourse($s5,$c7);
$studentController->addCourse($s5,$c1);

$g1 = $gradeController->create($s1->getId(),$c2->getId(),'A', new DateTime('2015-03-08'));
$g2 = $gradeController->create($s2->getId(),$c2->getId(),'E', new DateTime('2015-08-11'));
$g3 = $gradeController->create($s3->getId(),$c3->getId(),'C', new DateTime('2015-05-01'));
$g4 = $gradeController->create($s4->getId(),$c4->getId(),'B', new DateTime('2015-03-01'));
$g5 = $gradeController->create($s5->getId(),$c5->getId(),'D', new DateTime('2015-12-05'));
$g6 = $gradeController->create($s1->getId(),$c1->getId(),'D', new DateTime('2015-03-01'));
$g7 = $gradeController->create($s2->getId(),$c2->getId(),'A', new DateTime('2015-03-01'));
$g8 = $gradeController->create($s3->getId(),$c4->getId(),'B', new DateTime('2015-08-05'));
$g9 = $gradeController->create($s4->getId(),$c5->getId(),'A', new DateTime('2015-03-01'));
$g10 = $gradeController->create($s5->getId(),$c2->getId(),'C', new DateTime('2015-05-01'));

$l1 = $lecturerController->create('Dr.','Eric','Cartman','20.03.1965');
$l2 = $lecturerController->create('Prof.','Kenny','McCormick','20.03.1935');
$l3 = $lecturerController->create('Dr.','Finn','The Human','20.01.1985');
$l4 = $lecturerController->create('Dr.','Jake','The Dog','27.01.1976');
$l5 = $lecturerController->create('Dr.','Spongebob','Squarepants','20.03.1965');

$c2->setEcts('8');
$s1->setName('Coolio');
$g1->setCourseId($c3->getId());
$l1->setName('FooBar');

$courseController->update($c2);
$studentController->update($s1);
$gradeController->update($g1);
$lecturerController->update($l1);

$lecturerController->addCourse($l1,$c1);
$lecturerController->addCourse($l1,$c2);
$lecturerController->addCourse($l1,$c3);
$lecturerController->addCourse($l1,$c4);
$lecturerController->addCourse($l1,$c5);
$lecturerController->addCourse($l1,$c6);
$lecturerController->addCourse($l1,$c7);
$lecturerController->addCourse($l1,$c8);

$lecturerController->addCourse($l2,$c8);

$lecturerController->addCourse($l3,$c5);
$lecturerController->addCourse($l3,$c6);
$lecturerController->addCourse($l3,$c3);
$lecturerController->addCourse($l3,$c8);
$lecturerController->addCourse($l3,$c1);
$lecturerController->addCourse($l3,$c2);

$lecturerController->addCourse($l4,$c3);
$lecturerController->addCourse($l4,$c8);

$lecturerController->addCourse($l5,$c5);
$lecturerController->addCourse($l5,$c6);
$lecturerController->addCourse($l5,$c3);
$lecturerController->addCourse($l5,$c8);




