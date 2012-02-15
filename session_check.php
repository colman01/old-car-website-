<?php
/*
 * If this file gets included, a session is started if the client sent a session
 * id in some way and if the session hasn't already been started. If the client
 * didn't send a session id, no session is started.
 * The purpose of this is to omit session starting for visitors who are not
 * logged in.
 */


$sessName = session_name();
if (
  (!isset($SID) || (! $SID)) &&
  (
    array_key_exists($sessName, $_COOKIE) ||
    array_key_exists($sessName, $_GET   ) ||
    array_key_exists($sessName, $_POST  )
  )
) {
    session_start();

    if (array_key_exists("account_id", $_SESSION))
        $SID = "$sessName=".session_id();
    else
        destroySession();
} else
    $SID = '';


/*
 * Effectively destroys all session resources.
 */
function destroySession() {
    global $SID;

    $SID = '';
    $_SESSION = array();

    if (isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time() - 86400, '/');

    session_destroy();
}


/*
 * Effectively starts a session for a logged in user with the specified account
 * id.
 */
function startAccountSession($account_id) {
    global $SID;

    session_start();
    $_SESSION['account_id'] = $account_id;

    $SID = session_name().'='.session_id();
}

?>
