<?php

namespace App\Command;

use App\Entity\Participant;
use App\Entity\Gene;
use App\Constant\FormConstants;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateGenesCommand extends Command
{
    protected static $defaultName = 'app:update-genes';
    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Update all genes')
            // ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $em = $this->container->get('doctrine')->getManager();
        $io = new SymfonyStyle($input, $output);
        // $arg1 = $input->getArgument('arg1');

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //    
        // }

        $participants = $em->getRepository(Participant::class)->findAll();
        foreach($participants as $participant) {

            $donnee = $participant->getDonnee();
            $genes = $donnee->getGenes();
            foreach ($genes as $g) {
                $donnee->removeGene($g);
            }
            foreach (FormConstants::GENES as $name) {
                $gene = new Gene();
                $gene->setStatut("Non muté");
                $gene->setNom($name);
                $donnee->addGene($gene);
            }

            $em->flush();
        }



        $io->success('Update of genes completed.');

        return 0;
    }
}