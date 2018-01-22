<?php

class ChatRoom extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'chat_rooms';

	/**
	 * The fillable fields.
	 *
	 * @var array
	 */
	protected $fillable = array('name');

	/**
	 * chat room relation 
	 * @return mixed
	 */
	public function messages() {
		return $this->hasMany('Message', 'chat_room_id');
	}

	/**
	 * user relation 
	 * @return mixed
	 */
	public function user() {
		return $this->belongsTo('User', 'user_id');
	}
	
}