<?php

class Elgg_Site_ActivityController extends Elgg_DefaultController {
	public function __construct(Elgg_Session $session, Elgg_Request $request, Elgg_I18n_Translator $translator) {
		$this->session = $session;
		$this->request = $request;
		$this->translator = $translator;
	}
	
	public function get() {
		/**
		 * Main activity stream list page
		 */
		
		$options = array();
		
		$page_type = preg_replace('[\W]', '', $this->request->getInput('page_type', 'all'));
		$type = preg_replace('[\W]', '', $this->request->getInput('type', 'all'));
		$subtype = preg_replace('[\W]', '', $this->request->getInput('subtype', ''));
		
		if ($subtype) {
			$selector = "type=$type&subtype=$subtype";
		} else {
			$selector = "type=$type";
		}
		
		if ($type != 'all') {
			$options['type'] = $type;
			if ($subtype) {
				$options['subtype'] = $subtype;
			}
		}
		
		switch ($page_type) {
			case 'mine':
				$title = $this->translator->translate('river:mine');
				$page_filter = 'mine';
				$options['subject_guid'] = $this->session->getLoggedInUserGuid();
				break;
			case 'owner':
				$subject_username = $this->request->getInput('subject_username', '', false);
				$subject = get_user_by_username($subject_username);
				if (!$subject) {
					register_error($this->translator->translate('river:subject:invalid_subject'));
					forward('');
				}
				$title = $this->translator->translate('river:owner', array(htmlspecialchars($subject->name, ENT_QUOTES, 'UTF-8', false)));
				$page_filter = 'subject';
				$options['subject_guid'] = $subject->guid;
				break;
			case 'friends':
				$title = $this->translator->translate('river:friends');
				$page_filter = 'friends';
				$options['relationship_guid'] = $this->session->getLoggedInUserGuid();
				$options['relationship'] = 'friend';
				break;
			default:
				$title = $this->translator->translate('river:all');
				$page_filter = 'all';
				break;
		}

		$activity = elgg_get_river($options);

		return array(
			'title' => $title,
			'items' =>  $activity,
		);		
	}
	
	public static function create(Elgg_ServiceProvider $c) {
		return new Elgg_Site_ActivityController($c->session, $c->request, $c->translator);
	}
}