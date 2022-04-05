<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return optional($user)->id > 0;
    }

    public function create(User $user)
    {
        return $user->id > 0;
    }

    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
    // public function before(User $user, $ability)
    // {
    //     if ($user->isAdmin) {
    //         return true;
    //     }
    // }

    public function after(User $user, $ability)
    {
        if ($user->isAdmin) {
            return true;
        }
    }
}

