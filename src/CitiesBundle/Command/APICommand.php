<?php
/**
 * Created by PhpStorm.
 * User: Thibaut
 * Date: 11/10/2017
 * Time: 15:35
 */

namespace CitiesBundle\Command;


use GuzzleHttp\Client;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
    protected function callApi($type, $urlApi, $query=array()) {
        $results = array();
        $client = new Client();

        try {
            $guzzle = $client->request($type, $urlApi, $query);

            if ($guzzle->getStatusCode() == 200) {
                $results = json_decode($guzzle->getBody()->getContents());
            }
        } catch (\Exception $e) {
            $this->output->writeln($urlApi);
            $this->output->writeln($e->getMessage());
        }
        return $results;
    }


    protected function getDataCSVFile(InputInterface $input, OutputInterface $ouput, $filename, $serviceCSV)
    {
        $page = $input->hasArgument('page') ? $input->getArgument('page') : 0;
        $limit = $input->hasArgument('package') ? $input->getArgument('package') : 100;
        $delimiter = $input->hasArgument('delimiter') ? $input->getArgument('delimiter') : ';';

        $data = $serviceCSV->convert(true, $filename, $delimiter, $page, $limit);
        return $data;
    }

    protected function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}