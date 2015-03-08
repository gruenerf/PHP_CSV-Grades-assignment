<?php

/**
 * Interface RepositoryInterface
 */
interface RepositoryInterface
{
	/**
	 * Updates a certain object in the database
	 * @param $o
	 */
	public function update($o);

	/**
	 * Returns Object with certain id
	 * @param $id
	 * @return mixed
	 */
	public function getById($id);

	/**
	 * Returns all objects of a class
	 * @return mixed
	 */
	public function getAll();

	/**
	 * Transforms Grad(A-F) into int
	 * @param $grade
	 * @return mixed
	 */
	public function transformGradeToInt($grade);

	/**
	 * Returns highest id in csv
	 * @return mixed
	 */
	public function getHighestId();
} 