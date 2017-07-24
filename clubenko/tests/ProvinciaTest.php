<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProvinciaTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function testProvinciasIndex()
    {
        // Assert that the array of categorias has these keys.
        $response = $this->get('/api/provincias');
        $response->see('nombre');
    }
    
    public function testProvinciasIndexStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/provincias');
        $response->assertResponseStatus(200);
    }
    
    public function testProvinciasShow()
    {
        // Assert that the response has the correct json structure.
        $this->get('/api/provincias/1')
             ->seeJsonStructure([
                 '*' => [
                     'nombre', 'slug'
                 ]
             ]);
    }
    
    public function testProvinciasShowStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/provincias/1');
        $response->assertResponseStatus(200);
    }
    
    public function testProvinciasTiendas()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/provincias/1/tiendas');
        $response->assertResponseStatus(200);
    }
    
}
