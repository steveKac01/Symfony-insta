<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:add-admin',
    description: 'Create a user with ROLE_ADMIN.',
)]
class AddAdminCommand extends Command
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
       parent::__construct();
        $this->manager = $manager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('pseudo', InputArgument::OPTIONAL, 'Pseudo of the user')
            ->addArgument('email', InputArgument::OPTIONAL, 'Email of the user')
            ->addArgument('password', InputArgument::OPTIONAL, 'Password of the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $io = new SymfonyStyle($input, $output);
        $pseudo = $input->getArgument('pseudo');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        if(!$pseudo)
        {
            $question = new Question('Enter the pseudo of the new administrator :');
            $pseudo = $helper->ask($input, $output, $question);
        }

        if(!$email)
        {
            $question = new Question('Enter the email of the new user :');
            $email = $helper->ask($input, $output, $question);
        }
        if(!$password)
        {
            $question = new Question('Enter the password of the new user :');
            $password = $helper->ask($input, $output, $question);
        }

        if ($pseudo && $email && $password) {
            $user = (new User())
                ->setpseudo($pseudo)
                ->setEmail($email)
                ->setPlainPassword($password)
                ->setRoles(['ROLE_ADMIN']);

            $this->manager->persist($user);
            $this->manager->flush();
        }

        $io->success('New admin successfully created ! ' . $user->getEmail());

        return Command::SUCCESS;
    }
}
