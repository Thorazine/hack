<?php

namespace Thorazine\Hack\Database\Seeds;

use Illuminate\Database\Seeder;
use Thorazine\Hack\Models\Templateable;
use Thorazine\Hack\Models\Template;
use Thorazine\Hack\Models\Pageable;
use Thorazine\Hack\Models\Page;
use Thorazine\Hack\Models\Menu;
use Thorazine\Hack\Models\MenuItem;
use Thorazine\Hack\Models\Builders\Menu as MenuBuilder;
use Thorazine\Hack\Models\Builders\Text;
use Thorazine\Hack\Models\Builders\Wysiwyg;

class HackExampleSite extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// create home page template
        Template::insert([
        	'site_id' => 1,
        	'refrence' => 'Home',
        	'prepend_slug' => '',
        	'view' => 'home',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // create a simple multipurpose page template
        Template::insert([
        	'site_id' => 1,
        	'refrence' => 'Simple page',
        	'prepend_slug' => '',
        	'view' => 'simple',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // create a search page template
        Template::insert([
        	'site_id' => 1,
        	'refrence' => 'Search',
        	'prepend_slug' => '',
        	'view' => 'search',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // create a 404 template
    	Template::insert([
        	'site_id' => 1,
        	'refrence' => '404',
        	'prepend_slug' => '404',
        	'view' => '404',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

    	// create a templateable builder refrence to home
        Templateable::insert([
        	'template_id' => 1,
        	'templateable_id' => '1',
        	'templateable_type' => 'Thorazine\Hack\Models\Builders\Text',
        	'slug' => '/',
        	'drag_order' => '1',
        ]);

    	// create a templateable builder refrence to home
        Templateable::insert([
        	'template_id' => 1,
        	'templateable_id' => '1',
        	'templateable_type' => 'Thorazine\Hack\Models\Builders\Wysiwyg',
        	'slug' => '/',
        	'drag_order' => '2',
        ]);

    	// create a templateable builder refrence to home
        Templateable::insert([
        	'template_id' => 1,
        	'templateable_id' => '1',
        	'templateable_type' => 'Thorazine\Hack\Models\Builders\Menu',
        	'slug' => '/',
        	'drag_order' => '3',
        ]);

        Page::insert([
        	'site_id' => '1',
        	'template_id' => '1',
        	'prepend_slug' => '',
        	'slug' => '',
        	'language' => 'en',
        	'title' => 'Home',
        	'body' => '<h1>H1</h1>
				<h2>H2</h2>
				<p>Normal text</p>
				<ul>
				<li>Bullit item 1</li>
				<li>Bullit item 2</li>
				<li>Bullit item 3</li>
				</ul>
				<ol>
				<li>Numbered item 1</li>
				<li>Numbered item 2</li>
				<li>Numbered item 3</li>
				</ol>
				<p><a title="Link to another page" href="/simple-page">Link to simple-page</a></p>
				<p>Font styles:</p>
				<p><strong>Bold</strong></p>
				<p><em>Italic</em></p>
				<p><em><strong>Bold and italic</strong></em></p>
				<p style="text-align: left;">Left align</p>
				<p style="text-align: center;">Center align</p>
				<p style="text-align: right;">Right align</p>
				<div class="iframe youtube"><iframe src="https://www.youtube.com/embed/QH2-TGUlwu4" width="1200" height="150" data-mce-fragment="1"></iframe></div>
				<p>More text</p>',
        	'view' => 'example.home',
        	'search_priority' => '5',
        	'publish_at' => date('Y-m-d H:i:s'),
        	'depublish_at' => null,
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Page::insert([
        	'site_id' => '1',
        	'template_id' => '2',
        	'prepend_slug' => '',
        	'slug' => 'simple-page',
        	'language' => 'en',
        	'title' => 'This is an example title',
        	'body' => '<p>This is an example body text</p>',
        	'view' => 'example.simple',
        	'search_priority' => '5',
        	'publish_at' => date('Y-m-d H:i:s'),
        	'depublish_at' => null,
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Page::insert([
        	'site_id' => '1',
        	'template_id' => '3',
        	'prepend_slug' => '',
        	'slug' => 'search',
        	'language' => 'en',
        	'title' => 'This page will have a search mechanism',
        	'body' => '<p>This is due to the fact that the template view name is "search"</p>',
        	'view' => 'example.search',
        	'search_priority' => '',
        	'publish_at' => date('Y-m-d H:i:s'),
        	'depublish_at' => null,
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Page::insert([
        	'site_id' => '1',
        	'template_id' => '4',
        	'prepend_slug' => '404',
        	'slug' => '',
        	'language' => 'en',
        	'title' => 'This page is not found',
        	'body' => '<p>Any 404 will end up here. You can fully customize this page as you like.</p>
				<p>If this template is not defined it will just fallback to the Laravel default 404 system (views/errors/404 or "whoops" screen)</p>',
        	'view' => 'example.404',
        	'search_priority' => '0',
        	'publish_at' => date('Y-m-d H:i:s'),
        	'depublish_at' => null,
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Pageable::insert([
        	'page_id' => '1',
        	'pageable_id' => '1',
        	'pageable_type' => 'Thorazine\Hack\Models\Builders\Text',
        	'drag_order' => '1',
        ]);

        Pageable::insert([
        	'page_id' => '1',
        	'pageable_id' => '1',
        	'pageable_type' => 'Thorazine\Hack\Models\Builders\Wysiwyg',
        	'drag_order' => '2',
        ]);

        Pageable::insert([
        	'page_id' => '1',
        	'pageable_id' => '1',
        	'pageable_type' => 'Thorazine\Hack\Models\Builders\Menu',
        	'drag_order' => '3',
        ]);

        Text::insert([
        	'template_sibling' => null,
        	'key' => 'title_2',
        	'label' => 'Title 2',
        	'value' => 'About me',
        	'default_value' => '',
        	'create_regex' => '',
        	'edit_regex' => '',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Text::insert([
        	'template_sibling' => 1,
        	'key' => 'title_2',
        	'label' => 'Title 2',
        	'value' => '',
        	'default_value' => '',
        	'create_regex' => '',
        	'edit_regex' => '',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Wysiwyg::insert([
        	'template_sibling' => null,
        	'key' => 'body_2',
        	'label' => 'Body 2',
        	'value' => '<p style="text-align: center;">Just another programmer doing his thing.&nbsp;</p>
				<p style="text-align: center;">And that is all I have to say about that.</p>',
        	'configuration' => 'full',
        	'default_value' => '',
        	'create_regex' => '',
        	'edit_regex' => '',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Wysiwyg::insert([
        	'template_sibling' => 1,
        	'key' => 'body_2',
        	'label' => 'Body 2',
        	'value' => '',
        	'configuration' => 'full',
        	'default_value' => '',
        	'create_regex' => '',
        	'edit_regex' => '',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        MenuBuilder::insert([
        	'template_sibling' => null,
        	'key' => 'main_menu',
        	'label' => 'Main menu',
        	'value' => '1',
        	'default_value' => '',
        	'create_regex' => '',
        	'edit_regex' => '',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        MenuBuilder::insert([
        	'template_sibling' => 1,
        	'key' => 'main_menu',
        	'label' => 'Main menu',
        	'value' => '1',
        	'default_value' => '',
        	'create_regex' => '',
        	'edit_regex' => '',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Menu::insert([
        	'site_id' => '1',
        	'max_levels' => '1',
        	'Title' => 'Main menu',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        MenuItem::insert([
        	'menu_id' => '1',
        	'page_id' => '1',
        	'Title' => 'Home',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        MenuItem::insert([
        	'menu_id' => '1',
        	'page_id' => '2',
        	'Title' => 'Simple page',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        MenuItem::insert([
        	'menu_id' => '1',
        	'page_id' => '3',
        	'Title' => 'Search',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
