<?php

namespace CitiesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BuildslugsCommand extends ContainerAwareCommand
{

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
            ->setName('filldata:buildslugs')
            ->setDescription("Construction du slug d'un departement(s), region(s)")
            /*->addArgument('terme', InputArgument::OPTIONAL, 'Nom region ou departement')*/
            ->addOption('allregions', null, InputOption::VALUE_NONE, 'Construit les slugs de toutes les regions')
            ->addOption('alldepartements', null, InputOption::VALUE_NONE, 'Construit les slugs de toutes les departements')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->init($input, $output);

        $regionService = $this->getApplication()->getKernel()->getContainer()->get('cities.region');
        $dptService = $this->getApplication()->getKernel()->getContainer()->get('cities.departement');

        if ($input->getOption('allregions')) {
            $output->writeln("Building slugs for regions");
            $regionService->buildSlugsRegions();
        } elseif ($input->getOption('alldepartements')) {
            $output->writeln("Building slugs for departements");
            $dptService->buildSlugsDepartements();
        }
    }

}
