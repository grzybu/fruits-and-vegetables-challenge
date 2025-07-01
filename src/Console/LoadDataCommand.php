<?php

namespace App\Console;

use App\Service\StorageService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:load-data',
    description: 'A command to load data from a JSON file into the storage service.',
)]
class LoadDataCommand extends Command
{
    public function __construct(protected StorageService $storageService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileName = 'request.json';

        if (!file_exists($fileName)) {
            $output->writeln('<error>File request.json does not exist!</error>');
            return Command::FAILURE;
        }

        $fileContent = file_get_contents($fileName);
        if ($fileContent === false) {
            $output->writeln('<error>Failed to read request.json!</error>');
            return Command::FAILURE;
        }


        $output->writeln('Starting to process request.json...');

        $this->storageService->request = $fileContent;
        $this->storageService->loadData();

        $output->writeln('Command executed successfully!');

        return Command::SUCCESS;
    }
}
