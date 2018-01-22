<?php

class UsersController extends BaseController {

	/*
	 * User Object
	 * @var
	 */
	private $user;

	public function __construct() {

		$this->beforeFilter('auth', array('except' => array('login', 'handleLogin')));
		$this->beforeFilter('super.admin', array('except' => array('login', 'handleLogin', 'logout')));
		$this->beforeFilter('csrf', array('on' => 'post'));
		$this->user = Auth::user();
		$usersList = User::get()->toArray();
		$this->data['usersForReminder'] = [];
		foreach ($usersList as $user) {
			$this->data['usersForReminder'][$user['id']] = $user['name'];
		}
		if($this->user) {
			$this->data['remindersInfo'] = Reminder::where('to_user', '=', $this->user->id)->where('dismissed', '=', 0)->get();
		}

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function login()
	{
		if(Auth::check()) {

			return Redirect::to('profiles');

		} else {

			return View::make('users.login');
			
		}

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function handleLogin()
	{
		// Login user
		$data = Input::only(['email', 'password']);
		$validator = Validator::make(
            $data,
            [
                'email' => 'required|email|min:8',
                'password' => 'required',
            ]
        );

        if($validator->fails()){
            return Redirect::route('login')->withErrors($validator)->withInput();
        }

        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
        	Log::info($data['email'] . ' successfully logged in', array('context' => 'login'));
            return Redirect::to('profiles');
        }

        Log::error($data['email'] . ' tried to login without success', array('context' => 'login'));
        return Redirect::route('login')->withInput()->withErrors('Wrong credentials');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function logout()
	{
		if(Auth::check()){
	      Log::info(Auth::user()->email . ' logged out', array('context' => 'logout'));
		  Auth::logout();
		}

		return Redirect::route('login');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function profiles()
	{

		if(!$this->user->isSuperAdmin()) {
			return 'You don\'t have permissions to access this page. <a href="' . URL::previous() . '">Go back</a>';
		}
		
		$this->data['users'] = User::orderBy('id', 'DESC')->paginate(8);
		// dd($users);
		$this->data['links'] = $this->data['users']->links(); 	
		$this->data['groups'] = User::getGroups();

		return View::make('users.profiles', $this->data);

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		return Redirect::route('login');

	}

	/**
	 * Store new users data.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Save new user
		// return false; // turning off for now
		$input = Input::all();

		$validator = Validator::make(
            $input,
            [
                'email' => 'required|email',
                'name' 	=> 'required',
                'password' => 'required|min:8',
                'group' => 'required'
            ]
        );

        if($validator->fails()){
            return Redirect::to('profiles')->withErrors($validator)->withInput();
        }

		
		$data = Input::only(['email', 'name', 'group']);
		$data['password'] = Hash::make(Input::get('password'));

        $newUser = new User;
        $newUser->email = $data['email'];
        $newUser->name = $data['name'];
        $newUser->password = $data['password'];
        $newUser->group = $data['group'];
        $newUser->save();

        if($newUser){
        	Log::info($newUser->email . ' created by ' . Auth::user()->email, array('context' => 'users'));
            return Redirect::to('profiles');
        }

        return Redirect::to('profiles')->withInput();
	}


	/**
	 * Display user profile.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// 
		$user = User::find($id);

		$this->data['id'] = $id;
		$this->data['name'] = $user->name;
		$this->data['email'] = $user->email;
		$this->data['group'] = $user->group;

		$this->data['groups'] = User::getGroups();

		return View::make('users.edit', $this->data);
	}


	/**
	 * Update the specified resource in storage.
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
                'email' => 'required|email',
                'name' 	=> 'required',
                'password' => 'min:8',
                'group' => 'required'
            ]
        );

        if($validator->fails()){
            return Redirect::route('profiles')->withErrors($validator)->withInput();
        }

		
		$data = Input::only(['email', 'name', 'group']);
		$data['password'] = Hash::make(Input::get('password'));

        $updateUser = User::find($id);
        $updateUser->email = $data['email'];
        $updateUser->name = $data['name'];
        $updateUser->password = $data['password'];
        $updateUser->group = $data['group'];
        $updateUser->save();

        Log::info($updateUser->email . ' updated by ' . Auth::user()->email, array('context' => 'users'));
        return Redirect::to('profiles');

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		Log::info(User::find($id)->email . ' deleted by ' . Auth::user()->email, array('context' => 'users'));
		User::find($id)->delete();
		return Redirect::to('profiles');
	}

	/**
	 * Set reminder for a user
	 * @return Response
	 */
	public function setReminder()
	{
		// Get input
		$input = Input::get();
		$byUser   = $this->user->id;
		$toUser   = $input['to_user'];
		$reminder = $input['reminder'];

		// Save reminder
		Reminder::setReminder($byUser, $toUser, $reminder);

		Session::flash('message', 'You successfully created a reminder');
		return Redirect::to('/');
	}

	/**
	 * Set reminder for a user
	 * @return Response
	 */
	public function dismissReminder($reminderId)
	{
		// Get input
		if($this->user->id != Reminder::find($reminderId)->to_user) {
			// Json error response
			return Response::json(array('Error' => 'Reminder is for another user'));
		}

		// Save reminder
		$reminder = Reminder::find($reminderId);
		$reminder->dismissed = 1;
		$reminder->save();


		// Json success response
		return Response::json(array('Success' => 'Successfully dismissed'));
	}

}
