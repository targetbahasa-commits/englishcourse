<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('monitoring', function ($user) {
    if ($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->role,
        ];
    }
    return false;
});

// Private channel for WebRTC signaling
Broadcast::channel('remote-view.{id}', function ($user, $id) {
    // Both the target user AND admins/teachers can join
    return (int) $user->id === (int) $id || in_array($user->role, ['admin', 'teacher']);
});
