<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/adduser.php';
require_once __DIR__ . '/../blogic.php';

session_start(); // Start the session to store the success message
error_reporting(E_ALL);
ini_set('display_errors', 1);


class adduserTest extends TestCase {
    private $user ;

    protected function setUp(): void  {
        $this->user = new User();        
    }
    // $blogic->insert_user($name, $email, $password, $profile_picture, $room_no, 'user');


    public function testAddUser(){
        $data=[
            'name'=>'mohamed',
            'email'=>'mohamed@gmail.com',
            'password'=>'Mohamed@1234',
            'Cpassword' => 'Mohamed@1234',
            'profile_picture'=>'photo.png',
            'room_no'=>1
        ];

        $result = $this->user->insert_user('mohamed',
        'mohamed@gmail.com',
        'Mohamed@1234',
        'photo.png',
        1,
        'user');
        $this->assertTrue($result); 
    }
}
