<?php
/**
 * Plugin Name
 *
 * @package     PluginPackage
 * @author      Green Friends
 * @copyright   2018 Green Friends
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: GF Automatski cenovnici
 * Plugin URI:  https://example.com/plugin-name
 * Description: Custom product stickers
 * Version:     1.0.0
 * Author:      Green Friends
 * Author URI:  https://example.com
 * Text Domain: gf-automatski-cenovnici
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

load_plugin_textdomain('gf-automatski-cenovnici', '', plugins_url() . '/gf-automatski-cenovnici/languages');

function gf_automatski_cenovnici_options_create_menu()
{
    //create new top-level menu
    add_menu_page('Automatski cenovnici', 'Automatski cenovnici', 'administrator', 'gf_automatski_cenovnici_options', 'gf_automatski_cenovnici_options_page', null, 99);

}

add_action('admin_menu', 'gf_automatski_cenovnici_options_create_menu');

require ('class-gf-auto-update-product-prices.php');

function gf_automatski_cenovnici_options_page()
{
    if (isset($_POST['success-message'])) {
        header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]&message=success");
    }

    require(realpath(__DIR__ . '/gf-form.php'));

    if (isset($_FILES['automatskiCenovnikFile']['tmp_name'])) {
        $update = new gfAutoUpdateProductPrice();
        $update->updateProductPrice();
    }
}