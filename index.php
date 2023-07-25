<?php
/**
 * Routes requests to relevant views.
 *
 * PHP version 7.4
 *
 * @category Root
 *
 * @package Brookwoods
 *
 * @author Bennett Forkner <bennett.forkner@gordon.edu>
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *
 * @link /index.php
 *
 * @since 3/9/2022
 */
namespace Brookwoods {

	$config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/config.json'), true);
	
	$request = $_SERVER['REQUEST_URI'];

	if (strpos($request, "?") !== false) {
		$request = substr($request, 0, strpos($request, "?"));
	}

	if (strpos($request, "#") !== false) {
		$request = substr($request, 0, strpos($request, "#"));
	}
	
	if ($request == '/auth.php') {
		include_once __DIR__ . $request;
		exit;
	}

	session_start();
	
	define('ROOTDIR', __DIR__);

	$excludedPaths = array("/static","/favicon.ico");
	foreach ($excludedPaths as $path) {
		if ((stripos($request, $path) !== false)) {
			return false;
		}
	}

	include_once __DIR__ . '/services/index.php';

	$fmhost = $config["filemaker"]["server_address"];
	$fmusername = $config["filemaker"]["username"];
	$fmpassword = $config["filemaker"]["password"];

	//$_fm = new FMService("https://New-Hampshire-Server.local:3000", "Archery", "PersuadePromptDoLift");

	$servername = $config['mysql']['hostname'];
	$username = $config['mysql']['username'];
	$password = $config['mysql']['password'];
	$database = $config['mysql']['database'];
	$_db = new DbService($servername, $username, $password, $database);

	$mysqli = $_db->mysqli;
	
	if ((strpos($request, "/api") !== false)) {
		include_once __DIR__ . $request;
		return;
	}
	?>

<title>BW DR Web App</title>
<script src="/static/js/jquery-3.6.0.min.js"></script>
<link rel="icon" type="image/x-icon" href="/static/img/favicon.ico">

	<?php
	echo "<script>
		if (!" . (isset($_SESSION['pw']) ? 'true' : 'false') . ") {
			let pw = prompt('Please enter the password');
			location.replace('/auth.php?pw=' + pw + '&redirect_to=" . $_SERVER['REQUEST_URI'] . "');
		}
	</script>";

	if (!isset($_SESSION['pw']) || $_SESSION['pw'] != $config['site_password']) {
		$_SESSION['pw'] = null;
		die('Unauthorized');
	}

	$noMenu = array(
		"/archery/campers" => '/views/archery/components/campers.php',
		"/archery/awards" => '/views/archery/components/awards.php',
		"/archery/activitySignups" => '/views/archery/components/activitySignups.php',
		"/archery/camperProgress" => '/views/archery/components/camperProgress.php',
		"/archery/camperProgressSearch" => '/views/archery/components/camperProgressSearch.php',
		"/archery/createPerson" => '/views/archery/components/createPerson.html',
		"/archery/editCamperProgress" => '/views/archery/components/editCamperProgress.php',
		"/archery/sessions" => '/views/archery/components/sessions.php',
		"/archery/createSession" => '/views/archery/components/createSession.php',
		"/archery/uploadSessionCampers" => '/views/archery/components/uploadSessionCampers.php',
	);

	$loaded = false;

	foreach ($noMenu as $uri => $page) {
		if ($request == $uri) {
			include __DIR__ . $page;
			$loaded = true;
		}
	}
	if (!$loaded) {
		$pages = array(
			"/archery/" => '/views/archery/index.html',
			"/archery" => '/views/archery/index.html',
			"" => '/views/home/index.html',
			"/" => '/views/home/index.html'
		);

		foreach ($pages as $uri => $page) {
			if ($request == $uri) {
				include_once(__DIR__ . $page);
				$loaded = true;
			}
		}

		if (!$loaded) {
			include_once(__DIR__ . '/views/errors/404.html');
		}
	}
}
