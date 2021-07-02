<?php

namespace App\Command;

use App\Entity\Participant;
use App\Entity\Suivi;
use App\Constant\FormConstants;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddSuiviCommand extends Command
{
    protected static $defaultName = 'app:add-suivi';
    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add "Suivi"')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $em = $this->container->get('doctrine')->getManager();
        $io = new SymfonyStyle($input, $output);

        $participants = $em->getRepository(Participant::class)->findAll();
        foreach($participants as $participant) {
            $suivi = new Suivi();

            $participant->setSuivi($suivi);

            $em->flush();
        }

        $io->success('All "Suivi" added');

        return 0;
    }
}