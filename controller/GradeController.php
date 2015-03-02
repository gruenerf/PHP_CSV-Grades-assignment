<?php

class GradeController {

	function newGrade($student, $course, $grade, $year){
		return new GradeModel($student, $course, $grade, $year);
	}

	function updateGrade($grade){
		if(get_class($grade) == 'GradeModel'){
			Database::getInstance()->update($grade);
		}
		else{
			new ErrorModel('Object not from type GradeModel');
		}
	}

	function getAllGrade(){
		return Database::getInstance()->getAll('GradeModel');
	}
} 