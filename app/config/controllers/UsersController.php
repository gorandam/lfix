<?php

class UsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function login()
	{
		if(Auth::check()) {
			return Redirect::to('jobs');
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
            return Redirect::to('jobs');
        }

        return Redirect::route('login')->withInput();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function logout()
	{
		if(Auth::check()){
		  Auth::logout();
		}
		return Redirect::route('login');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('users.create');
	}

	/**
	 * Store new users data.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Save new user
		$input = Input::all();

		$validator = Validator::make(
            $input,
            [
                'email' => 'required|email',
                'name' 	=> 'required',
                'password' => 'required|min:8',
            ]
        );

        if($validator->fails()){
            return Redirect::route('user.create')->withErrors($validator)->withInput();
        }

		
		$data = Input::only(['email', 'name']);
		$data['password'] = Hash::make(Input::get('password'));
		$data['group'] = 1; // Tehnician will be by default

        $newUser = new User;
        $newUser->email = $data['email'];
        $newUser->name = $data['name'];
        $newUser->password = $data['password'];
        $newUser->group = $data['group'];
        $newUser->save();

        if($newUser){
            Auth::login($newUser);
            return Redirect::to('jobs');
        }

        return Redirect::route('user.create')->withInput();
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
	}


}
