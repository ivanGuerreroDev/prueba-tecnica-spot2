<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\ShortUrl;

class ShortUrlTest extends TestCase
{
    /** @test */
    public function it_generates_a_short_url_with_8_characters()
    {
        $shortenedUrl = ShortUrl::generateShortUrl();
        $this->assertEquals(8, strlen($shortenedUrl));
    }

    /** @test */
    public function it_generates_an_alphanumeric_short_url()
    {
        $shortenedUrl = ShortUrl::generateShortUrl();
        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9]{8}$/', $shortenedUrl);
    }
}
