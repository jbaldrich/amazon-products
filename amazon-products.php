<?php
/**
 * Base Plugin.
 *
 * @package   JacoBaldrich\BasePlugin
 * @author    Jaco Baldrich <hello@jacobaldrich.com>
 * @copyright 2020 Jaco Baldrich
 *
 * @wordpress-plugin
 * Plugin Name:  Amazon Products
 * Description:  A WP plugin to get products from Amazon API.
 * Version:      0.1.0
 * Requires PHP: 7.3
 * Author:       Jaco Baldrich <hello@jacobaldrich.com>
 * Text Domain:  jacobaldrich-amazon-products
 * Domain Path:  /languages
 */

namespace JacoBaldrich\BasePlugin;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$composer_autoloader = __DIR__ . '/vendor/autoload.php';

if ( is_readable ( $composer_autoloader ) ) {
	require $composer_autoloader;
	$plugin = PluginFactory::create();
	$plugin->register();
}
