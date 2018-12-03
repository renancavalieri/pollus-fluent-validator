<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Pollus\Validator\Validator;
use Pollus\Validator\Languages\BrazilianPortuguese;
use Pollus\Validator\Exceptions\ValidationException;

final class IntValidatorTest extends TestCase
{
    protected function mock() : Validator
    {
        return new Validator(new BrazilianPortuguese());
    }
    
    public function testValidationRules() : void
    {
        $validator = $this->mock();
 
        $idade = $validator->newInteger('idade', "A idade", 15)->between(10, 20);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->between(5, 10);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->between(5, -40);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->equal(15);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->equal(16);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->even();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->odd();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->higher(10);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->higher(20);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->higher(15);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->higherEqual(15);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->higherEqual(14);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->higherEqual(16);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->in(10, 20, 30);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->in(7, 9, 8 ,5, 15);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->in();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->lower(15);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->lower(16);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->lower(14);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->lowerEqual(15);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->lowerEqual(16);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->lowerEqual(14);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->max(10);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->max(20);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->min(20);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->min(10);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->negative();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->positive();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->notBetween(10, 20);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->notBetween(16, 20);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->notBetween(15, 20);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->notEqual(10);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->notEqual(15);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->notIn(10, 20, 30);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->notIn(10, 15, 30);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
    }
    
    public function testChainMethods()
    {
        $validator = $this->mock();
        
        $idade = $validator->newInteger('idade', 'A idade', 15)
                ->between(10, 25)
                ->odd()
                ->in(10, 15, 30)
                ->positive()
                ->notEqual(20);
        
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->between(10, 25)
                ->even()
                ->in(10, 15, 30)
                ->negative()
                ->notEqual(20);
        
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
    }
    
    public function testNullable()
    {
        $validator = $this->mock();
        
        $idade = $validator->newInteger('idade', 'A idade', null);
        
        $idade->required();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->required(false);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
    }
    
    public function testNullableChain()
    {
        $validator = $this->mock();
        
        $idade = $validator->newInteger('idade', 'A idade', null);
        
        $idade->required()
                ->min(10);
        
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $idade->required(false)
                ->min(10);
        
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
    }
}