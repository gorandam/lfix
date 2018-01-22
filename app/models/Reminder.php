<?php

class Reminder extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'reminders';

	protected $fillable = ['by_user','to_user','reminder'];

	/**
	 * Set reminder
	 * @return response
	 */
	public static function setReminder($byUser, $toUser, $reminder) {
		
		// echo $byUser . '/' . $toUser . '/' . $reminder; exit;
		/*$reminder = new Reminder;
		$reminder->by_user  = (int)$byUser;
		$reminder->to_user  = (int)$toUser;
		$reminder->reminder = $reminder;
		$reminder->save();*/

		// Save without Eloquent for now, throwing an error
		DB::table('reminders')->insert([
			'by_user' => $byUser,
			'to_user' => $toUser,
			'reminder' => $reminder,
			'created_at' => date('Y-m-d h:i:s', time()),	
			'updated_at' => date('Y-m-d h:i:s', time())	
		]);

	}

}