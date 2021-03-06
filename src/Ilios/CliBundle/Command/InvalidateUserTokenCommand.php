<?php

namespace Ilios\CliBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use \DateTime;

use Ilios\CoreBundle\Entity\Manager\AuthenticationManagerInterface;
use Ilios\CoreBundle\Entity\Manager\UserManagerInterface;

/**
 * Invalidate all user tokens issued before now
 *
 * Class InvalidateUserTokenCommand
 * @package Ilios\CliBUndle\Command
 */
class InvalidateUserTokenCommand extends Command
{
    /**
     * @var UserManagerInterface
     */
    protected $userManager;
    
    /**
     * @var AuthenticationManagerInterface
     */
    protected $authenticationManager;
    
    public function __construct(
        UserManagerInterface $userManager,
        AuthenticationManagerInterface $authenticationManager
    ) {
        $this->userManager = $userManager;
        $this->authenticationManager = $authenticationManager;
        
        parent::__construct();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('ilios:setup:invalidate-user-tokens')
            ->setDescription('Invalidate all user tokens issued before now.')
            ->addArgument(
                'userId',
                InputArgument::REQUIRED,
                'A valid user id.'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new DateTime();
        $userId = $input->getArgument('userId');
        $user = $this->userManager->findUserBy(['id' => $userId]);
        if (!$user) {
            throw new \Exception(
                "No user with id #{$userId} was found."
            );
        }
        
        $authentication = $user->getAuthentication();
        if (!$authentication) {
            $authentication = $this->authenticationManager->createAuthentication();
            $authentication->setUser($user);
        }
        
        $authentication->setInvalidateTokenIssuedBefore($now);
        $this->authenticationManager->updateAuthentication($authentication);

        $output->writeln('Success!');
        $output->writeln(
            'All the tokens for ' . $user->getFirstAndLastName() .
            ' issued before Today at ' . $now->format('g:i:s A e') .
            ' have been invalidated.'
        );
    }
}
