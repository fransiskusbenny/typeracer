<?php

namespace App\Models;

use Illuminate\Auth\GenericUser;
use Illuminate\Http\Request;

class Guest
{
    public static function user(Request $request)
    {
        $user = json_decode($request->cookie('guest'), true);

        if (isset($user['id']) && isset($user['name'])) {
            return new GenericUser([
                'id' => $user['id'],
                'name' => $user['name']
            ]);
        }

        return null;
    }
}