<?php

interface ModelInterface{

	public function getId();
	public function setId($id);

	public function save();
	public function update();
	//Not implemented/necessary yet
	//public function delete();

	public function toArray();
}