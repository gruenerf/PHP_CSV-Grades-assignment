<?php

/**
 * Controller Class for Routing
 *
 * Class RouteController
 */
class RouteController
{


	private $page_title, $view;

	/**
	 * Getter/setter
	 */

	public function getPageTitle()
	{
		return $this->page_title;
	}

	/**
	 * @param $page_title
	 */
	public function setPageTitle($page_title)
	{
		$this->page_title = $page_title;
	}

	/**
	 * @return mixed
	 */
	public function getView()
	{
		return $this->view;
	}

	/**
	 * @param $view
	 */
	public function setView($view)
	{
		$this->view = $view;
	}

	public function __construct()
	{
		if (isset($_GET['route']) && !empty($_GET['route'])) {
			$route = $_GET['route'];
		} else {
			$route = "list_courses";
		}

		// Possible data for routing
		$possibleRoutes = array(
			'list_courses',
			'list_grades',
			'list_people',
			'upload_grades'
		);

		// check if the parameter is a valid route
		if(!in_array($route, $possibleRoutes)){
			$route = "list_courses";
		}

		// holds all views and pagetitles
		$parameters = array(
			'page_title' => array(
				'list_courses' => 'Course List',
				'list_grades' => 'Grade List',
				'list_people' => 'People List',
				'upload_grades' => 'Upload Grades'
			), 'view_title' => array(
				'list_courses' => 'list_courses',
				'list_grades' => 'list_grades',
				'list_people' => 'list_people',
				'upload_grades' => 'upload_grades'
			));


		$this->setPageTitle($parameters['page_title'][$route]);
		$this->setView($parameters['view_title'][$route]);
	}
} 