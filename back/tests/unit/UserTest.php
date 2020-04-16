<?php

class UserTest extends \PHPUnit\Framework\TestCase
{
    protected $user;

    public function setUp()
    {
        $this->user = new \App\Models\Teacher;
    }

    public function testEmailVariablesContainCorrectValues()
    {
        $user = new \App\Models\Teacher;
        $user->setFirstName('Haven');
        $user->setLastName('Shen');
        $user->setEmail('havenshen@gmail.com');

        $emailVariables = $user->getEmailVariables();

        $this->assertArrayHasKey('full_name', $emailVariables);
        $this->assertArrayHasKey('email', $emailVariables);

        $this->assertEquals($emailVariables['full_name'], 'Haven Shen');
        $this->assertEquals($emailVariables['email'], 'havenshen@gmail.com');
    }
}