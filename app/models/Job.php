<?php

class Job extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'jobs';

	/**
	 * Get all data needed for creating a job 
	 * @return array
	 */
	public static function getData($isTechnician = false, $categoryName = NULL) 
	{

		if($categoryName) {
			$categoryName = ucfirst($categoryName);
		}

		$locations = Location::all();

		$cities = [];

		foreach ($locations as $location) {
			$cities[$location->location] = $location->location;
		}

		$categories = Category::all();

		$names = [];

		foreach ($categories as $category) {
			$names[$category->name] = $category->name;
		}

		$priorities = Priority::all();

		$priors = [];

		foreach ($priorities as $priority) {
			$priors[$priority->priority] = $priority->priority;
		}

		if($categoryName) {
			if($isTechnician) {
				$jobs = static::where('assigned_to', '=', Auth::user()->id)->where('category', '=', $categoryName)->where('status', '!=', 'archived')->orderBy('id', 'DESC')->paginate(8);
			} else {
				$jobs = static::where('category', '=', $categoryName)->where('status', '!=', 'archived')->orderBy('id', 'DESC')->paginate(8);
			}
		} else {
			if($isTechnician) {
				$jobs = static::where('assigned_to', '=', Auth::user()->id)->where('status', '!=', 'archived')->orderBy('id', 'DESC')->paginate(8);
			} else {
				$jobs = static::where('status', '!=', 'archived')->orderBy('id', 'DESC')->paginate(8);
			}
		}

		return [ 'jobs' 	   => $jobs,
				 'technicians' => User::getTechnicians(),
				 'locations'   => $cities,
				 'categories'  => $names,
				 'priorities'  => $priors ];
	}
}