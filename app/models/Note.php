<?php

class Note extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'notes';

	/**
	 * Save note into db
	 * @param int $jobId
	 * @return response
	 */
	public static function saveNote($jobId, $note) {

		DB::table('notes')->insert([
			'user_id' => Auth::user()->id,
			'job_id' => $jobId,
			'note' => $note,
			'created_at' => date('Y-m-d h:i:s', time()),	
			'updated_at' => date('Y-m-d h:i:s', time())	
		]);

	}

}