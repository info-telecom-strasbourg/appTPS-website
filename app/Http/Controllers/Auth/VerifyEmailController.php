<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;

/**
 * @group Authentification
 * @subgroup E-Mail Verification
 */
class VerifyEmailController extends Controller
{
    /**
     * Verify Email
     * 
     * Mark the authenticated user's email address as verified.
     * 
     * <aside class="warning">This route should not be a part of the API as it returns a non json response.</aside>
     * @unauthenticated
     * @param \Illuminate\Http\Request $request
     */
    public function __invoke(Request $request)
    {
        $user = User::find($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return view(
                'auth.verify-email',
                [
                    'email' => $user->email,
                    'name' => $user->first_name.' '.$user->last_name
                ]);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return view(
            'auth.verify-email',
            [
                'email' => $user->email,
                'name' => $user->first_name.' '.$user->last_name
            ]);
    }
}
