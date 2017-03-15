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
        $test = PrerenderSpa::get_snapshot('https://hugo.maugey.fr/developeur-web/HTML5', $this->output . 'snapshots/');
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
        $this->assertEquals('developeur-web-Geocoding.html', $test);

        $test = PrerenderSpa::url_to_filename('https://hugo.maugey.fr/conversion/entités-html');
        $this->assertInternalType('string', $test);
        $this->assertEquals('conversion-entités-html.html', $test);
    }

}

