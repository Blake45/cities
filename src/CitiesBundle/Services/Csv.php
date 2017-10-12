<?php

namespace CitiesBundle\Services;


class Csv
{
    public function convert($bypack=false, $filename, $delimiter = ',', $page=0, $limit=100)
    {
        if(!file_exists($filename) || !is_readable($filename)) {
            return FALSE;
        }

        $header = NULL;
        $data = array();

        if (($handle = fopen($filename, 'r')) !== FALSE) {
            $numero_ligne = 0;
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if(!$header) {
                    $header = $row;
                } else {
                    /** Recupere une partie des donneés du csv, todo cependant parcourt le fichier en entier, à améliorer */
                    if ($bypack) {
                        $offset = $page * $limit;
                        $endpack = $limit + $offset;
                        if ($numero_ligne >= $offset && $numero_ligne < $endpack) {
                            $data[] = array_combine($header, $row);
                        }
                    /** recupération des données de la ligne, recupération entiere du fichier */
                    } else {
                        $data[] = array_combine($header, $row);
                    }
                    $numero_ligne++;
                }
            }
            fclose($handle);
        }
        return $data;
    }

}