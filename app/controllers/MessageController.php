<?php
class MessageController extends BaseController {

    /**
     * @param Message $messages
     */
    public function __construct(Message $messages)
    {
        $this->messages = $messages;
        $usersList = User::get()->toArray();
        $this->data['usersForReminder'] = [];
        foreach ($usersList as $user) {
            $this->data['usersForReminder'][$user['id']] = $user['name'];
        }
        $this->data['remindersInfo'] = Reminder::where('to_user', '=', Auth::user()->id)->where('dismissed', '=', 0)->get();
    }

    /**
     * @param ChatRoom $chatRoom
     * @return mixed
     */
    public function getByChatRoom($chatRoom = 1)
    {
        $this->data['chatRoom'] = ChatRoom::find($chatRoom);
        $this->data['messages'] = $this->data['chatRoom']->messages;
        return View::make('chat.messages', $this->data);
    }

    /**
     * @param ChatRoom $chatRoom
     * @return static
     */
    public function createInChatRoom($chatRoom = 1)
    {
        $data = Input::only(['message']);
        $validator = Validator::make(
            $data,
            [
                'message' => 'required',
            ]
        );

        if($validator->fails()){

            return Redirect::to('messages')->withErrors($validator)->withInput();
        }

        $chatRoom = ChatRoom::find($chatRoom);
        $message = new Message;
        $message->body = Input::get('message');
        $message->chatRoom()->associate($chatRoom);
        $message->user()->associate($this->me());
        $message->save();
        return Redirect::back();
    }

    /**
     * @param $lastMessageId
     * @param ChatRoom $chatRoom
     * @return mixed
     */
    public function getUpdates($lastMessageId, ChatRoom $chatRoom)
    {
        return $this->messages->byChatRoom($chatRoom)->afterId($lastMessageId)->get();
    }
    
}