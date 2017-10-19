<?php

namespace CitiesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class DeleteAvisCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('filldata:deleteavis')
            ->setDescription('efface les avis par id ou tout les avis')
            ->addArgument('ids', InputArgument::IS_ARRAY, 'les id des avis à effacer')
            ->addOption('all', null, InputOption::VALUE_NONE, 'Effacer tous les avis déposés')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ids = $input->getArgument('ids');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion("Vous vous appretez à effacer ces avis ".implode(':', $ids).", voulez vous continuer?", false);

        $container = $this->getContainer();
        $service = $container->get('cities.handle.avis');

        if ($helper->ask($input, $output, $question)) {
            $output->writeln("Suppression des avis passés en paramètres");
            $service->deleteAvis($ids, $input->getOption('all'));
        }
        $output->writeln("Traitement terminé");
    }

}
