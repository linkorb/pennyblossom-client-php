<?php

namespace Pennyblossom\Client\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Pennyblossom\Client\Client;
use Symfony\Component\Yaml\Parser as YamlParser;

class CreateOrderCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('order:create')
            ->setDescription('Create an order')
            ->addOption(
                'filename',
                null,
                InputOption::VALUE_REQUIRED,
                'Load data from example file'
            )
            ->addOption(
                'data',
                null,
                InputOption::VALUE_REQUIRED,
                'Order data'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = $input->getOption('data');
        if ($input->getOption('filename')) {
            $data = $this->loadFromExampleFile($input->getOption('filename'));
        }
        $c = new Client();
        $output->writeln($c->create($data));
    }

    private function loadFromExampleFile($fileName)
    {
        $parser = new YamlParser();
        $data = $parser->parse(file_get_contents(__DIR__.'/../../example/'.$fileName.'.yml'));
        $data['debug'] = true;

        return $data;
    }

    private function loadFromArray($array = null)
    {
        if ($array === null) {
            $array = [
                'email' => 'h.wang@linkorb.com',
                'vat_number' => '893764837042',
                'address' => [
                    'billing' => [
                        'company' => 'LinkORB',
                        'fullname' => 'Hongliang',
                        'address' => 'Kerkstraat 4a',
                        'postalcode' => '5658 BC',
                        'city' => 'Oirschot',
                    ],
                    'shipping' => [
                        'company' => 'LinkORB',
                        'fullname' => 'Hongliang',
                        'address' => 'Kerkstraat 4a',
                        'postalcode' => '5658 BC',
                        'city' => 'Oirschot',
                    ],
                ],
            ];
        }

        return $array;
    }
}
