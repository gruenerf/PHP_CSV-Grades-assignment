<?php

class CourseController {

	function newCourse($name, $ects, $group, $semester){
		return new CourseModel($name, $ects, $group, $semester);
	}

	function updateCourse($course){
		if(get_class($course) == 'CourseModel'){
			Database::getInstance()->update($course);
		}
		else{
			new ErrorModel('Object not from type CourseModel');
		}
	}

	function getAllCourse(){
		return Database::getInstance()->getAll('CourseModel');
	}

	function getAllCourseByStudent($student){
		if(get_class($student) == 'StudentModel'){
			return Database::getInstance()->getAllBy($student, 'Course');
		}
		else{
			new ErrorModel('Object not from type StudentModel');
		}
	}

	function getAllCourseByLecturerPrevious($lecturer){
		if(get_class($lecturer) == 'LecturerModel'){
			return Database::getInstance()->getAllBy($lecturer, 'Course', 'previous');
		}
		else{
			new ErrorModel('Object not from type LecturerModel');
		}
	}

	function getAllCourseByLecturerCurrent($lecturer){
		if(get_class($lecturer) == 'LecturerModel'){
			return Database::getInstance()->getAllBy($lecturer, 'Course', 'current');
		}
		else{
			new ErrorModel('Object not from type LecturerModel');
		}
	}
} 