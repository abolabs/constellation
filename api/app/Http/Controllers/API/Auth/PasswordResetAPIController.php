<?php

// Copyright (C) 2023 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program. If not, see

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\ResetPasswordRequest;
use App\Http\Requests\API\SendResetLinktAPIRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Class ApplicationController.
 */
class PasswordResetAPIController extends AppBaseController
{
    public function sendResetLink(SendResetLinktAPIRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_THROTTLED) {
            return $this->sendError(
                'Trop de tentatives de réinitialisation de mot de passe. Veuillez réessayer dans quelques minutes.',
                429
            );
        }

        if ($status !== Password::RESET_LINK_SENT) {
            return $this->sendError(
                'Erreur durant la réinitialisation du mot de passe. [statut='.$status.']',
                400
            );
        }

        return $this->sendSuccess('Link sent.');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::INVALID_TOKEN) {
            return $this->sendError(
                'Erreur durant la réinitialisation du mot de passe. Token invalide.',
                400
            );
        }

        if ($status === Password::INVALID_USER) {
            return $this->sendError(
                'Erreur durant la réinitialisation du mot de passe. Email invalide.',
                400
            );
        }

        if ($status !== Password::PASSWORD_RESET) {
            return $this->sendError(
                'Erreur durant la réinitialisation du mot de passe. [statut='.$status.']',
                400
            );
        }

        return $this->sendSuccess('Password changed.');
    }
}
