<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Hug\PrerenderSpa\PrerenderSpa as PrerenderSpa;

$prerender_url = 'http://123.123.123.123:3000/';
$prerender_auth = 'USER:PASS';
$output = __DIR__ .'/../data/';

# Load Sitemap Urls
// $urls = PrerenderSpa::get_sitemap_urls(__DIR__ . '/../data/sitemap.xml');

$urls = [
	'https://hugo.maugey.fr/developeur-web/HTML5',
	'https://hugo.maugey.fr'
];

error_log(print_r($urls, true));

# Instanciate PrerenderSpa Class
$PrerenderSpa = new PrerenderSpa($urls, $output, $prerender_url, $prerender_auth);
$PrerenderSpa->prerender();

error_log(print_r($PrerenderSpa->report, true));


