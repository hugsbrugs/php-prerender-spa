<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Hug\PrerenderSpa\PrerenderSpa as PrerenderSpa;
use Hug\Http\Http as Http;

$url = $_REQUEST['URL'];
error_log('url : ' . $url);

$output = __DIR__ . '/../data/';

# Get Snapshot
// $url = 'https://hugo.maugey.fr/developeur-web/HTML5';
if(false !== $snapshot = PrerenderSpa::get_snapshot($url, $output)
{
	Http::header_status(200);
	# gzip ?
	echo $snapshot;
}
else
{
	# Set Header status 404 Not Found
	Http::header_status(404);
	# include real 404
	echo '404';
}
