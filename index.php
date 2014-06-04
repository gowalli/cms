<?php

require('cms-init.php');

// Load the site
$site = Site::fetch(array('domain' => $_SERVER['HTTP_HOST']));

// Load site options
$options = Site_Option::fetchArray(array('site_id' => $site->site_id));

$site_options = array();
foreach($options as $option) {
	$site_options[$option->option_name] = $option->option_value;
}

// Load the theme
$theme = Theme::fetch(array('theme_id' => $site_options['theme_id']));
$theme_dir = THEME_DIR . "{$theme->theme_slug}/";
$theme->load($theme_dir . 'theme.conf');

// Load the page we're on from the URL we're on
$page = Page::load();

// Start setting up our rendering engine
$options = array('extension' => '.html');
$m = new Mustache_Engine(array(
	'loader' => new Mustache_Loader_FilesystemLoader($theme_dir . 'pages', $options),
	'partials_loader' => new Mustache_Loader_FilesystemLoader($theme_dir . 'partials', $options)
));

// If the page doens't exist, throw an error page
if(!is_object($page)) {
	echo $m->render('error');
	die;
}

// Start setting up some of the page variables
$vars = array();
$vars['page_title'] = $page->page_title;
$vars['site_title'] = $site->site_name;

// Maybe load the user?
$user = User::maybe_load_user();
$vars['is_admin'] = is_object($user) ? true : false;

// Set the theme directory to something publicly accessible
$url = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$vars['theme_dir'] = str_replace(dirname(__FILE__), $url, $theme_dir);

// Load the page's content sections
$content = new Content;
$page_content = $content->load_page_content($page->page_id);
foreach($page_content as $var => $item) {
	$vars[$var] = $item->content_html;
}

// Load the page we're supposed to load
$code = $m->render($page->page_template, $vars);

// Insert our admin code if we need to
$position = stripos($code, "</body");

if($vars['is_admin'])
	$code = substr_replace($code, "<script src=\"//www.gowalli.com/js/admin.js\"></script>\n", $position, 0);

echo $code;
