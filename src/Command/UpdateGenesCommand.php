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

            ->addArgument('name', InputArgument::REQUIRED, '')
            ->addArgument('new', InputArgument::OPTIONAL, '')

            ->addOption('add', null, InputOption::VALUE_OPTIONAL, 'Add the gene?', false)
            ->addOption('delete', null, InputOption::VALUE_OPTIONAL, 'Delete the gene?', false)
            ->addOption('update', null, InputOption::VALUE_OPTIONAL, 'Change the gene name?', false)
            ->addOption('special', null, InputOption::VALUE_OPTIONAL, 'Change the 2nd gene name?', false)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $em = $this->container->get('doctrine')->getManager();
        $io = new SymfonyStyle($input, $output);
        $name = $input->getArgument('name');
        $new = $input->getArgument('new');
        $add = $input->getOption('add');
        $delete = $input->getOption('delete');
        $update = $input->getOption('update');
        $special = $input->getOption('special');

        $participants = $em->getRepository(Participant::class)->findAll();
        foreach($participants as $participant) {
            $donnee = $participant->getDonnee();
            $genes = $donnee->getGenes();

            if ($add === null || $add === true) {
                $gene = new Gene();
                $gene->setStatut("Non muté");
                $gene->setNom($name);
                $donnee->addGene($gene);
            } elseif ($update === null || $update === true) {
                foreach ($genes as $g) {
                    if ($g->getNom() === $name) {
                        $g->setNom($new);
                    }
                 }
            } elseif ($delete === null || $delete === true) {
                foreach ($genes as $g) {
                    if ($g->getNom() === $name) {
                        $donnee->removeGene($g);
                    }
                }
            } elseif ($special === null || $special === true) {
                $count = 0;
                foreach ($genes as $g) {
                    if ($g->getNom() === $name) {
                        $count += 1;
                        if ($count == 2) $g->setNom($new);
                    }
                }
            }

            $em->flush();
        }



        $io->success('Update of genes completed.');

        return 0;
    }
}