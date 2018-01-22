<?php

class Message extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'messages';

	/**
	 * The fillable fields.
	 *
	 * @var array
	 */
	protected $fillable = array('body');

	/**
	 * chat room relation 
	 * @return mixed
	 */
	public function chatRoom() {
		return $this->belongsTo('ChatRoom', 'chat_room_id');
	}

	/**
	 * user relation 
	 * @return mixed
	 */
	public function user() {
		return $this->belongsTo('User', 'user_id');
	}
	
}