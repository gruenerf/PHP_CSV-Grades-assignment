<?php

interface GradeRepositoryInterface extends RepositoryInterface
{
	public function create($studentId, $courseId, $grade);
}