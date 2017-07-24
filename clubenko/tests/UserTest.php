<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function testBasicExample()
    {
        $response = $this->get('/api/usuarios');

        $response
            ->assertResponseOk();
    }
    
    public function testUsersIndex()
    {
        // Assert that the array of usuarios has these keys.
        $response = $this->get('/api/usuarios');
        $response->see('dni');
    }
    
    public function testUsersIndexStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/usuarios');
        $response->assertResponseStatus(200);
    }
    
    public function testUsersShow()
    {
        // Assert that the response has the correct json structure.
        $this->get('/api/usuarios/1')
             ->seeJsonStructure([
                 '*' => [
                     'dni', 'apellidos'
                 ]
             ]);
    }
    
    public function testUsersShowStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/usuarios/1');
        $response->assertResponseStatus(200);
    }
    /*
    public function testUsersStore()
    {
        // Assert that the resource has been stored correctly.
        $response = $this->json('POST', '/api/usuarios', ['nombre' => 'UserTest2', 'apellidos' => 'UserTest',
            'dni' => '1111120', 'email' => 'EmailTest2@test.com', 'password' => 'garcia123456', 'password_confirmation' => 'garcia123456',
            'imagen' => 'user.png', 'rol' => '2', 'nombre_comercio' => 'Test'],
            [ 'Content-Type' => 'application/json', 'Accept' => 'application/json']);

        $response
            ->assertResponseStatus(201);
    }
    
    public function testUsersUpdate()
    {
        // Assert that the resource has been updated correctly.
        $response = $this->json('PUT', '/api/usuarios/77', ['nombre' => 'UserTest2 Updated', 'apellidos' => 'UserTest',
            'dni' => '1111120', 'email' => 'EmailTest2@test.com', 'password' => 'garcia123456', 'password_confirmation' => 'garcia123456',
            'imagen' => 'user.png', 'rol' => '2', 'nombre_comercio' => 'Test'],
            [ 'Content-Type' => 'application/json', 'Accept' => 'application/json']);

        $response
            ->assertResponseStatus(200);
    }
    
    public function testUsersDelete()
    {
        // Assert that the response status is correct.
        $response = $this->delete('/api/usuarios/77');
        $response->assertResponseStatus(204);
    }
    
    public function testUsersRestore()
    {
        // Assert that the resource has been restored correctly.
        $response = $this->put('/api/usuarios/77/restore');
        $response->assertResponseStatus(204);
    }*/
}
