<?php

namespace CitiesBundle\Command;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Class FillDataBaseCommand
 * @package CitiesBundle\Command
 */
class FillDataBaseCommand extends ContainerAwareCommand
{

    use APICommand;

    const URL_API = "https://geo.api.gouv.fr/";
    const REPONSE_OK = 200;

    private $input;
    private $output;

    public function init(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    protected function configure()
    {
        $this
            ->setName('filldata:fillgeodata')
            ->setDescription('fill the database of region, departement and commune')
            ->addOption('region','r', InputOption::VALUE_OPTIONAL, 'Saisir les regions a recuperer')
            ->addOption('departement', 'd', InputOption::VALUE_OPTIONAL, "recuperation des departements")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $regionService = $this->getApplication()->getKernel()->getContainer()->get('cities.region');
        $dptService = $this->getApplication()->getKernel()->getContainer()->get('cities.departement');

        if ($option = $input->getOption('region')) {
            foreach ($this->getRegionsByName($option) as $region) {
                $output->writeln('Ajout de la region '.$region->nom);
                $regionService->addRegionDataBase($region);
                $departements = $this->getDepartementsFromRegion($region->code);
                foreach($departements as $departement) {
                    $output->writeln('Ajout du departement '.$departement->nom);
                    $dptService->addDepartementDataBase($departement);
                }
            }
        } elseif ($option = $input->getOption('departement')) {
            $this->addDataByDepartementCode($option);
        }

        $output->writeln('Intégration dans la base de donnée terminé');
    }

    protected function addDataByDepartementCode($code)
    {
        $dptService = $this->getApplication()->getKernel()->getContainer()->get('cities.departement');

        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            "Par quel critère recherchez vous le departement?",
            array(
                "code",
                "nom"
            ),
            "nom"
        );
        $critere = $helper->ask($this->input, $this->input, $question);
        $departements = $this->callApi("GET", self::URL_API."departements", array('query' => array($critere => $option)));
        foreach($departements as $departement) {
            $dptService->addDepartementDataBase($departement);
        }
    }

    /**
     * Return 0..n regions by a name
     * @param $option
     * @return array|mixed
     */
    protected function getRegionsByName($option) {
        return $this->callApi(
            "GET",
            self::URL_API."regions",
            array(
                'query' => array('nom' => $option)
            )
        );
    }

    /**
     * Return 0..n departements by a region code
     * @param $code
     * @return array|mixed
     */
    protected function getDepartementsFromRegion($code) {
        return $this->callApi(
            "GET",
            self::URL_API."regions/$code/departements"
        );
    }

}
