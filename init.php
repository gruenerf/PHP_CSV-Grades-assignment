<?php
/**
 * Created by PhpStorm.
 * User: suenos
 * Date: 10/02/15
 * Time: 13:47
 */

include('config.php');

foreach (glob("data/*.txt") as $filename)
{
	unlink($filename);
}

$c1 = new Course("Web",10,"none");
$c2 = new Course("AI",10,"2");
$c3 = new Course("Norsk",5,"none");
$c4 = new Course("MobileMedia",5,"none");

$course = CourseModel::getCourseById(2);
print_r($course);
$course->setName("blaaa");
CourseModel::updateCourse($course);

//$array = CourseModel::getAllCourse();