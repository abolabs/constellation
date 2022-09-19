<?php

namespace App\Claims;

use CorBosman\Passport\AccessToken;
use App\Models\User;

class CustomClaim
{
    public function handle(AccessToken $token, $next)
    {
        $user = User::find($token->getUserIdentifier());

        $token->addClaim('email', $user->email);
        $token->addClaim('name', $user->name);

        return $next($token);
    }
}
