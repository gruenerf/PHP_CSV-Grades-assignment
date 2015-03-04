<?php

interface GradeRepositoryInterface extends RepositoryInterface
{
	public function create($studentId, $courseId, $grade, DateTime $date);

	public function getAllSorted($attr, $dir);

	public function uploadGrades(array $csvArray);
}