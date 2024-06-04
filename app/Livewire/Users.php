<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public function message($userId)
    {

      //  $createdConversation =   Conversation::updateOrCreate(['sender_id' => auth()->id(), 'receiver_id' => $userId]);

      $authenticatedUserId = auth()->id();

      # Kiểm tra xem cuộc trò chuyện đã tồn tại chưa
      $existingConversation = Conversation::where(function ($query) use ($authenticatedUserId, $userId) {
                $query->where('sender_id', $authenticatedUserId)
                    ->where('receiver_id', $userId);
                })
            ->orWhere(function ($query) use ($authenticatedUserId, $userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $authenticatedUserId);
            })->first();
        
      if ($existingConversation) {
          # Cuộc trò chuyện đã tồn tại, chuyển hướng đến cuộc trò chuyện hiện có
          return redirect()->route('chat', ['query' => $existingConversation->id]);
      }
  
      # Tạo cuộc trò chuyện mới
      $createdConversation = Conversation::create([
          'sender_id' => $authenticatedUserId,
          'receiver_id' => $userId,
      ]);
 
        return redirect()->route('chat', ['query' => $createdConversation->id]);
        
    }
    public function render()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('livewire.users', [
            'users' => $users
        ]);
    }
}
