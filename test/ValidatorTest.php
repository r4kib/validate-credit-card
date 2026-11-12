<?php
namespace R4kib\ValidateCreditCard\Test;

use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\TestCase;
use R4kib\ValidateCreditCard\ServiceProvider;

class ValidatorTest extends TestCase
{
    public function testValidatorRules(): void
    {
        $registry = new class {
            public array $rules = [];

            public function extend($name, $callback): void
            {
                $this->rules[$name] = $callback;
            }
        };
        Validator::swap($registry);
        (new ServiceProvider(null))->boot();

        $date = $registry->rules['ccd'];
        $this->assertTrue($date('date', '12/2099', [], null));
        $this->assertTrue($date('date', '12/99', [], null));
        foreach (['12', '12/', '12/ab', '13/2099', '12/2099/1', null] as $value) {
            $this->assertFalse($date('date', $value, [], null));
        }

        $cvc = $registry->rules['cvc'];
        $this->assertTrue($cvc('cvc', 123, [], null));
        $this->assertFalse($cvc('cvc', '12a', [], null));
        Validator::clearResolvedInstance('validator');
    }
}
