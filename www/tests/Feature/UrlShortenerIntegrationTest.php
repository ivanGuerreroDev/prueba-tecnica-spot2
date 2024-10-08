<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ShortUrl;

class UrlShortenerIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_shorten_a_url()
    {
        $response = $this->postJson('/shorten', [
            'url' => 'https://example.com'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('short_urls', [
            'original_url' => 'https://example.com'
        ]);
    }

    /** @test */
    public function it_redirects_to_the_original_url()
    {
        $shortUrl = ShortUrl::create([
            'original_url' => 'https://example.com',
            'shortened_url' => ShortUrl::generateShortUrl(),
        ]);

        $response = $this->get('/' . $shortUrl->shortened_url);
        $response->assertRedirect('https://example.com');
    }
}
