<?php

class GradeController {

	private $gradeRepository;

	public function __construct(GradeModelInterface $gradeRepository){
		$this->gradeRepository = $gradeRepository;
	}

	function newGrade($student, $course, $grade){
		return new GradeModel($student, $course, $grade);
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