<?php

class Evan_Admin_Users_BrowseController extends Evan_DefaultController {
	function __construct(Evan_Session $session, Evan_UsersStore $users, Evan_Request $request) {
		$this->session = $session;
		$this->users = $users;
		$this->request = $request;
	}

	function get() {
		$this->session->assertAdminLoggedIn();
		
		$sorts = array(
			'registered' => array(
				'default' => 'time_created desc', // Most recently registered
				'reverse' => 'time_created asc', // Least recently registered
			),
			'activity' => array(
				'default' => 'last_action desc', // Most recently active
				'reverse' => 'last_action asc', // Least recently active
			)
		);

		$sort = $this->request->getInput('sort', array(
			'default' => 'registered',
			'options' => array_keys($sorts),
		));
		$reverse = $this->request->getInput('reverse', array(
			'type' => 'boolean',
			'default' => false,
		));
		$order_by = $sorts[$sort][$reverse ? 'reverse' : 'default'];

		$limit = $this->request->getInput('limit', array(
			'default' => 10,
			'type' => 'number',
			'max' => 100,
			'min' => 1,
		));
		$offset = $this->request->getInput('offset', array(
			'default' => 0,
			'type' => 'number',
			'min' => 0,
		));
		$q = $this->request->getInput('q');

		return $this->users->search($q)->orderBy($order_by)->limit($limit)->offset($offset);
	}

	static function create(Elgg_ServiceProvider $di) {
		return new Evan_Admin_Users_BrowseController($di->session, $di->users, $di->request);
	}

}
