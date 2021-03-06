# php-prerender-spa

This librairy provides utilities function to serve Search Engine Crawlers Website Snapshots

[![Build Status](https://travis-ci.org/hugsbrugs/php-prerender-spa.svg?branch=master)](https://travis-ci.org/hugsbrugs/php-prerender-spa)
[![Coverage Status](https://coveralls.io/repos/github/hugsbrugs/php-prerender-spa/badge.svg?branch=master)](https://coveralls.io/github/hugsbrugs/php-prerender-spa?branch=master)

## Install

Install package with composer
```
composer require hugsbrugs/php-prerender-spa
```

In your PHP code, load library
```php
require_once __DIR__ . '/../vendor/autoload.php';
use Hug\PrerenderSpa\PrerenderSpa as PrerenderSpa;
```

## Usage

### First Step : Generate Your Webpages Snapshots
```php
$prerender_url = 'http://123.123.123.123:3000/';
$prerender_auth = 'USER:PASSWORD'; // or null
$output = __DIR__ .'/../data/snapshots/'; // directory where to store snapshot (must be writable)

# Load Urls From Sitemap
$urls = PrerenderSpa::get_sitemap_urls('/path/to/sitemap.xml');

# Or Set Urls manually
// $urls = ['https://hugo.maugey.fr/developeur-web/HTML5'];

# Instanciate PrerenderSpa
$PrerenderSpa = new PrerenderSpa($urls, $output, $prerender_url, $prerender_auth);
#  Launch Snapshot Generation
$PrerenderSpa->prerender();
# Wait ....
# Print Report
error_log(print_r($PrerenderSpa->report, true));
# Set Your Personnalized 404
$html = 'My Personalized 404';
PrerenderSpa::set_404($html, $output);
# Set Your Personnalized 500
$html = 'My Personalized 500';
PrerenderSpa::set_500($html, $output);
```

### Second Step : Serve Webpage Snapshots to web crawlers
Redirect search engine crawlers to prerender.php service
```
<IfModule mod_proxy_http.c>
    RewriteCond %{HTTP_USER_AGENT} googlebot|yahoo|bingbot|baiduspider [NC,OR]
    RewriteCond %{QUERY_STRING} _escaped_fragment_
    RewriteRule ^(?!.*?(\.js|\.css|\.xml|\.less|\.png|\.jpg|\.jpeg|\.gif|\.pdf|\.doc|\.txt|\.ico|\.rss|\.zip|\.mp3|\.rar|\.exe|\.wmv|\.doc|\.avi|\.ppt|\.mpg|\.mpeg|\.tif|\.wav|\.mov|\.psd|\.ai|\.xls|\.mp4|\.m4a|\.swf|\.dat|\.dmg|\.iso|\.flv|\.m4v|\.torrent|\.ttf|\.woff))(index\.php)?(.*) /prerender.php/https://hugo.maugey.fr/$3 [P,L]
</IfModule>
```

Have a look at [prerender.php](example/prerender.php)
```php
# Where do you store prerender filesystem
$output = __DIR__ . '/../data/';

# .htaccess http://prerender.io/URL_TO_SNAP
$url = $_REQUEST['URL'];

$html = null;
$http_code = null;

try
{
	# Get Snapshot
	if(false !== $snapshot = PrerenderSpa::get_snapshot($url, $output)
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

}
catch(\Exception $e)
{
	$http_code = 500;
	$html = PrerenderSpa::get_500($output);
}

Http::header_status($http_code);
echo $html;
```


### Third Step : Generate Snapshot On Demand
Repeat First Step by providing only URLs whose content has changed to optimize server from running headless browser snapshot service for nothing.

## Why This Service ?

I've been using Prerender service hosted on my servers for a while now and was using brenett extension to cache snapshots but that solution was not satisfying me anymore because of a fixed cache time. So snapshots were regenerated even if they didn't needed to be. And time for serving snapshots, which is critical from an SEO point of view was just an abomination because of the lack of pre-prendering after cache expires and before crawlers were asking for content. This solution is not perfect because you need to manually list files you want to regenerate snapshots for but it suit my needs ;)

## Unit Tests

```
composer exec phpunit
```

## To Do

Compress gzip saved HTML
Archive snapshots

## Author

Hugo Maugey [visit my website ;)](https://hugo.maugey.fr)