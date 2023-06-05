<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckCas
{

    //put here the admin mail
    private $_adminMails = ["felix.lusseau@etu.unistra.fr", "gatien.chenu@etu.unistra.fr", "enzo.bergamini@etu.unistra.fr"];
    //private $_adminMails = ["gatien.chenu@etu.unistra.fr"];
    private $_udsDisplayNamePoperty = "udsDisplayName";

    /**
     * Handle an incoming request and redirect to the CAS if the user is not
     * connected. Then, a session starts with his attributes
     * (name, mail, role...).
     * DO NOT use the session. Use the getters bellow.
     *
     * @param \Illuminate\Http\Request $request the current request.
     * @param \Closure                 $next    a closure to redirect $next
     * @param $role    is the requested role of the current user.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {

        if (!cas()->checkAuthentication()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            }
            cas()->authenticate();
        }

        // add attribute to session
        if (cas()->hasAttribute("mail")) {
            session()->put('cas_mail', cas()->getAttribute("mail"));
        }


        if (cas()->hasAttribute("displayName")) {
            session()->put('cas_name', cas()->getAttribute("displayName"));
        }

        session()->put('cas_user', cas()->user());

        $udsStudentName = cas()->getAttribute($this->_udsDisplayNamePoperty);
        // Search "etu tps" in the udsDisplayName attribute of the user
        $isStudent = (strpos(strtolower($udsStudentName), "etu tps") || strpos(strtolower($udsStudentName), "etu esbs") || strpos(strtolower($udsStudentName), "azet vincent (tps)") || strpos(strtolower($udsStudentName), "erronno paul (icube)") || strpos(strtolower($udsStudentName), "ossetti")) ;

        if (!cas()->hasAttribute($this->_udsDisplayNamePoperty)) {

            session()->put('auth_error', "udsfieldmissing");
            return redirect("authentication-failed");
        }

        if ($role === 'authenticated') {
            if (
                $isStudent === false &&
                (!cas()->hasAttribute("mail") ||  in_array(cas()->getAttribute("mail"), $this->_adminMails))
            ) {
                session()->put('auth_error', "notfromtps");
                return redirect("authentication-failed");
            }

            if (cas()->hasAttribute("mail") && in_array(cas()->getAttribute("mail"), $this->_adminMails)) {
                session()->put('cas_role', "admin");
                return $next($request);
            }

            $isRedacteur = json_decode(json_encode(DB::table('users')
                ->select('redacteur')
                ->WHERE('id', '=', $this->getUser())
                ->first()), true);
            if (isset($isRedacteur)) {
                $isRedacteur = $isRedacteur['redacteur'];
                if ($isStudent && $isRedacteur) {
                    session()->put('cas_role', "rédacteur");
                    return $next($request);
                }
            }

            if ($isStudent) {
                session()->put('cas_role', "étudiant");
                return $next($request);
            }

            if ($isStudent === false) {
                session()->put('auth_error', "notfromtps");
                return redirect("authentication-failed");
            }
        }

        if ($role === 'student') {

            if ($isStudent === false) {
                session()->put('auth_error', "notfromtps");
                return redirect("authentication-failed");
            } else {
                session()->put('cas_role', "étudiant");
                return $next($request);
            }
        }

        if ($role === 'admin' && cas()->hasAttribute("mail")) {

            if (in_array(cas()->getAttribute("mail"), $this->_adminMails)) {
                session()->put('cas_role', "admin");
                return $next($request);
            } else {
                session()->put('auth_error', "notadminmail");
                return redirect("authentication-failed");
            }
        } elseif (!cas()->hasAttribute("mail")) {
            session()->put('auth_error', "mailfieldmissing");
            return redirect("authentication-failed");
        }

        session()->put('auth_error', "unknown");
        return redirect("authentication-failed");
    }

    /**
     * This function returns the current user (uid attribute).
     * The string returned can never be empty.
     *
     * @return type
     */
    public static function getUser()
    {
        return session()->get('cas_user');
    }

    /**
     * This function returns the mail of the current user.
     * The returned value can be empty !
     *
     * @return type
     */
    public static function getMail()
    {
        return session()->get('cas_mail');
    }

    /**
     * This function returns the name of the current user.
     * The returned value can be empty !
     *
     * @return type
     */
    public static function getName()
    {
        return session()->get('cas_name');
    }

    /**
     * This function returns the role of the current user. It is 'admin' or
     * 'étudiant'.
     * * This function never fails.
     *
     * @return type string 'admin' or 'étudiant'.
     */
    private static function _getRole()
    {
        return session()->get('cas_role');
    }

    /**
     * This function check if the current user is an admin based on his role.
     *
     * @return boolean  True if the user is an admin and false either
     */
    public static function isAdmin()
    {
        if (CheckCas::_getRole() === 'admin') {
            return true;
        }
        return false;
    }

    /**
     * This function check if the current user is a student based on his role.
     *
     * @return boolean  True if the user is a student and False either
     */
    public static function isStudent()
    {
        if (CheckCas::_getRole() === 'étudiant') {
            return true;
        }
        return false;
    }


    /**
     * This function returns an array with all keys/values returned by the CAS.
     *
     * @return array of attributes.
     */
    public static function getAttributes()
    {
        if (cas()->isAuthenticated()) {
            return cas()->getAttributes();
        } else {
            return array();
        }
    }

    /**
     * This function returns an array with the keys/values returned by the CAS for the App.
     *
     * @return array of attributes.
     */
    public static function getAttributesApp()
    {
        if (cas()->isAuthenticated()) {
            return array(cas()->user(), cas()->getAttribute("udsDisplayName"), cas()->getAttribute("mail"));
        } else {
            return array();
        }
    }

    /**
     * Logout the user from his session.
     *
     * @param string $redirectUrl is the URL where the user is redirected after
     *                            logout.
     *
     * @return nothing.
     */
    public static function logout($redirectUrl)
    {
        cas()->logout($redirectUrl);
    }

    /**
     * If the user can't connect to the site, return an appropriate error.
     *
     * @return string :
     * - 'notfromtps' if the user doesn't come from TPS
     * - 'udsfieldmissing' if the uds property is missing from the CAS
     * - 'unknown' if unknown error has happened
     * - 'notadminmail' if the current user try to access an admin page
     *    without having the right access.
     * - 'mailfieldmissing' if the mail field from CAS is missing (only for
     *    admin).
     */
    public static function getErrorAuth()
    {
        return session()->get('auth_error');
    }
}
