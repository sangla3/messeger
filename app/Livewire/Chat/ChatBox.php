<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Notifications\MessageRead;
use App\Notifications\MessageSent;
use Livewire\Component;

class ChatBox extends Component
{
    public $selectedConversation;
    public $body;
    public $loadedMessages;

    public function getListeners()
    {

        $auth_id = auth()->user()->id;

        return [
            "echo-private:users.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'broadcastedNotifications'
        ];
    }

    public function broadcastedNotifications($event)
    {

        if ($event['type'] == MessageSent::class) {

            if ($event['conversation_id'] == $this->selectedConversation->id) {

                $this->dispatch('scroll-bottom');

                $newMessage = Message::find($event['message_id']);


                # Gửi
                $this->loadedMessages->push($newMessage);


                # Đánh dấu đã đọc
                $newMessage->read_at = now();
                $newMessage->save();

                # broadcast 
                $this->selectedConversation->getReceiver()
                    ->notify(new MessageRead($this->selectedConversation->id));
            }
        }
    }

    public function loadMessages()
    {
        $this->loadedMessages = Message::where('conversation_id', $this->selectedConversation->id)->get();
    }

    public function sendMessage()
    {

        $this->validate(['body' => 'required|string']);


        $createdMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedConversation->getReceiver()->id,
            'body' => $this->body

        ]);


        $this->reset('body');

        # Cuộn xuống tin nhắn vừa gửi
        $this->dispatch('scroll-bottom');

        # Gửi
        $this->loadedMessages->push($createdMessage);

        # Cập nhật cuộc đối thoại, làm lên đầu danh sách chat
        $this->selectedConversation->updated_at = now();
        $this->selectedConversation->save();

        # Load lại danh sách chat
        $this->dispatch('refresh')->to('chat.chat-list');

        #broadcast
        $this->selectedConversation->getReceiver()
        ->notify(new MessageSent(
            Auth()->User(),
            $createdMessage,
            $this->selectedConversation,
            $this->selectedConversation->getReceiver()->id

        ));

        // dd($this->body);
    }

    public function mount()
    {

        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
