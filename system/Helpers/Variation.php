<?php

namespace Ciaompe\Helpers;

class Variation {

	public static function build($set)
    {
        if (!$set) {
            return array(array());
        }
        $subset = array_shift($set);
        $cartesianSubset = self::build($set);
        $result = array();

        foreach ($subset as $value) {
            foreach ($cartesianSubset as $p) {
                array_unshift($p, $value);
                $result[] = $p;
            }
        }

        return $result;
    }

    public static function generate_combinations($set)
    {
        $attributes = [];

        foreach($set as $att) {
            $att_meta = unserialize($att['meta']);

            $fields = [];

            foreach($att_meta as $meta) {
                list($first, $last) = explode("-", $meta);
                $fields[][$first] = $last;
            }

            $attributes[] = [
                'id' => $att['id'],
                'fields' =>  $fields,
                'price' => $att['price'],
                'quantity' => $att['quantity'],
                'default' => $att['default'],
            ];
        }

        return $attributes;
    }

    public static function generate_attributes($set)
    {
        $fields = [];
        foreach($set as $att) {
            foreach ($att['fields'] as $item) {
                $field = key($item);
                $value = current($item);
                if(!isset($fields[$field])) {
                    $fields[$field] = array();
                }
                if(!in_array($value,  $fields[$field])) {
                    $fields[$field][] = $value;
                }
            }
        }

        return $fields;
    }
	
}
