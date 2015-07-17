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

// construct the order information array
$data = [];

// create the order
$client = new Client();
$client->create($data);

```
### Create order via command line
```
# data is a JSON of order information array
 bin/pennyblossom order:create --data={"vat_number": "123456789", ...}
```
### Order information array construction
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
