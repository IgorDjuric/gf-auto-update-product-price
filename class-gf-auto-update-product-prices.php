<?php

class gfAutoUpdateProductPrice
{
    protected function getCsvFile()
    {
        $file = $_FILES['automatskiCenovnikFile']['tmp_name'];
        $contents = file_get_contents($file);
        $fields = explode(PHP_EOL, $contents);

        return $fields;
    }

    public function updateProductPrice()
    {
        global $wpdb;
        $fields = $this->getCsvFile();
        foreach ($fields as $field) {
            $data = explode(',', $field);
            $sku = $data[0];
            $product_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku));
            if ($product_id) {
                $product = new WC_Product($product_id);
                update_post_meta($product_id, 'input_price', $data[1]);
                $product->set_sale_price($data[2]);
                $product->set_regular_price($data[3]);

                /*TODO proveriti za status */
                $product->set_status($data[4]);

                $product->save();
                wp_update_post(array(
                    'ID' => $product_id,
                    'post_status' => 'publish'
                ));
            }
        }
    }
}