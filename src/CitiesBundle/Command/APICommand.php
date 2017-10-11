<?php
/**
 * Created by PhpStorm.
 * User: Thibaut
 * Date: 11/10/2017
 * Time: 15:35
 */

namespace CitiesBundle\Command;


use GuzzleHttp\Client;

trait APICommand
{

    /**
     * generique function
     * Return response from the API gouv GEO
     * @param $type
     * @param $urlApi
     * @param $query
     * @return array|mixed
     */
    private function callApi($type, $urlApi, $query=array()) {
        $results = array();
        $client = new Client();

        try {
            $guzzle = $client->request($type, $urlApi, $query);

            if ($guzzle->getStatusCode() == 200) {
                $results = json_decode($guzzle->getBody()->getContents());
            }
        } catch (ClientException $e) {
            $this->output->writeln($e->getMessage());
        }
        return $results;
    }
}