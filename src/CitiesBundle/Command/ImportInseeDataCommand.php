<?php

namespace CitiesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportInseeDataCommand extends ContainerAwareCommand
{
    use APICommand;

    protected function configure()
    {
        $this
            ->setName('filldata:importinseedata')
            ->setDescription('Import de fichier de la base insee excel, csv sur le chomage, démographie, criminalité')
            ->addArgument('type', InputArgument::REQUIRED, 'type de fichier xml, csv, json, excel')
            ->addArgument('file', InputArgument::REQUIRED, 'fichier à intégrer')
            ->addArgument('typedata', InputArgument::REQUIRED, 'chomage, demopgraphie etc...')
            ->addOption('entity', null, InputOption::VALUE_REQUIRED, 'Ville, region departement')
            ->addArgument('bypack', InputArgument::OPTIONAL, 'partition des données csv')
            ->addArgument('package', InputArgument::OPTIONAL, 'nombre de elements traités')
            ->addArgument('page', InputArgument::OPTIONAL, 'numero de page')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $time_start = $this->microtime_float();
        $io = new SymfonyStyle($input, $output);
        $io->caution("Vous allez intégrer un flux dans la base de données");

        $container = $this->getContainer();

        $data = $this->getDataCSVFile($input, $output, $input->getArgument('file'), $container->get('cities.general.csv'), ',');
        $stats_service = $container->get('cities.stats');

        switch ($input->getArgument('typedata')) {
            case 'chomage':
                $this->integrateChomage($io, $data, $stats_service, $input->getOption('entity'));
            break;
            case 'politique':
                $this->integratePolitique($io, $data, $stats_service, $input->getOption('entity'));
            break;
            default:
                throw new Exception("Mais cela n'a aucun sens, voyons! ".$input->getArgument('typedata').", nimp!! ");
            break;
        }

        $time_end = $this->microtime_float();
        $time = $time_end - $time_start;
        $io->section("End : " . $time . " secondes");
        $io->caution("Et voila, l'intégration est terminée");
    }

    /**
     * Integration de données relative au taux de chomages
     * @param $io
     * @param $data
     * @param $stats_service
     * @param $typeentity
     */
    private function integrateChomage($io, $data, $stats_service, $typeentity)
    {
        foreach($data as $key => $array) {
            $io->comment("Intégration des données de type chomage");
            $stats_service->addStatsChomage($typeentity, $array);
        }
    }

    private function integratePolitique($io, $data, $stats_service, $typeentity)
    {
        foreach($data as $key => $array) {
            $io->comment("Intégration des données de type politique");
            $stats_service->addStatsPolitique($typeentity, $array);
        }
    }

}
