<?php
namespace R4kib\ValidateCreditCard;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('ccn', function($attribute, $value, $parameters, $validator) {
            return CreditCard::validCreditCard($value)['valid'];
        });

        Validator::extend('ccd', function($attribute, $value, $parameters, $validator) {
            if (
                !is_string($value) ||
                !preg_match('/^(0?[1-9]|1[0-2])\/(\d{2}|\d{4})$/', $value, $matches)
            ) {

                return false;
            }

            $year = strlen($matches[2]) === 2 ? '20' . $matches[2] : $matches[2];
            return CreditCard::validDate($year, $matches[1]);
        });

        Validator::extend('cvc', function($attribute, $value, $parameters, $validator) {
            return ctype_digit((string) $value) && (strlen((string) $value) == 3 || strlen((string) $value) == 4);
        });
    }
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // 
    }
}
