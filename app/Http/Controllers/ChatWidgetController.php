<?php

namespace App\Http\Controllers;

use App\Models\DirectMessage;
use App\Models\User;
use App\Models\ClassPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatWidgetController extends Controller
{
    /**
     * Search users (teachers and students) to start a chat.
     */
    public function search(Request $request)
    {
        $q = $request->query('q');
        if (!$q || strlen($q) < 2) {
            return response()->json(['users' => []]);
        }

        $users = User::where('name', 'like', "%{$q}%")
            ->orWhere('email', 'like', "%{$q}%")
            ->select('id', 'name', 'email', 'role')
            ->limit(10)
            ->get()
            ->map(fn($u) => [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'type' => 'user',
                'role' => $u->role
            ]);

        return response()->json(['users' => $users]);
    }

    /**
     * Fetch conversations list for the current user.
     * Includes 1-on-1 chats and Class Period groups.
     */
    public function conversations()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['conversations' => []]);
        }

        $conversations = [];

        // 1. Admin Support Conversation (always available for non-admins)
        if (!$user->isAdmin()) {
            $adminUnread = DirectMessage::where('receiver_id', $user->id)
                ->where('sender_id', User::where('role', 'admin')->first()->id ?? 0) // if admin replies explicitly
                ->whereNull('read_at')
                ->count();
                
            // Or replies where receiver_id is null and it's handled as admin support
            $adminSupportUnread = DirectMessage::where('receiver_id', $user->id)
                ->whereNull('read_at')
                ->count();

            $conversations[] = [
                'id' => 'admin',
                'type' => 'admin',
                'name' => 'Target Bahasa Support',
                'email' => 'Official Admin',
                'unread' => $adminSupportUnread,
                'last_at' => now(), // simplify sorting
            ];
        }

        // 2. Class Period Groups
        $classes = [];
        if ($user->isStudent()) {
            $classes = $user->enrollments()->with('classPeriod')->get()->pluck('classPeriod')->filter();
        } elseif ($user->isTeacher()) {
            $classes = ClassPeriod::where('teacher_id', $user->id)->get();
        }

        foreach ($classes as $cls) {
            // Count unread group messages
            // (Simplification: just count messages in group since user last read? Hard to track per user.
            // For now, we return 0 for group unread to keep it simple, or check a pivot table if we had one).
            $conversations[] = [
                'id' => $cls->id,
                'type' => 'group',
                'name' => $cls->name . ' (' . $cls->batch_type . ')',
                'email' => 'Group Chat',
                'unread' => 0,
                'last_at' => now(),
            ];
        }

        // 3. 1-on-1 Conversations
        // Get users we have chatted with
        $userIds = DirectMessage::where('sender_id', $user->id)->whereNotNull('receiver_id')->pluck('receiver_id')
            ->merge(DirectMessage::where('receiver_id', $user->id)->pluck('sender_id'))
            ->unique()
            ->filter(fn($id) => $id !== $user->id);

        $chatUsers = User::whereIn('id', $userIds)->get();

        foreach ($chatUsers as $cu) {
            $unread = DirectMessage::where('sender_id', $cu->id)
                ->where('receiver_id', $user->id)
                ->whereNull('read_at')
                ->count();

            $conversations[] = [
                'id' => $cu->id,
                'user_id' => $cu->id,
                'type' => 'user',
                'name' => $cu->name,
                'email' => $cu->email,
                'unread' => $unread,
                'last_at' => now(), // Can be improved by getting actual max(created_at)
            ];
        }

        // Admin sees all open admin tickets (receiver_id null)
        if ($user->isAdmin()) {
            $tickets = DirectMessage::with('sender:id,name,email')
                ->whereNull('receiver_id')
                ->whereHas('sender')
                ->selectRaw('sender_id, MAX(created_at) as last_at, SUM(CASE WHEN read_at IS NULL THEN 1 ELSE 0 END) as unread')
                ->groupBy('sender_id')
                ->get();
            
            foreach ($tickets as $t) {
                // Check if already in array
                if (!collect($conversations)->contains('id', $t->sender_id)) {
                     $conversations[] = [
                        'id' => $t->sender_id,
                        'user_id' => $t->sender_id,
                        'type' => 'admin_ticket',
                        'name' => $t->sender->name ?? 'Unknown',
                        'email' => $t->sender->email ?? '',
                        'unread' => (int) $t->unread,
                        'last_at' => $t->last_at,
                    ];
                }
            }
        }

        // Sort by unread first, then by name
        usort($conversations, function ($a, $b) {
            if ($a['unread'] !== $b['unread']) {
                return $b['unread'] <=> $a['unread'];
            }
            return strcmp($a['name'], $b['name']);
        });

        return response()->json(['conversations' => $conversations]);
    }

    /**
     * Fetch messages for a specific conversation.
     */
    public function messages(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['messages' => []]);
        }

        $type = $request->query('type', 'admin'); // admin, user, group
        // Legacy support for admin panel which might send ?user_id= instead of ?target_id=
        $targetId = $request->query('target_id') ?? $request->query('user_id');

        $query = DirectMessage::with('sender:id,name');

        if ($type === 'admin') {
            if ($user->isAdmin() && $targetId) {
                // Admin viewing a student's ticket
                $query->where(function ($q) use ($targetId, $user) {
                    // Messages from student to admin (null receiver)
                    $q->where('sender_id', $targetId)->whereNull('receiver_id')
                      // Or replies from this admin to the student
                      ->orWhere(function ($q2) use ($targetId, $user) {
                          $q2->where('sender_id', $user->id)->where('receiver_id', $targetId);
                      });
                });
                // Mark read
                DirectMessage::where('sender_id', $targetId)->whereNull('receiver_id')->whereNull('read_at')->update(['read_at' => now()]);
            } else {
                // Student viewing their own admin ticket
                $adminIds = User::where('role', 'admin')->pluck('id');
                $query->where(function ($q) use ($user, $adminIds) {
                    $q->where('sender_id', $user->id)->whereNull('receiver_id')
                      ->orWhere(function($q2) use ($user, $adminIds) {
                          $q2->where('receiver_id', $user->id)->whereIn('sender_id', $adminIds);
                      });
                });
                // Mark read
                DirectMessage::where('receiver_id', $user->id)->whereIn('sender_id', $adminIds)->whereNull('read_at')->update(['read_at' => now()]);
            }
        } elseif ($type === 'user' && $targetId) {
            // 1-on-1 chat
            $query->where(function ($q) use ($user, $targetId) {
                $q->where('sender_id', $user->id)->where('receiver_id', $targetId)
                  ->orWhere(function ($q2) use ($user, $targetId) {
                      $q2->where('sender_id', $targetId)->where('receiver_id', $user->id);
                  });
            });
            // Mark read
            DirectMessage::where('sender_id', $targetId)->where('receiver_id', $user->id)->whereNull('read_at')->update(['read_at' => now()]);
        } elseif ($type === 'group' && $targetId) {
            // Group chat
            $query->where('class_period_id', $targetId);
        } else {
            return response()->json(['messages' => []]);
        }

        $messages = $query->orderBy('created_at', 'asc')->get()
            ->map(fn ($m) => $this->formatMessage($m, $user->id));

        return response()->json(['messages' => $messages]);
    }

    /**
     * Send a message.
     */
    public function send(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'content' => 'required|string|max:2000',
            'type' => 'required|in:admin,user,group',
            'target_id' => 'nullable|integer'
        ]);

        $type = $request->input('type');
        $targetId = $request->input('target_id');
        $content = $request->input('content');

        // Throttle check
        $recentCount = DirectMessage::where('sender_id', $user->id)
            ->where('created_at', '>=', now()->subMinute())
            ->count();
        if ($recentCount >= 20) {
            return response()->json(['error' => 'Terlalu banyak pesan. Coba lagi sebentar.'], 429);
        }

        $msgData = [
            'sender_id' => $user->id,
            'subject' => 'Chat',
            'content' => $content,
        ];

        if ($type === 'admin') {
            $msgData['receiver_id'] = null; // null receiver means sent to admin support
        } elseif ($type === 'user') {
            if (!$targetId) return response()->json(['error' => 'Missing target'], 400);
            $msgData['receiver_id'] = $targetId;
        } elseif ($type === 'group') {
            if (!$targetId) return response()->json(['error' => 'Missing target'], 400);
            $msgData['class_period_id'] = $targetId;
        }

        $message = DirectMessage::create($msgData);

        return response()->json([
            'message' => $this->formatMessage($message->load('sender:id,name'), $user->id),
        ]);
    }

    /**
     * Admin replies to a specific student (kept for backward compatibility if needed by old view).
     */
    public function reply(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) return response()->json(['error' => 'Forbidden'], 403);

        $request->validate([
            'content'     => 'required|string|max:2000',
            'receiver_id' => 'required|exists:users,id',
        ]);

        DirectMessage::where('sender_id', $request->input('receiver_id'))
            ->whereNull('receiver_id')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $message = DirectMessage::create([
            'sender_id'   => $user->id,
            'receiver_id' => $request->input('receiver_id'),
            'subject'     => 'Chat Reply',
            'content'     => $request->input('content'),
        ]);

        return response()->json([
            'message' => $this->formatMessage($message->load('sender:id,name'), $user->id),
        ]);
    }

    public function markRead()
    {
        $user = Auth::user();
        if ($user) {
            DirectMessage::where('receiver_id', $user->id)->whereNull('read_at')->update(['read_at' => now()]);
        }
        return response()->json(['ok' => true]);
    }

    private function formatMessage(DirectMessage $m, int $myId): array
    {
        return [
            'id'        => $m->id,
            'content'   => $m->content,
            'from_me'   => $m->sender_id === $myId,
            'sender'    => $m->sender->name ?? 'System',
            'time'      => $m->created_at->format('H:i'),
            'read'      => ! is_null($m->read_at),
        ];
    }
    public function unreadCount()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['total_unread' => 0]);
        }

        $totalUnread = 0;

        if ($user->isAdmin()) {
            $ticketUnread = DirectMessage::whereNull('receiver_id')
                ->whereNull('read_at')
                ->count();
            $directUnread = DirectMessage::where('receiver_id', $user->id)
                ->whereNull('read_at')
                ->count();
            $totalUnread = $ticketUnread + $directUnread;
        } else {
            $totalUnread = DirectMessage::where('receiver_id', $user->id)
                ->whereNull('read_at')
                ->count();
        }

        return response()->json(['total_unread' => $totalUnread]);
    }
}
