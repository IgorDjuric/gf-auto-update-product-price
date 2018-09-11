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

function gf_automatski_cenovnici_options_page()
{ ?>


    <div class="wrap">
        <h2><?= __('Automatski cenovnici') ?></h2>
        <p>1. Izaberite dokument (.CSV) klikom na dugme "Choose File"</p>
        <p>2. Kliknite na dugme "Submit" kako bi izvršili promene</p>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="automatskiCenovnikFile">
            <input type="submit">
        </form>
    </div>

    <?php
    global $wpdb;

    $file = $_FILES['automatskiCenovnikFile']['tmp_name'];
    $contents = file_get_contents($file);
    $fields = explode(PHP_EOL, $contents);
    foreach($fields as $field){
        $data = explode(',', $field);
        $sku = $data[0];
        $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku) );
        if ($product_id){
            $product = new WC_Product( $product_id );
//            $product->set_price($data[1]);
            $product->set_sale_price($data[2]);
            $product->set_regular_price($data[3]);
            $product->set_status($data[4]);
            $product->save();
        }
    }






}