<?php

/**
 * Interface ModelInterface
 */
interface ModelInterface{

	/**
	 * @return mixed
	 */
	public function getId();

	/**
	 * @param $id
	 * @return mixed
	 */
	public function setId($id);

	/**
	 * @return mixed
	 */
	public function save();

	/**
	 * @return mixed
	 */
	public function update();


	//Not implemented/necessary yet
	//public function delete();

	/**
	 * @return mixed
	 */
	public function toArray();
}