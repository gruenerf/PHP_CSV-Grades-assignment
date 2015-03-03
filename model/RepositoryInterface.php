<?php

interface RepositoryInterface
{
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
} 