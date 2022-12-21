<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * This custom command allow us to create an ADMIN user.
 */
#[AsCommand(
    name: 'app:add-admin',
    description: 'Create a user with ROLE_ADMIN.',
)]
class AddAdminCommand extends Command
{
    private EntityManagerInterface $manager;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $manager, ValidatorInterface $validator)
    {
        parent::__construct();
        $this->manager = $manager;
        $this->validator = $validator;
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

        if (!$pseudo) {
            $io->title('[ Adding an administrator ]');
            $question = new Question('Enter the pseudo of the new administrator :');
            $pseudo = $helper->ask($input, $output, $question);
        }

        if (!$email) {

            $question = new Question('Enter the email for ' . $pseudo . ' :');
            $email = $helper->ask($input, $output, $question);
        }
        if (!$password) {
            $io->note([
                'Choose a secure password !',
                'Must be 8 characters long.',
                'At least 1 capital letter',
                'At least 1 special character.'
            ]);
            $question = new Question('Enter the password for ' . $pseudo . ' :');
            $password = $helper->ask($input, $output, $question);
        }

        if ($pseudo && $email && $password) {
            $user = (new User())
                ->setpseudo($pseudo)
                ->setEmail($email)
                ->setPlainPassword($password)
                ->setRoles(['ROLE_ADMIN']);

            //Validate the user data.
            $errors = $this->validator->validate($user);
            if (count($errors) > 0) {
                $io->error((string) $errors);

                return Command::FAILURE;
            } else {
                $this->manager->persist($user);
                $this->manager->flush();
            }
        }

        $io->success('New admin successfully created ! ' . $user->getEmail());

        return Command::SUCCESS;
    }
}
