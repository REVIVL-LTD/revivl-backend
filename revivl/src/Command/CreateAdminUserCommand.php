<?php

namespace App\Command;

use App\Entity\Admin;
use App\Entity\AbstractUser;
use App\Service\ValidateService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use RuntimeException;

class CreateAdminUserCommand extends Command
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $em,
        private ValidateService $validateService
    )
    {
        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setName('app:create:user:admin')
            ->setDescription('New Admin')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $question = new Question('Email (admin@admin.ru):', 'admin@admin.ru');
        $email = $helper->ask($input, $output, $question);
        $this->validateService->validateEmail($email);
        if ($this->em->getRepository(AbstractUser::class)->findOneBy(['email' => $email])) {
            throw new RuntimeException('Email already use');
        }

        $question = new Question('Password (Admin1234@): ', 'Admin1234@');
        $plaintextPassword = $helper->ask($input, $output, $question);
        $this->validateService->passwordValid($plaintextPassword);


        $user = new Admin();
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        ));

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln('<info>Success</info>');
        return Command::SUCCESS;
    }
}
