<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Question\Question;

class CreateNewUserCommand extends Command
{
    protected static $defaultName = 'CreateNewUser';
    private $manager;
    private $logger;


    public function __construct(EntityManagerInterface $manager, LoggerInterface $logger)
    {
        parent::__construct();
        $this->manager = $manager;
        $this->logger = $logger;
    }

    protected function configure()
    {
        $this
            ->setDescription('CreateNewUser Will Generate New User For You')
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');
        $q1 = new Question('Please enter the Name of User ?');
        $io->newLine();
        $UserName = $helper->ask($input, $output, $q1);
        $io->newLine();
        $q2 = new Question('Please enter the Email of User ?');

        $io->newLine();
        $UserEmail = $helper->ask($input, $output, $q2);
        $io->newLine();
        $q3 = new Question('Please set the User password?');
        $io->newLine();
        $q3->setHidden(true);
        $q3->setHiddenFallback(false);
        $UserPassword = $helper->ask($input, $output, $q3);
        $io->newLine();
        $new_user = new User();
        $new_user->setName($UserName)
            ->setEmail($UserEmail)
            ->setPassword($UserPassword)
            ->setCreatedat(new \DateTime('now'));
        $this->manager->persist($new_user);
        $this->manager->flush();
        //$this->manager->persist()
        $io->success('User has been Added Successfully');
    }
}
