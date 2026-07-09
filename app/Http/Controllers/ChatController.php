<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function inbox()
    {
        $userId = Auth::id();

        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($msg) use ($userId) {
                return $msg->sender_id === $userId ? $msg->receiver_id : $msg->sender_id;
            })
            ->map(function ($msgs, $otherUserId) {
                $latest = $msgs->first();
                $otherUser = $latest->sender_id === Auth::id() ? $latest->receiver : $latest->sender;
                $unread = $msgs->where('receiver_id', Auth::id())->whereNull('read_at')->count();
                return (object) [
                    'user' => $otherUser,
                    'last_message' => $latest->body,
                    'last_time' => $latest->created_at,
                    'unread' => $unread,
                ];
            })
            ->sortByDesc('last_time');

        return view('chat.inbox', compact('conversations'));
    }

    public function conversation(User $user)
    {
        $userId = Auth::id();

        if ($userId === $user->id) {
            return redirect()->route('chat.inbox');
        }

        Message::where('sender_id', $user->id)
            ->where('receiver_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = Message::where(function ($q) use ($userId, $user) {
            $q->where('sender_id', $userId)->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($userId, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $userId);
        })->with(['sender', 'receiver'])->orderBy('created_at', 'asc')->get();

        return view('chat.conversation', compact('messages', 'user'));
    }

    public function send(Request $request, User $user)
    {
        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $body = $request->body;

        if ($this->containsContactInfo($body)) {
            return back()->with('error', __('messages.chat_no_contact'));
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'body' => $body,
        ]);

        return redirect()->route('chat.conversation', $user->id);
    }

    private function containsContactInfo(string $text): bool
    {
        // Phone numbers: Egyptian / international formats
        $phonePattern = '/(?:\+?\d{1,3}[-.\s]?)?\(?\d{2,4}\)?[-.\s]?\d{3,4}[-.\s]?\d{3,4}/';

        // Email addresses
        $emailPattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/';

        return preg_match($phonePattern, $text) || preg_match($emailPattern, $text);
    }

    public function unreadCount()
    {
        $count = Message::where('receiver_id', Auth::id())->whereNull('read_at')->count();
        return response()->json(['count' => $count]);
    }
}
