<?php

interface GradeRepositoryInterface extends RepositoryInterface
{
	public function create($studentId, $courseId, $grade);

	public function getAllSorted($attr, $dir);
}