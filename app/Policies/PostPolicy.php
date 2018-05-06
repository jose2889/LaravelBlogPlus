<?php

namespace App\Policies;

use App\User;
use App\Post;

use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //por que cuando se invierten el orden de los argumentos y se pasa a $post primero da error? para q funcione primero se debe pasar el modelo User
    public function acces(User $user, Post $post){

        return $post->user_id == $user->id;
    }
}
