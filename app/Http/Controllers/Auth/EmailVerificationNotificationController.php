<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * @group Authentification
 * @subgroup E-Mail Verification
 */
class EmailVerificationNotificationController extends Controller
{
    /**
     * Send Verification E-mail
     * 
     * Send an email verification notification to the current user's mail address, if it's not already verified.
     * @param Request $request
     *
     */
    public function store(Request $request){

        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email is already verified'
            ], 400);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Verification link sent'
        ], 200);
    }
}
