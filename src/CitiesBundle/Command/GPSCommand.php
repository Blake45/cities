<?php

namespace CitiesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GPSCommand extends ContainerAwareCommand
{
    use APICommand;

    const URL_API = "https://api-adresse.data.gouv.fr/search";

    private $input;
    private $output;
    private $package;
    private $page;

    public function init(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->package = $input->getArgument('package');
        $this->page = $input->getArgument('page');
    }

    protected function configure()
    {
        $this
            ->setName('filldata:fillgpsdata')
            ->setDescription('Rempli pour chaque ville les coordonnées GPS')
            ->addArgument("file", InputArgument::REQUIRED, "Path du fichier csv à traiter")
            ->addArgument("package", InputArgument::REQUIRED, "Nombre de villes traitées")
            ->addArgument("page", InputArgument::REQUIRED, "Numéro de page")
            ->addOption("restart", null, InputOption::VALUE_NONE | InputOption::VALUE_OPTIONAL, "restart the command")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $this->init($input, $output);

        $time_start = $this->microtime_float();
        $io->section('Start du script pour intégrer les coordonnées GPS des villes de france ');

        $container = $this->getContainer();
        $em = $container->get('doctrine')->getEntityManager();
        $villeRepo = $em->getRepository('CitiesBundle:Ville');

        $data = $this->getDataCSVFile($input, $output, $input->getArgument('file'), $container->get('cities.general.csv'));
        $serviceVille = $container->get('cities.ville');
        foreach ($data as $data_ville) {
            $ville = $villeRepo->findOneBy(array('codeInsee' => $data_ville['code_insee']));
            if (!is_null($ville)) {
                $output->writeln("Intégration des data GPS de la ville ".$ville->getName());
                if ($data_ville['latitude'] == 0 && $data_ville['longitude'] == 0) {
                    $rappel = $this->getGPSDATAByAPI($ville);
                    $data_ville['latitude'] = $rappel['latitude'];
                    $data_ville['longitude'] = $rappel['longitude'];
                }
                $serviceVille->addGPSDataToCity($ville, $data_ville['latitude'], $data_ville['longitude'], false);
            }
        }
        $em->flush();

        $time_end = $this->microtime_float();
        $time = $time_end - $time_start;
        $io->section("End : " . $time . " secondes");
    }

    private function getGPSDATAByAPI($ville)
    {
        $rappel = $this->callApi("GET", self::URL_API."?q=".$ville->getName()."&citycode=".$ville->getCodeInsee()."&limit=1");
        return array(
            'latitude' => $rappel->features[0]->geometry->coordinates[1],
            'longitude' => $rappel->features[0]->geometry->coordinates[0]
        );
    }

    public function restartCommand()
    {
        $this->output->writeln('Restarting');

        $this->page = $this->page + 1;

        $command = $this->getApplication()->find('filldata:fillgpsdata');
        $userInput      = new ArrayInput(
            array(
                'package'=> $this->package,
                'page'=> $this->page,
                '--restart' => true
            )
        );

        $command->run($userInput, $this->output);
    }

}
