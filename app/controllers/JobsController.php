<?php

class JobsController extends \BaseController {

	public $user;

	public $data;

	public function __construct() {

		try {
			
			$this->beforeFilter('auth');
			$this->beforeFilter('csrf', array('on' => 'post'));
			$this->user = Auth::user();
			$usersList = User::get()->toArray();
			$this->data['usersForReminder'] = [];
			foreach ($usersList as $user) {
				$this->data['usersForReminder'][$user['id']] = $user['name'];
			}
			$this->data['remindersInfo'] = Reminder::where('to_user', '=', $this->user->id)->where('dismissed', '=', 0)->get();

		} catch (Exception $e) {
			return Redirect::to('login');
		}

	}

	/**
	 * Display a listing of the jobs.
	 *
	 * @return Response
	 */
	public function index($category = NULL)
	{
		//
		$jobsItems = Job::getData($this->user->isTechnician(), $category);
		foreach ($jobsItems as $key => $value) {
			$this->data[$key] = $value;
		}
		// dd($this->data);
		return View::make('jobs.index', $this->data);
	}

	/**
	 * Display a listing of the jobs.
	 *
	 * @return Response
	 */
	public function byCategory($category = NULL)
	{
		//
		$jobsItems = Job::getData($this->user->isTechnician(), $category);
		foreach ($jobsItems as $key => $value) {
			$this->data[$key] = $value;
		}
		
		return View::make('jobs.index', $this->data);
	}


	/**
	 * Store a newly created job in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$input = Input::all();
		
		$validator = Validator::make(
            $input,
            [
                'title' 		=> 'required|min:5',
                'description' 	=> 'required',
                'category' 		=> 'required',
                'assigned_to' 	=> 'required',
                'location' 		=> 'required',
                'start' 		=> 'required',
                'address' 		=> 'required',
                'priority'		=> 'required'
            ]
        );

        if($validator->fails()){
            return Redirect::to('jobs')->withErrors($validator)->withInput();
        }

        $newJob = new Job;
        $newJob->title = $input['title'];
        $newJob->description = $input['description'];
        $newJob->category = $input['category'];
        $newJob->assigned_to = (int)$input['assigned_to'];
        $newJob->location = $input['location'];
        $newJob->start    = $input['start'];
        $newJob->address  = $input['address'];
        $newJob->priority = $input['priority'];
        $newJob->save();

        if($newJob){
        	Log::info('New job "' . $newJob->title . '" created by ' . Auth::user()->email, array('context' => 'jobs'));
            return Redirect::to('jobs');
        }

        return Redirect::to('jobs')->withInput();
	}


	/**
	 * Display the specified job.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		$this->data['job'] = Job::find($id);

		$this->data['notes'] = Note::where('job_id', '=', $id)->get();

		$this->data['jsonData'] = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins=Toronto+LongsdaleRd12&destinations=Toronto+AvenueRd16&key=AIzaSyDn8mXHUr5_lAhwchMYT9aJdqy2xeAvlqQ'));

		if($this->user->isTechnician() && !($job->assigned_to == $this->user->id)) {
			return 'You can\'t access the job that is not assigned to you. <a href="' . URL::previous() . '">Go back.</a>';
		}

		return View::make('jobs.show', $this->data);
	}


	/**
	 * Show the form for editing the specified job.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$this->data['additionalData'] = Job::getData();
		$this->data['job'] = Job::find($id);

		if($this->user->isTechnician()) {
			return 'You can\'t edit the jobs. <a href="' . URL::previous() . '">Go back.</a>';
		}

		return View::make('jobs.edit', $this->data);
	}


	/**
	 * Update the specified job in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$input = Input::all();

		$validator = Validator::make(
            $input,
            [
                'title' 		=> 'required|min:5',
                'description' 	=> 'required',
                'category' 		=> 'required',
                'assigned_to' 	=> 'required',
                'location' 		=> 'required',
                'start' 		=> 'required',
                'address' 		=> 'required',
                'priority'		=> 'required'
            ]
        );

        if($validator->fails()){
            return Redirect::route('jobs')->withErrors($validator)->withInput();
        }

        $updateJob 				= Job::find($id);
        $updateJob->title 		= $input['title'];
        $updateJob->description = $input['description'];
        $updateJob->category	= $input['category'];
        $updateJob->assigned_to = $input['assigned_to'];
        $updateJob->location 	= $input['location'];
        $updateJob->start 	    = $input['start'];
        $updateJob->address 	= $input['address'];
        $updateJob->priority 	= $input['priority'];
        $updateJob->save();

        Log::info('Job "' . $updateJob->title . '" updated by ' . Auth::user()->email, array('context' => 'jobs'));
        return Redirect::to('jobs');
	}


	/**
	 * Remove the specified job from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$job = Job::find($id);

		if(!$this->user->isSuperAdmin()) {
			return 'Only Super Admin can delete the jobs. <a href="' . URL::previous() . '">Go back.</a>';
		}

		Log::info('Job "' . $job->title . '" deleted by ' . $this->user->email, array('context' => 'jobs'));
		Job::find($id)->delete();
		return Redirect::to('jobs');

	}

	/*
 	 * -------------------------------------------------------------------
 	 * Note to myself: This stupid 3 methods solution has to be modified,
 	 * create one method for job status update
 	 * -------------------------------------------------------------------
	 */

