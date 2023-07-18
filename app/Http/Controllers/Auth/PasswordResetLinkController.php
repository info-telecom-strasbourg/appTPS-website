<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     */
    public function store(Request $request) {
        $request->validate([
            'email' => [
                'required',
                'email' // Do not verify if the email exists in the database to avoid giving information to a potential hacker
            ]
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => 'Email not send'
            ], 404);
        }

        return response()->json([
            'message' => 'Reset email link send'
        ], 200);
    }
}
