# webshop-client-php
A PHP client of Pennyblossom.

Connect to the PennyBlossom system from your application.

## Installation
```
componser install
```
## Configuration
Copy the config file example and change the parameters accordingly.
```
cp config.yml.dist config.yml
```
## Creating order
### Create order via the client
```php
<?php

use Pennyblossom\Client\Client;
use Pennyblossom\Client\Model\Order;
use Pennyblossom\Client\Model\Address;
use Pennyblossom\Client\Model\ProductModel;

// construct the order
$order = new Order();
$order->setEmail($email)
    ->setCustomerKey($customer_key)
    ->setPricelistKey($pricelist_key)
    ->setPaymentMethodCode($payment_method_code)
    ->setVatNumber($vat_number)
    ->setNote($note);

// set addresses
// do the same for shipping address
$address = new Address('billing');
$address->setCompany($company)
    ->setFullname($fullname)
    ->setAddressLine($address)
    ->setPostalCode($postalcode)
    ->setCity($city)
    ->setCountry($country);
$order->addAddress($address);

// add product models, can be multiple models
$model = new ProductModel();
$model->setCode($code)->setQuantity($quantity);
$order->addProductModel($model);

// create the order
$client = new Client();
$result = $client->createOrder($order);

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

```
### Create order via command line
```
# data is a JSON of order information array
 bin/pennyblossom order:create --data={"vat_number": "123456789", ...}
```
### Example Order information construction
The order information can be loaded via array or yaml file. Here is an example yaml file.
```yml
customer_key: 81977
pricelist_key: "99b0380f-c644-43eb-bc53-978cd30093c5"
payment_method_code: POS-PIN
email: example@pennyblossom.nl
vat_number: 23456754321
note: "This is a test order"
address:
    billing:
        company: Pennyblossom
        fullname: Penny
        address: Fakestreet 4a
        postalcode: "5656 AA"
        city: Oirschot
    shipping:
        company: Pennyblossom
        fullname: Penny
        address: Fakestreet 14
        postalcode: "5658 BC"
        city: Oirschot
product_model:
    -
        code: "3269-001"
        quantity: 2
    -
        code: "3285-001"
        quantity: 1
```
