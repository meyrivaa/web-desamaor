<?php
namespace Tests\Feature; use Illuminate\Foundation\Testing\RefreshDatabase; use Tests\TestCase;
class PublicPagesTest extends TestCase { use RefreshDatabase; public function test_public_pages_load():void { foreach(['/listing','/profil','/struktur','/berita','/umkm','/infografis','/peta'] as $uri) $this->get($uri)->assertSuccessful(); } }
