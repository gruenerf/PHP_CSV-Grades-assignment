<?php

use GradeModel as Grade;

class GradeController
{

	private $gradeRepository;

	public function __construct(GradeRepositoryInterface $gradeRepository)
	{
		$this->gradeRepository = $gradeRepository;
	}

	function newGrade($student, $course, $grade)
	{
		return $this->gradeRepository->create($student, $course, $grade);
	}

	function updateGrade(Grade $grade)
	{
		return $this->gradeRepository->update($grade);
	}

	function getAllGrade()
	{
		return $this->gradeRepository->getAll();
	}
} 