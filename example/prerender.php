<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Hug\PrerenderSpa\PrerenderSpa as PrerenderSpa;
use Hug\Http\Http as Http;


# Where do you store prerender filesystem
$output = __DIR__ . '/../data/';
$log = true;


# .htaccess http://prerender.io/URL_TO_SNAP
$url = $_REQUEST['URL'];
# .htaccess http://prerender?URL_TO_SNAP
// $url = $_SERVER['QUERY_STRING'];

# In special case you have to rewrite home URL
// if($url==='https://hugo.maugey.fr/index.php')
// 	$url = 'https://hugo.maugey.fr/index';

// error_log('Prerender URL : ' . $url);

$html = null;
$http_code = null;

try
{
	# Get Snapshot
	if(false !== $snapshot = PrerenderSpa::get_snapshot($url, $output))
	{
		$http_code = 200;
		$html = $snapshot;
	}
	else
	{
		# Set Header status 404 Not Found
		$http_code = 404;
		$html = PrerenderSpa::get_404($output);
	}

	# Log Snapshot Request to analyse traffic
	if($log)
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$ua = $_SERVER['HTTP_USER_AGENT'];
		PrerenderSpa::log_snapshot($ip, $ua, $url, $http_code, $output);
	}

}
catch(\Exception $e)
{
	$http_code = 500;
	$html = PrerenderSpa::get_500($output);
}

Http::header_status($http_code);
echo $html;
