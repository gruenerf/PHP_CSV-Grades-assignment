<?php

use GradeModel as Grade;

/**
 * Class GradeController
 */
class GradeController implements GradeControllerInterface
{
	/**
	 * @var GradeRepositoryInterface
	 */
	private $gradeRepository;

	/**
	 * @param GradeRepositoryInterface $gradeRepository
	 */
	public function __construct(GradeRepositoryInterface $gradeRepository)
	{
		$this->gradeRepository = $gradeRepository;
	}

	/**
	 * @param $student
	 * @param $course
	 * @param $grade
	 * @param DateTime $date
	 * @return mixed
	 */
	function create($student, $course, $grade, DateTime $date)
	{
		return $this->gradeRepository->create($student, $course, $grade, $date);
	}

	/**
	 * @param GradeModel $grade
	 * @return mixed
	 */
	function update(Grade $grade)
	{
		return $this->gradeRepository->update($grade);
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	function getById($id)
	{
		return $this->gradeRepository->getById($id);
	}

	/**
	 * @return mixed
	 */
	function getAll()
	{
		return $this->gradeRepository->getAll();
	}

	/**
	 * @param null $attr
	 * @param null $dir
	 * @return mixed
	 */
	function getAllSorted($attr = null, $dir = null)
	{
		return $this->gradeRepository->getAllSorted($attr, $dir);
	}

	/**
	 * @param array $csvArray
	 * @return mixed
	 */
	function uploadGrades(array $csvArray){
		return $this->gradeRepository->uploadGrades($csvArray);
	}
} 