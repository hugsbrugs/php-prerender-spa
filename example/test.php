<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Hug\PrerenderSpa\PrerenderSpa as PrerenderSpa;

$prerender_url = 'http://123.123.123.123:3000/';
$prerender_auth = 'USER:PASS';

$prerender_url = 'http://localhost:3000/';
$prerender_auth = null;

$output = __DIR__ .'/../data/';


# Load Sitemap Urls
// $urls = PrerenderSpa::get_sitemap_urls(__DIR__ . '/../data/sitemap.xml');

$urls = [
	'https://hugo.maugey.fr/developeur-web/HTML5',
	'https://hugo.maugey.fr',
	'https://hugo.maugey.fr/contact'
];

error_log(print_r($urls, true));

# Instanciate PrerenderSpa Class
$PrerenderSpa = new PrerenderSpa($urls, $output, $prerender_url, $prerender_auth);
$PrerenderSpa->prerender();

error_log(print_r($PrerenderSpa->report, true));

# Check snapshots (à améliorer -> tester la présence d'une balise)
// foreach ($urls as $key => $url)
// {
// 	$snapshot = PrerenderSpa::get_snapshot($url, $output);
// 	error_log($snapshot);
// }


# Get Your Personnalized 404
// $page = PrerenderSpa::get_404($output);
// echo $page;

# Set Your Personnalized 404
// $html = 'coucou';
// $set = PrerenderSpa::set_404($html, $output);
// echo var_dump($set);

# Get Your Personnalized 500
// $page = PrerenderSpa::get_500($output);
// echo $page;

# Set Your Personnalized 500
// $html = 'coucou';
// $set = PrerenderSpa::set_500($html, $output);
// echo var_dump($set);

# Log Snapshot Request
// $ip = '123.123.123.123';
// $ua = 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';
// $url = 'http://test.com';
// $http_code = 200;
// $log = PrerenderSpa::log_snapshot($ip, $ua, $url, $http_code, $output);
// echo var_dump($log);
