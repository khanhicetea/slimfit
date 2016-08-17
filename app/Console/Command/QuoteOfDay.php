<?php
namespace App\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QuoteOfDay extends Command {
    protected function configure()
    {
        $this
            ->setName('qod')
            ->setDescription('Quote of the day');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $raw_json = file_get_contents('http://api.theysaidso.com/qod.json');
        $data = json_decode($raw_json, true);
        $quote = $data['contents']['quotes'][0];
        $output->writeln(sprintf('%s -- %s --', $quote['quote'], $quote['author']));
    }
}
