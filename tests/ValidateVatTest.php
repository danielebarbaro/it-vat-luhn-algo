<?php declare(strict_types=1);

namespace Tests;

use App\ValidateVat;
use PHPUnit\Framework\TestCase;

final class ValidateVatTest extends TestCase
{
    protected $fake_vat;

    protected $real_vat;

    public function setUp(): void
    {
        parent::setUp();

        $this->fake_vat = '12345678901';
        $this->real_vat = '10648200011';
    }

    public function testClean(): void
    {
        $vat = ' ' . $this->fake_vat . ' ';
        self::assertEquals(ValidateVat::clean($vat), $this->fake_vat);
    }

    public function testIsValidFormat(): void
    {
        self::assertTrue(ValidateVat::isValidFormat($this->real_vat));
    }

    public function testIsValidFormatFail(): void
    {
        $vat = substr($this->fake_vat, 2, 9);
        self::assertFalse(ValidateVat::isValidFormat($vat));
        self::assertFalse(ValidateVat::isValidFormat($this->fake_vat . ' s '));
    }

    public function testLuhnCheck(): void
    {
        self::assertIsInt(ValidateVat::luhnCheck($this->fake_vat));
        self::assertNotEquals(ValidateVat::luhnCheck($this->fake_vat), 0);
    }

    public function testVerifyFail(): void
    {
        self::assertFalse(ValidateVat::verify($this->fake_vat));
    }

    public function testVerifyFormatFail(): void
    {
        self::assertFalse(ValidateVat::verify($this->fake_vat . 'S'));
    }

    public function testVerifySuccess(): void
    {
        self::assertTrue(ValidateVat::verify($this->real_vat));
    }
}
