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
 
        $idade = $validator->addInteger('idade', "A idade", 15)->between(10, 20);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->between(5, 10);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->between(5, -40);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->equal(15);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->equal(16);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->even();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->odd();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->higher(10);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->higher(20);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->higher(15);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->higherEqual(15);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->higherEqual(14);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->higherEqual(16);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->in(10, 20, 30);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->in(7, 9, 8 ,5, 15);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->in();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->lower(15);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->lower(16);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->lower(14);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->lowerEqual(15);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->lowerEqual(16);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->lowerEqual(14);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->max(10);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->max(20);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->min(20);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->min(10);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->negative();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->positive();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->notBetween(10, 20);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->notBetween(16, 20);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->notBetween(15, 20);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->notEqual(10);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->notEqual(15);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->notIn(10, 20, 30);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->notIn(10, 15, 30);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
    }
    
    public function testChainMethods()
    {
        $validator = $this->mock();
        
        $idade = $validator->addInteger('idade', 'A idade', 15)
                ->between(10, 25)
                ->odd()
                ->in(10, 15, 30)
                ->positive()
                ->notEqual(20);
        
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()
                ->between(10, 25)
                ->even()
                ->in(10, 15, 30)
                ->negative()
                ->notEqual(20);
        
        $this->assertSame(true, $validator->validate(false)->hasErrors());
    }
    
    public function testNullable()
    {
        $validator = $this->mock();
        
        $idade = $validator->addInteger('idade', 'A idade', null);
        
        $idade->required();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()->required(false);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
    }
    
    public function testNullableChain()
    {
        $validator = $this->mock();
        
        $idade = $validator->addInteger('idade', 'A idade', null);
        
        $idade->required()
                ->min(10);
        
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $idade->clearValidationErrors()
                ->required(false)
                ->min(10);
        
        $this->assertSame(false, $validator->validate(false)->hasErrors());
    }
}