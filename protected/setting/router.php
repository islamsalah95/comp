<?php
/* Directory that contains classes */
$classesDir = array(
    SERVER_ROOT . '/protected/library/'
);

/* Loading all library components everywhere */
spl_autoload_register(function ($class) {
    global $classesDir;
    foreach ($classesDir as $directory) {
        if (file_exists($directory . $class . '_class.php')) {
            require($directory . $class . '_class.php');
            return;
        }
    }
    require($directory . 'ssp_class.php');
});

/* Connect to an ODBC database using driver invocation */
if (file_exists(SERVER_ROOT . "/protected/setting/" . Appname . "lock")) {
    $db = new db("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
}
$fv = new form_validations();
$feature = new feature();
$password = new password();
$link = new links();
$session = new session();
$security = new security();

/**
 * This controller routes all incoming requests to the appropriate controller and page
 */

$request = explode('?', $_SERVER['REQUEST_URI']);
if (isset($request[1])) {
    $parsed = explode('=', $request[1]);
    $query1 = $parsed[0];
    $query1ans = null;
    $query2 = null;
    $query2ans = null;
    $query3 = null;

    if (count($parsed) >= 2) {
        $query1ans = $parsed[1];
        $getParsed = explode('&', $query1ans);

        if (count($getParsed) >= 2) {
            $query2 = $getParsed[1];
            $query2ans = $getParsed[0];
            $query2ans_extended = explode('&', $query2ans);

            if (count($query2ans_extended) >= 2) {
                $query2ans = $query2ans_extended[0];
                $query3 = $query2ans_extended[1];
            }
        }
    }
}

if (!file_exists(SERVER_ROOT . "/protected/setting/" . Package . "lock")) {
    setcookie('remember_me', "", time() - 3600);
    session_unset();
    session_destroy();
    $query1 = 'user';
    if ($query1ans != 'installation' && $query1ans != 'installation_final') {
        $query1ans = 'installation';
    }
    $query1 = "installation";
    require SERVER_ROOT . '/protected/setting/installationcases.php';
} else {
    require SERVER_ROOT . '/protected/setting/frontendcases.php';
}
