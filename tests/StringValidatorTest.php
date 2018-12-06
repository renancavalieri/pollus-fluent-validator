<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Pollus\Validator\Validator;
use Pollus\Validator\Languages\BrazilianPortuguese;
use Pollus\Validator\Exceptions\ValidationException;

final class StringValidatorTest extends TestCase
{
    protected function mock() : Validator
    {
        return new Validator(new BrazilianPortuguese());
    }
    
    public function testValidationRules() : void
    {
        $validator = $this->mock();
 
        $validator->newString('cep', "O CEP", '17930-000')->cep();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('cep', "O CEP", '17930000')->cep();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('cep', "O CEP", '17d930-000')->cep();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $nome = $validator->newString('nome', "O nome", 'Fernando da Silva Pessoa')->lengthBetween(5, 25);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $nome->lengthBetween(25, 40);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $nome->minLength(10);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $nome->minLength(30);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $nome->maxLength(30);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $nome->maxLength(10);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('celular', "O Celular", '18996312354')->mobilePhoneNumber();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();

        $validator->newString('celular', "O Celular", '1838222122')->mobilePhoneNumber();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('celular', "O telefone", '18996312354')->phoneNumber();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('celular', "O telefone", '1838222122')->phoneNumber();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('url', "A url", 'https://www.tecdicas.com/')->url();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('url', "A url", 'http://tecdicas.com')->url();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('url', "A url", '//tecdicas.com')->url();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('url', "A url", 'tecdicas.com')->url();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('url', "A url", 'ftp://tecdicas.com')->url();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        
        $validator->newString('ip', "O endereço IP", '177.77.159.98')->ip()->ipv4();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('ip', "O endereço IP", '177.77.159.98')->ip()->ipv6();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('ip', "O endereço IP", '2001:0db8:85a3:0000:0000:8a2e:0370:7334')->ip()->ipv6();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('ip', "O endereço IP", '2001:0db8:85a3:0000:0000:8a2e:0370:7334')->ip()->ipv4();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('email', "O email", 'renan@tecdicas.com')->email();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('email', "O email", 'renan@@tecdicas.com')->email();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $cor = $validator->newString('cor', "A cor", 'azul')->equal("azul");
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $cor->notEqual('rosa');
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $cor->notEqual('azul');
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $cor->notEqual('vermelho');
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('cpf', "O CPF", '35646991048')->cpf();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('cpf', "O CPF", '11111111111')->cpf();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('cpf', "O CPF", '00000000000')->cpf();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('cpf', "O CPF", '848748748744')->cpf();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('cnpj', "O CNPJ", '82140216000117')->cnpj();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();

        $validator->newString('cnpj', "O CNPJ", '11111111111111')->cnpj();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('cnpj', "O CNPJ", '1234567891234')->cnpj();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('cnpj', "O CNPJ", '3654895178800')->cnpj();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('numero', "O número", '021578')->numeric()->alphaNumeric();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('numero', "O número", '84d8dsc')->numeric();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('numero', "O número", '84d8dsc')->numeric();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('numero', "O número", '84d8dsc')->alpha();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->newString('numero', "O número", 'asdfgh')->alpha();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $frase = $validator->newString('A frase', "O frase", 'Cavalo de Tróia')->contains('Cavalo', "Tróia");
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $frase = $validator->newString('A frase', "O frase", 'Cavalo de Tróia')->contains('Cavalo', "Tróia");
        $frase->contains("Peão");
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $frase = $validator->newString('A frase', "O frase", 'Cavalo de Tróia')->contains('Cavalo', "Tróia");
        $frase->notContains("Peão", "Caneca", "Teclado");
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $frase = $validator->newString('A frase', "O frase", 'Cavalo de Tróia')->contains('Cavalo', "Tróia");
        $frase->atLeastOneLowercase();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $frase = $validator->newString('A frase', "O frase", 'Cavalo de Tróia')->contains('Cavalo', "Tróia");
        $frase->atLeastOneUppercase();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $frase = $validator->newString('A frase', "O frase", 'Cavalo de Tróia')->contains('Cavalo', "Tróia");
        $frase->atLeastOneNumber();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
    }
    
    public function testOptionalFields()
    {
        $validator = $this->mock();
        $cor = $validator->newString('cor', "A cor", '')->required(false)->equal("azul");
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
    }
    
    public function testTranslate()
    {
        $validator = $this->mock();
        try
        {
            $validator->newString('cor', "A cor", '')
                    ->required(true)
                    ->getValidator()
                    ->validate(true);
        } 
        catch (ValidationException $ex) 
        {
            $error = $ex->getErrors();
            foreach($error as $e)
            {
                $this->assertSame("A cor não pode ficar em branco", $e->message);
            }
        }
    }
}