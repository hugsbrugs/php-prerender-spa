<?php

# For PHP7
// declare(strict_types=1);

// namespace Hug\Tests\PrerenderSpa;

use PHPUnit\Framework\TestCase;

use Hug\PrerenderSpa\PrerenderSpa as PrerenderSpa;

/**
 *
 */
final class PrerenderSpaTest extends TestCase
{
    public $output;

    function __construct()
    {
        $this->output = __DIR__ . '/../../data/';
    }

    /* ************************************************* */
    /* ********* PrerenderSpa::get_sitemap_urls ******** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanGetSitemapUrlsWithValidSitemap()
    {
        $test = PrerenderSpa::get_sitemap_urls($this->output . 'sitemap.xml');
        $this->assertInternalType('array', $test);
        $this->assertContains('https://hugo.maugey.fr', $test);
    }

    /**
     *
     */
    public function testCannotGetSitemapUrlsWithInvalidSitemap()
    {
        $test = PrerenderSpa::get_sitemap_urls($this->output . 'sitemapcouille.xml');
        $this->assertFalse($test);
    }

    /* ************************************************* */
    /* *********** PrerenderSpa::get_snapshot ********** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanGetSnapshotWithValidUrl()
    {
        $test = PrerenderSpa::get_snapshot('https://hugo.maugey.fr/developeur-web/HTML5', $this->output); // . 'snapshots/'
        $this->assertInternalType('string', $test);
    }

    /**
     *
     */
    public function testCannotGetSnapshotWithInvalidUrl()
    {
        $test = PrerenderSpa::get_snapshot('https://hugo.maugey.fr/developeur-web/HTML6', $this->output . 'snapshots/');
        $this->assertFalse($test);
    }

    /* ************************************************* */
    /* ********** PrerenderSpa::url_to_filename ******** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanUrlToFilenameWithValidUrl()
    {
        $test = PrerenderSpa::url_to_filename('https://hugo.maugey.fr');
        $this->assertInternalType('string', $test);
        $this->assertEquals('index.html', $test);

        $test = PrerenderSpa::url_to_filename('https://hugo.maugey.fr/developeur-web/Geocoding');
        $this->assertInternalType('string', $test);
        $this->assertEquals('/developeur-web/Geocoding.html', $test);

        $test = PrerenderSpa::url_to_filename('https://hugo.maugey.fr/conversion/entités-html');
        $this->assertInternalType('string', $test);
        $this->assertEquals('/conversion/entités-html.html', $test);
    }

    /* ************************************************* */
    /* ************ PrerenderSpa::log_snapshot ********* */
    /* ************************************************* */

    /**
     *
     */
    public function testCanLogSnapshot()
    {
        $ip = '123.123.123.123';
        $ua = 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';
        $url = 'http://test.com';
        $http_code = 200;
        $test = PrerenderSpa::log_snapshot($ip, $ua, $url, $http_code, $this->output);
        $this->assertInternalType('boolean', $test);
        $this->assertTrue($test);
    }

    /* ************************************************* */
    /* ************** PrerenderSpa::set_404 ************ */
    /* ************************************************* */

    /**
     *
     */
    public function testCanSet404()
    {
        $html = 'My 404 Page';
        $test = PrerenderSpa::set_404($html, $this->output);
        $this->assertInternalType('boolean', $test);
        $this->assertTrue($test);
    }

    /* ************************************************* */
    /* ************** PrerenderSpa::get_404 ************ */
    /* ************************************************* */

    /**
     *
     */
    public function testCanGet404()
    {
        $test = PrerenderSpa::get_404($this->output);
        $this->assertInternalType('string', $test);
    }

    /* ************************************************* */
    /* ********** PrerenderSpa::get_default_404 ******** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanGetDefault404()
    {
        $test = PrerenderSpa::get_default_404();
        $this->assertInternalType('string', $test);
    }

    /* ************************************************* */
    /* ************** PrerenderSpa::set_500 ************ */
    /* ************************************************* */

    /**
     *
     */
    public function testCanSet500()
    {
        $html = 'My 500 Page';
        $test = PrerenderSpa::set_500($html, $this->output);
        $this->assertInternalType('boolean', $test);
        $this->assertTrue($test);
    }

    /* ************************************************* */
    /* ************** PrerenderSpa::get_500 ************ */
    /* ************************************************* */

    /**
     *
     */
    public function testCanGet500()
    {
        $test = PrerenderSpa::get_500($this->output);
        $this->assertInternalType('string', $test);
    }

    /* ************************************************* */
    /* ********** PrerenderSpa::get_default_500 ******** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanGetDefault500()
    {
        $test = PrerenderSpa::get_default_500();
        $this->assertInternalType('string', $test);
    }

}

