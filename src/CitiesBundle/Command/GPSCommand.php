<?php

namespace CitiesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GPSCommand extends ContainerAwareCommand
{
    use APICommand;

    const URL_API = "https://maps.googleapis.com/maps/api/geocode/json?address=Orl%C3%A9ans&key=";

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
            ->addArgument("package", InputArgument::REQUIRED, "Nombre de villes traitées")
            ->addArgument("page", InputArgument::REQUIRED, "Numéro de page")
            ->addOption("restart", null, InputOption::VALUE_NONE | InputOption::VALUE_OPTIONAL, "restart the command")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->init($input, $output);

        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $villeRepo = $em->getRepository('CitiesBundle:Ville');

        $offset = $this->page * $this->package;
        $villes = $villeRepo->getVillePaginated($offset);
        foreach($villes as $ville) {

        }

        $output->writeln('Command result.');
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
