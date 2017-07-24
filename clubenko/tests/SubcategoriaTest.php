<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubcategoriaTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function testSubcategoriasIndex()
    {
        // Assert that the array of categorias has these keys.
        $response = $this->get('/api/subcategorias');
        $response->see('nombre');
    }
    
    public function testSubcategoriasIndexStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/subcategorias');
        $response->assertResponseStatus(200);
    }
    
    public function testSubcategoriasShow()
    {
        // Assert that the response has the correct json structure.
        $this->get('/api/subcategorias/1')
             ->seeJsonStructure([
                 '*' => [
                     'nombre'
                 ]
             ]);
    }
    
    public function testSubcategoriasShowStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/subcategorias/1');
        $response->assertResponseStatus(200);
    }
    
}
