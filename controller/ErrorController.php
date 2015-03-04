<?php

/**
 * Class ErrorController
 */
class ErrorController {
	/**
	 * @var ErrorRepositoryInterface
	 */
	private $errorRepository;

	/**
	 * @param ErrorRepositoryInterface $errorRepository
	 */
	function __construct(ErrorRepositoryInterface $errorRepository)
	{
		$this->errorRepository = $errorRepository;
	}

	/**
	 * @param $errormessage
	 * @return mixed
	 */
	function create($errormessage){
		return $this->errorRepository->create($errormessage);
	}
} 