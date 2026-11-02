<?php

use Illuminate\Support\Facades\Broadcast;

// Channel for student private notifications
Broadcast::channel('student.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Channel for staff private notifications
Broadcast::channel('staff.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Channel for parent receiving notifications about child
Broadcast::channel('parent.{id}', function ($user, $id) {
    return $user->students()->where('id', $id)->exists();
});

// Chat channel
Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    return $user->conversations()->where('id', $conversationId)->exists();
});
