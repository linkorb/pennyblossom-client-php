<?php

require_once(__DIR__.'/../vendor/autoload.php');

use Pennyblossom\Client\Client;
use Pennyblossom\Client\Model\Order;
use Pennyblossom\Client\Model\Address;
use Pennyblossom\Client\Model\ProductModel;

// construct the order
$order = new Order();
$order->setEmail('posinga@example.com')
    ->setCustomerKey('387348r873-34-9326-de4feef925bd')
    ->setPricelistKey('ddsdfgsd4-a4fd-4ddfe411-2e2d81681aec')
    ->setPaymentMethodCode('CASH')
    ->setVatNumber('1500')
    ->setNote('test order');

// set addresses
// do the same for shipping address
$address = new Address('billing');
$address->setCompany('linkorb')
    ->setFullname('hongliang')
    ->setAddressLine('ooooo')
    ->setPostalCode('5611AA')
    ->setCity('eindhoven')
    ->setCountry('netherlands');
$order->addAddress($address);

// add product models, can be multiple models
$model = new ProductModel();
$model->setCode('1091-003')->setQuantity(1);
$order->addProductModel($model);

// create the order
$client = new Client();
$res = $client->createOrder($order);

// $result is a JSON of feedback
// here is an exmpla how to parse the result
if ($res === false) {
    echo '<error>Unknown error</error>';
} else {
    $res = json_decode($res, true);
    if ($res['success']) {
        echo '<info>'.$res['status_message'].'</info>';
        echo '<info>Order key: '.$res['order']['key'].'</info>';
    } else {
        echo '<error>'.$res['status_message'].'</error>';
    }
}
