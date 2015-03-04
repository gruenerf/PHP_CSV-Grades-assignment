<?php

use GradeModel as Grade;

class GradeController
{
	private $gradeRepository;

	public function __construct(GradeRepositoryInterface $gradeRepository)
	{
		$this->gradeRepository = $gradeRepository;
	}

	function create($student, $course, $grade, DateTime $date)
	{
		return $this->gradeRepository->create($student, $course, $grade, $date);
	}

	function update(Grade $grade)
	{
		return $this->gradeRepository->update($grade);
	}

	function getById($id)
	{
		return $this->gradeRepository->getById($id);
	}

	function getAll()
	{
		return $this->gradeRepository->getAll();
	}

	function getAllSorted($attr = null, $dir = null)
	{
		return $this->gradeRepository->getAllSorted($attr, $dir);
	}

	function uploadGrades(array $csvArray){
		return $this->gradeRepository->uploadGrades($csvArray);
	}
} 