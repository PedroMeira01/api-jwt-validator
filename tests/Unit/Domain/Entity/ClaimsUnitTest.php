<?php

namespace Tests\Unit;

use App\Exceptions\EntityValidationException;
use Core\Domain\Entity\Claims;
use PHPUnit\Framework\TestCase;

class ClaimsUnitTest extends TestCase
{
    public function test_claims()
    {        
        $claims = new Claims(
            name: 'Toninho Araujo',
            seed: 7841,
            role: 'Admin'
        );

        $this->assertEquals('Toninho Araujo', $claims->name);
        $this->assertEquals(7841, $claims->seed);
        $this->assertEquals('Admin', $claims->role);
    }

    public function test_claims_invalid_name()
    {
        $this->expectException(EntityValidationException::class);

        $claims = new Claims(
            name: 'Ton1nho Ar4uj0',
            seed: 7841,
            role: 'Admin'
        );
    }

    public function test_claims_invalid_name_max_chars()
    {
        $this->expectException(EntityValidationException::class);

        $claims = new Claims(
            name: str_repeat('a', 257),
            seed: 7841,
            role: 'Admin'
        );
    }

    public function test_claims_invalid_seed()
    {
        $this->expectException(EntityValidationException::class);

        $claims = new Claims(
            name: 'Ton1nho Araujo',
            seed: 4,
            role: 'Admin'
        );
    }

    public function test_claims_invalid_role()
    {
        $this->expectException(EntityValidationException::class);

        $claims = new Claims(
            name: 'Ton1nho Araujo',
            seed: 7841,
            role: 'Intern'
        );
    }
}
