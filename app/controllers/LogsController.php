<?php

class LogsController extends \BaseController {

	public function __construct() {

		try {
			
			$this->beforeFilter('auth');
			$this->beforeFilter('super.admin');
			$this->beforeFilter('csrf', array('on' => 'post'));
			$usersList = User::get()->toArray();
			$this->data['usersForReminder'] = [];
			foreach ($usersList as $user) {
				$this->data['usersForReminder'][$user['id']] = $user['name'];
			}
			$this->data['remindersInfo'] = Reminder::where('to_user', '=', Auth::user()->id)->where('dismissed', '=', 0)->get();

		} catch (Exception $e) {
			return Redirect::to('login');
		}


	}

	/**
	 * Display a listing of the jobs.
	 *
	 * @return Response
	 */
	public function show($type = 'login')
	{
		//
		$this->data['logs'] = LogInfo::whereContext($type)
				->orderBy('id', 'desc')
				->paginate(10);
		$this->data['links'] = $this->data['logs']->links();		
		return View::make('logs.index', $this->data);
	}


}