	/**
	 * Archive the job
	 *
	 * @param  int  $id
	 * @return Laravel\Redirect
	 */
	public function archive($id)
	{
		$job = Job::find($id);

		if($this->user->isTechnician() && !($job->assigned_to == $this->user->id)) {
			return 'You can\'t update status of the job that is not assigned to you. <a href="' . URL::previous() . '">Go back.</a>';
		}

		Log::info('Job "' . $job->title . '" archived by ' . $this->user->email, array('context' => 'jobs'));
		$job->status = 'archived';
		$job->save();

		return Redirect::to('jobs');
		
	}

	/**
	 * Mark job as open
	 *
	 * @param  int  $id
	 * @return Laravel\Redirect
	 */
	public function open($id)
	{
		$job = Job::find($id);

		if($this->user->isTechnician() && !($job->assigned_to == $this->user->id)) {
			return 'You can\'t update status of the job that is not assigned to you. <a href="' . URL::previous() . '">Go back.</a>';
		}

		Log::info('Job "' . $job->title . '" opened by ' . $this->user->email, array('context' => 'jobs'));
		$job->status = 'open';
		$job->save();
		
		return Redirect::to('jobs');
		
	}

	/**
	 * Mark job as not paid
	 *
	 * @param  int  $id
	 * @return Laravel\Redirect
	 */
	public function notpaid($id)
	{
		$job = Job::find($id);

		if($this->user->isTechnician() && !($job->assigned_to == $this->user->id)) {
			return 'You can\'t update status of the job that is not assigned to you. <a href="' . URL::previous() . '">Go back.</a>';
		}

		Log::info('Job "' . $job->title . '" opened by ' . $this->user->email, array('context' => 'jobs'));
		$job->status = 'not paid';
		$job->save();
		
		return Redirect::to('jobs');
		
	}

	/**
	 * View archived jobs
	 * @return Laravel\View
	 */
	public function viewArchive() {
		if(!$this->user->isSuperAdmin()) {
			return 'Only Super Admin can view jobs archive. <a href="' . URL::previous() . '">Go back.</a>';
		}

		$jobs = Job::whereStatus('archived')->get();

		return View::make('jobs.archive', compact('jobs'));
	}

	/**
	 * Add note for the job
	 * @return Laravel\View
	 */
	public function note() {

		$input = Input::get();

		Note::saveNote($input['job'], $input['note']);

		return Redirect::to('jobs/' . $input['job']);
	}

}
