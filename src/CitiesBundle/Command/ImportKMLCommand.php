<?php

namespace CitiesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportKMLCommand extends ContainerAwareCommand
{
    use APICommand;

    protected function configure()
    {
        $this
            ->setName('filldata:importKml')
            ->setDescription('import de données gps pour dessiner des zones, trajets, import en base de données')
            ->addArgument('kml', InputArgument::REQUIRED, 'fichier kml à importer')
            ->addOption('type_zone', null, InputOption::VALUE_REQUIRED, 'Type de zone: Region , Departement, Ville etc...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $file = $input->getArgument('kml');
        $xmlService = $container->get('cities.general.xml');

        switch($input->getOption('type_zone')) {
            case 'region':
                $xmlService->saveRegionGPS($file, $output);
            break;
            default:break;
        }
    }

}
