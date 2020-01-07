<?php

namespace App\Command;

use App\Entity\Participant;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateParticipantAgeCommand extends Command
{
    protected static $defaultName = 'app:update-participant-age';
    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Update all participants\' age')
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
            $date_naissance = $participant->getGeneral()->getDateNaissance()->format('m/Y');
            $am = explode('/', $date_naissance);
            $an = explode('/', date('m/Y'));
            if ($am[0] < $an[0]) $participant->getGeneral()->setAge($an[1] - $am[1]);
            else $participant->getGeneral()->setAge($an[1] - $am[1] - 1);
            $em->flush();
        }

        $io->success('Update of participants\' age completed.');

        return 0;
    }
}
