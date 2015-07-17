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
        if ($input->getOption('filename')) {
            $data = $this->loadFromExampleFile($input->getOption('filename'));
        } else {
            $data = $input->getOption('data');
            $data = json_decode($data);
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
                'customer_key' => '81977',
                'pricelist_key' => '99b0380f-c644-43eb-bc53-978cd30093c5',
                'payment_method_code' => 'POS-PIN',
                'email' => 'h.wang@linkorb.com',
                'vat_number' => '893764837042',
                'note' => 'This is a test order',
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
                'product_model' => [
                    ['code' => '3269-001', 'quantity' => 2],
                    ['code' => '3285-001', 'quantity' => 1],
                ],
            ];
        }

        return $array;
    }
}
