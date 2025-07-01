<?php

namespace App\Console;

use App\Service\StorageService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test-command';

    public function __construct(protected StorageService $storageService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('A test command for demonstration purposes.')
            ->setHelp('This command allows you to test the console functionality.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Executing the test command...');

        $this->storageService->processJson('request.json');

        $output->writeln('Test command executed successfully!');

        return Command::SUCCESS;

    }

}