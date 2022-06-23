<?php
/**
 * Routes requests to relevant views.
 *
 * PHP version 7.4
 *
 * @category Root
 *
 * @package WatchTowerUI
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

	session_start();
	
	define('ROOTDIR', __DIR__);

	$request = $_SERVER['REQUEST_URI'];

	if (strpos($request, "?") !== false) {
		$request = substr($request, 0, strpos($request, "?"));
	}

	if (strpos($request, "#") !== false) {
		$request = substr($request, 0, strpos($request, "#"));
	}

	$excludedPaths = array("/static","/favicon.ico");
	foreach ($excludedPaths as $path) {
		if ((strpos($request, $path) !== false)) {
			return false;
		}
	}


	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	include_once __DIR__ . '/services/index.php';

	$fmhost = $config["filemaker"]["server_address"];
	$fmusername = $config["filemaker"]["username"];
	$fmpassword = $config["filemaker"]["password"];

	//$_fm = new FMService($fmhost, $fmusername, $fmpassword);

	$servername = $config['mysql']['hostname'];
	$username = $config['mysql']['username'];
	$password = $config['mysql']['password'];
	$database = $config['mysql']['database'];
	$_db = new DbService($servername, $username, $password, $database);

	$mysqli = $_db->mysqli;
	
	if ((strpos($request, "/api") !== false)) {
		include_once __DIR__ . $_SERVER['REQUEST_URI'];
		return;
	}
	
	?>



<title>BW DR Web App</title>
<script src="jquery-3.6.0.min.js"></script>
<script>
	if (!" . (isset($_SESSION['pw']) ? 'true' : 'false') . ") {
		let pw = prompt('Please enter the password');
		location.replace('/auth.php?pw=' + pw + '&redirect_to=" . $_SERVER['REQUEST_URI'] . "');
	}
</script>

	<?php
	if (!isset($_SESSION['pw']) || $_SESSION['pw'] != $config['site_password']) {
		$_SESSION['pw'] = null;
		die('unauthorized');
	}

	$noMenu = array(
		"/archery/campers" => '/views/archery/components/campers.php',
		"/archery/awards" => '/views/archery/components/awards.php',
		"/archery/activitySignups" => '/views/archery/components/activitySignups.php',
		"/archery/camperProgress" => '/views/archery/components/camperProgress.php',
		"/archery/camperProgressSearch" => '/views/archery/components/camperProgressSearch.php',
		"/archery/createPerson" => '/views/archery/components/createPerson.php',
		"/archery/editCamperProgress" => '/views/archery/components/editCamperProgress.php',
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
			"/archery/" => '/views/archery/index.php',
			"/archery" => '/views/archery/index.php',
			"" => '/views/home/index.php',
			"/" => '/views/home/index.php'
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
