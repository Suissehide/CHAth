<?php

namespace App\Command;

use App\Entity\Participant;
use App\Entity\Suivi;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddSuiviCommand extends Command
{
    protected static $defaultName = 'app:add-suivi';

    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Add "Suivi"');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $participants = $this->em->getRepository(Participant::class)->findAll();
        foreach($participants as $participant) {
            $suivi = new Suivi();

            $participant->setSuivi($suivi);

            $this->em->flush();
        }

        $io->success('All "Suivi" added');

        return 0;
    }
}