<?php

namespace CitiesBundle\Services;


use CitiesBundle\Entity\Region;
use CitiesBundle\Entity\Stats;
use Colors\RandomColor;

class JsEncode
{
    public function buildZoneCoordinates(Region $region)
    {
        $coordinates = explode(",", $region->getCoordinates());

        $gps = array();
        foreach ($coordinates as $coord) {
            $LatLng = explode(" ", $coord);
            if (reset($coordinates) != $coord && end($coordinates) != $coord) {
                $gps[]= array("lat" => floatval($LatLng[0]), "lng" => floatval($LatLng[1]));
            }
        }
        $gps[] = array("lat" => floatval(end($coordinates)), "lng" => floatval(reset($coordinates)));

        return $gps;
    }


    public function encode($str)
    {
        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', "'"=>" " );
        return strtr( $str, $unwanted_array );
    }


    public function buildDataSetForGraphZone(Stats $stats)
    {
        $datas = $stats->getArrayEconomie();

        $data_set = array();
        $values = array();
        $colors = RandomColor::many(10, array('hue' => 'yellow'));
        $backgroundColors = array();

        foreach ($datas as $label => $data) {
           $data_set['labels'][] = $label;
           $values[] = floatval($data);
           $backgroundColors[] = $colors[rand(1, 9)];
        }
        $data_set['datasets'][] = array('data' => $values, 'backgroundColor' => $backgroundColors);

        return $data_set;
    }

}