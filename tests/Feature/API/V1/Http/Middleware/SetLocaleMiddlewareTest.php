<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetLocaleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_the_locale_based_on_the_request_header()
    {
        // Simulate a request with the 'locale' header set to 'es'
        $this->withHeaders(['locale' => 'es'])->get('/');

        $this->assertEquals('es', app()->getLocale());

        // Repeat the test for 'en' locale
        $this->withHeaders(['locale' => 'en'])->get('/');

        $this->assertEquals('en', app()->getLocale());

        //Try to set a locale that is not supported
        $this->withHeaders(['locale' => 'fr'])->get('/');

        $this->assertEquals('en', app()->getLocale());
    }
}
