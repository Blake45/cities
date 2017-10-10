<?php

namespace CitiesBundle\Command;

use CitiesBundle\Entity\Ville;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FillCityCommand extends ContainerAwareCommand
{

    const URL_API = "https://geo.api.gouv.fr/";
    const REPONSE_OK = 200;

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
            ->setName('filldata:fillcities')
            ->setDescription('rempli la table ville à l\'aide de l\'API gouv geo')
            ->addArgument("package", InputArgument::REQUIRED, "Nombre de departement traité")
            ->addArgument("page", InputArgument::REQUIRED, "Numéro de page")
            ->addOption("restart", null, InputOption::VALUE_NONE | InputOption::VALUE_OPTIONAL, "restart the command")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->init($input, $output);

        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $departementRepo = $em->getRepository('CitiesBundle:Departement');
        $villeService = $this->getApplication()->getKernel()->getContainer()->get('cities.ville');

        $offset = $this->page * $this->package;

        foreach ($departementRepo->getAllBypackage($this->package, $offset) as $departement) {
            $output->writeln('Intégration des villes du departement '.$departement->getName());
            $communes = $this->callApi("GET", self::URL_API."departements/".$departement->getCode()."/communes", array("fields" => "nom,code,codesPostaux,population"));
            foreach($communes as $commune) {
                try {
                    $output->writeln('Ajout ville ' . $commune->nom);
                    $villeService->addVilleDataBase($commune, $departement);
                } catch (\Exception $e) {
                    $this->output->writeln($e->getMessage());
                }
            }
        }

        $output->writeln('Intégration des villes terminées, pas de longitude et latitude');

        if ($input->getOption("restart") && ($this->page+1) * $this->package < $departementRepo->getCount()) {
            $output->writeln('Page '.($this->page+1).' en cours de traitement');
            $this->restartCommand();
        }
    }

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

            if ($guzzle->getStatusCode() == self::REPONSE_OK) {
                $results = json_decode($guzzle->getBody()->getContents());
            }
        } catch (ClientException $e) {
            $this->output->writeln($e->getMessage());
        }
        return $results;
    }

    public function restartCommand()
    {
        $this->output->writeln('Restarting');

        $this->page = $this->page + 1;

        $command = $this->getApplication()->find('filldata:fillcities');
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
