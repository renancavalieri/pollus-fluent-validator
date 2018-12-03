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
 
        $validator->addString('cep', "O CEP", '17930-000')->cep();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('cep', "O CEP", '17930000')->cep();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('cep', "O CEP", '17d930-000')->cep();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $nome = $validator->addString('nome', "O nome", 'Fernando da Silva Pessoa')->lenghtBetween(5, 25);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $nome->clearValidationErrors()->lenghtBetween(25, 40);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $nome->clearValidationErrors()->minLenght(10);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $nome->clearValidationErrors()->minLenght(30);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $nome->clearValidationErrors()->maxLenght(30);
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $nome->clearValidationErrors()->maxLenght(10);
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $validator->clear();
        
        $validator->addString('celular', "O Celular", '18996312354')->mobilePhoneNumber();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('celular', "O Celular", '1838222122')->mobilePhoneNumber();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('celular', "O telefone", '18996312354')->phoneNumber();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('celular', "O telefone", '1838222122')->phoneNumber();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('url', "A url", 'https://www.tecdicas.com/')->url();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('url', "A url", 'http://tecdicas.com')->url();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('url', "A url", '//tecdicas.com')->url();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('url', "A url", 'tecdicas.com')->url();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('url', "A url", 'ftp://tecdicas.com')->url();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        
        $validator->addString('ip', "O endereço IP", '177.77.159.98')->ip()->ipv4();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('ip', "O endereço IP", '177.77.159.98')->ip()->ipv6();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('ip', "O endereço IP", '2001:0db8:85a3:0000:0000:8a2e:0370:7334')->ip()->ipv6();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('ip', "O endereço IP", '2001:0db8:85a3:0000:0000:8a2e:0370:7334')->ip()->ipv4();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('email', "O email", 'renan@tecdicas.com')->email();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('email', "O email", 'renan@@tecdicas.com')->email();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        
        $cor = $validator->addString('cor', "A cor", 'azul')->equal("azul");
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $cor->clearValidationErrors()->notEqual('rosa');
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $cor->clearValidationErrors()->notEqual('azul');
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $cor->clearValidationErrors()->notEqual('vermelho');
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $validator->clear();
        
        
        $validator->addString('cpf', "O CPF", '35646991048')->cpf();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('cpf', "O CPF", '11111111111')->cpf();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('cpf', "O CPF", '00000000000')->cpf();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('cpf', "O CPF", '848748748744')->cpf();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('cnpj', "O CNPJ", '82140216000117')->cnpj();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();

        $validator->addString('cnpj', "O CNPJ", '11111111111111')->cnpj();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('cnpj', "O CNPJ", '1234567891234')->cnpj();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('cnpj', "O CNPJ", '3654895178800')->cnpj();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        
        $validator->addString('numero', "O número", '021578')->numeric()->alphaNumeric();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('numero', "O número", '84d8dsc')->numeric();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('numero', "O número", '84d8dsc')->numeric();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('numero', "O número", '84d8dsc')->alpha();
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $validator->addString('numero', "O número", 'asdfgh')->alpha();
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
        
        $frase = $validator->addString('A frase', "O frase", 'Cavalo de Tróia')->contains('Cavalo', "Tróia");
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        
        $frase->clearValidationErrors()->contains("Peão");
        $this->assertSame(true, $validator->validate(false)->hasErrors());
        
        $frase->clearValidationErrors()->notContains("Peão", "Caneca", "Teclado");
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
    }
    
    public function testOptionalFields()
    {
        $validator = $this->mock();
        $cor = $validator->addString('cor', "A cor", '')->required(false)->equal("azul");
        $this->assertSame(false, $validator->validate(false)->hasErrors());
        $validator->clear();
    }
}