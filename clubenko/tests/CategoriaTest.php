<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoriaTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function testCategoriasIndex()
    {
        // Assert that the array of categorias has these keys.
        $response = $this->get('/api/categorias');
        $response->see('nombre');
    }
    
    public function testCategoriasIndexStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/categorias');
        $response->assertResponseStatus(200);
    }
    
    public function testCategoriasShow()
    {
        // Assert that the response has the correct json structure.
        $this->get('/api/categorias/1')
             ->seeJsonStructure([
                 '*' => [
                     'nombre', 'imagen'
                 ]
             ]);
    }
    
    public function testCategoriasShowStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/categorias/1');
        $response->assertResponseStatus(200);
    }
}
