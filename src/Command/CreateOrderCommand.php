<?php

namespace Pennyblossom\Client\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Pennyblossom\Client\Client;

class CreateOrderCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('order:create')
            ->setDescription('Create an order')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $c = new Client();
        $output->writeln($c->create());
    }
}
