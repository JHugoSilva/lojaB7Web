<?php
namespace Models;
use Core\Model;

class Filters extends Model{

    public function getFilters($filters) {
        $brands = new Brands();
        $products = new Products();

        $array = [
            'brands' => [],
            'maxslider' => 1000,
            'stars' => [
                '0' => 0,
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0,
                '5' => 0,
            ],
            'sale' => false,
            'options' => []
        ];

        $array['brands'] = $brands->getList();
        $brand_products = $products->getListOfBrands($filters);

        foreach ($array['brands'] as $bkey => $bitem) {
            $array['brands'][$bkey]['count'] = '0';
            foreach ($brand_products as $bproduct) {
                if ($bproduct['id_brand'] == $bitem['id']) {
                    $array['brands'][$bkey]['count'] = $bproduct['c'];
                }
            }

            if ($array['brands'][$bkey]['count'] == '0') {
                unset($array['brands'][$bkey]);
            }
        }

        $array['maxslider'] = $products->getMaxPrice($filters);

        $star_products = $products->getListOfStars($filters);

        foreach ($array['stars'] as $skey => $sitem) {
            foreach ($star_products as $sproduct) {
                if ($sproduct['rating'] == $skey) {
                    $array['stars'][$skey] = $sproduct['c'];
                }
            }
        }

        $array['sale'] = $products->getSaleCount($filters);

        $array['options'] = $products->getAvailableOptions($filters);

        return $array;
    }
}