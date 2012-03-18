<?php
////////////////////////////////////////////////////////////////////////////
// SCHEDULEMAKER - Restful API Controller
//
// @file	controllers/APIController.php
// @descrip	This controller will be the entry point for pretty much every AJAX
//			type call that the site will issue. This also offers a nice entry
//			for anyone else to use. We just have to be careful as to how to
//			grant/deny access to the posting part of the API.
// @author	Benjamin Russell (benrr101@csh.rit.edu)
////////////////////////////////////////////////////////////////////////////

class APIController extends Controller {
	
	// METHODS /////////////////////////////////////////////////////////////

	public function index() {
		// @TODO: A descriptive page that explains how the API works
	}

	/**
	 * Retrieves the schools in the database. Returns them as a JSON array.
	 * @TODO: Handle being given a single school
	 */
	public function school() {
		// Create a model that will load up the schools
		$model = new CourseDBModel();
		$schools = $model->getSchools();
		if(!count($schools)) {
			// @TODO: Error ajax view
		}

		// Create a view for the schools
		$view = new SetAjaxView($schools);
		$view->render();
	}

	/**
	 * Retrieves the departments of a particular school.
	 * @TODO: Handle being given a single department and 'all'
	 */
	public function department() {
		// Access the URI to figure out which one needs to be gotten
		$urlSplit = explode('/', $this->getURI());
		if(empty($urlSplit[2])) {
			// Include an error View
			// @TODO: error 
		}
		$school = $urlSplit[2];

		// Create a model that will load up the departments in the school
		$model = new CourseDBModel();
		$departments = $model->getDepartments($school);
		if(!count($departments)) {
			// @TODO: Error ajax view
		}

		// Create a view for the departments to return them
		$view = new SetAjaxView($departments);
		$view->render();
	}

	public function course() {
		// Access the URI to figure out which course(s) to get
		//       0     1      2        3          4
		// URL: API/course/quarter/department/(all|couse_num)
		$urlSplit = explode('/', $this->getURI());
		if(empty($urlSplit[2])) {
			//@TODO: Error ajax: No quarter specified
		} elseif(empty($urlSplit[3])) {
			// @TODO: Error ajax: No department specified
		} elseif(empty($urlSplit[4])) {
			// @TODO: Error ajax: No course number
		}
		$quarter = $urlSplit[2];
		$depart  = $urlSplit[3];
		$course  = $urlSplit[4];
		
		// Create a model to access the desired courses
		$model = new CourseDBModel();
		$courses = $model->getCourses($quarter, $depart, $course);
		if(!count($courses)) {
			// @TODO: Error ajax
		}

		// Create a view for outputting the courses
		$view = new SetAjaxView($courses);
		$view->render();
	}
}
