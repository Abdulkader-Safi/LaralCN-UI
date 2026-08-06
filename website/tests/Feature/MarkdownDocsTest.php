<?php

namespace Tests\Feature;

use Tests\TestCase;

class MarkdownDocsTest extends TestCase
{
    public function test_llms_txt_lists_every_component_as_markdown(): void
    {
        $response = $this->get('/llms.txt');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/plain; charset=utf-8');
        $response->assertSee('# LaralCN-UI', false);
        $response->assertSee('composer require --dev safi/laralcn-ui', false);
        $response->assertSee('/components/button.md', false);
        $response->assertSee('/blocks/navbar-01.md', false);
    }

    public function test_component_markdown_carries_the_installable_source(): void
    {
        $response = $this->get('/components/button.md');

        $response->assertStatus(200);
        $response->assertSee('php artisan ui:add button', false);
        // The real registry file, not a paraphrase of it.
        $response->assertSee("@props([\n    'variant' => 'default',", false);
        $response->assertSee('TailwindMerge::merge(', false);
    }

    public function test_the_md_suffix_does_not_shadow_the_html_page(): void
    {
        $this->get('/components/button')->assertStatus(200)->assertSee('Installation');
        $this->get('/components/nope.md')->assertStatus(404);
    }

    public function test_index_block_and_theming_pages_have_markdown_twins(): void
    {
        $this->get('/components.md')->assertStatus(200)->assertSee('# Components', false);
        $this->get('/blocks.md')->assertStatus(200)->assertSee('# Blocks', false);
        $this->get('/blocks/navbar-01.md')->assertStatus(200)->assertSee('php artisan ui:add-block navbar-01', false);
        $this->get('/theming.md')->assertStatus(200)->assertSee('--background', false);
        $this->get('/llms-full.txt')->assertStatus(200)->assertSee('# button', false);
    }

    public function test_pages_offer_a_copy_page_button(): void
    {
        $this->get('/components/button')->assertSee(route('docs.show.md', 'button'), false);
        $this->get('/components')->assertSee(route('docs.index.md'), false);
    }
}
