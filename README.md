# PHP Validate Credit Card

[![Packagist](https://img.shields.io/packagist/v/r4kib/validate-credit-card.svg)]()
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Validates popular debit and credit cards numbers against regular expressions and Luhn algorithm. Also validates the CVC and the expiration date. Comes with minimal validation rules for Laravel

## Disclaimer
All the codes here come form 2 repository-
* https://github.com/rap2hpoutre/laravel-credit-card-validator/
* https://github.com/inacho/php-credit-card-validator/

They should meet you requirements. I had to make this package to solve some very specific requirements.

## Install
Install via composer
```
composer require r4kib/validate-credit-card
```
Add Service Provider to `config/app.php` in `providers` section
```php
R4kib\ValidateCreditCard\ServiceProvider::class,
```

## PHP Usage

### Validate a card number knowing the type:

```php
$card = CreditCard::validCreditCard('5500005555555559', 'mastercard');
print_r($card);
```

Output:

```
Array
(
    [valid] => 1
    [number] => 5500005555555559
    [type] => mastercard
)
```

### Validate a card number and return the type:

```php
$card = CreditCard::validCreditCard('371449635398431');
print_r($card);
```

Output:

```
Array
(
    [valid] => 1
    [number] => 371449635398431
    [type] => amex
)
```

### Validate the CVC

```php
$validCvc = CreditCard::validCvc('234', 'visa');
var_dump($validCvc);
```

Output:

```
bool(true)
```

### Validate the expiration date

```php
$validDate = CreditCard::validDate('2013', '07'); // past date
var_dump($validDate);
```

Output:

```
bool(false)
```

## Laravel Usage 

Add this to your validation rules:

```php
// Add this in your controller method
$this->validate($request, [
    'credit-card-number' => 'required|ccn',
    'credit-card-date' => 'required|ccd',
    'credit-validation-code' => 'required|cvc',
]);
```

## Tests
Execute the following command to run the unit tests:``vendor/bin/phpunit``

