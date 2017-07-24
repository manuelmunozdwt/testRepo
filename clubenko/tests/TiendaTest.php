<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TiendaTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function testTiendasIndex()
    {
        // Assert that the array of categorias has these keys.
        $response = $this->get('/api/tiendas');
        $response->see('nombre');
    }
    
    public function testTiendasIndexStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/tiendas');
        $response->assertResponseStatus(200);
    }
    
    public function testTiendasShow()
    {
        // Assert that the response has the correct json structure.
        $this->get('/api/tiendas/1')
             ->seeJsonStructure([
                 '*' => [
                     'nombre', 'slug', 'direccion'
                 ]
             ]);
    }
    
    public function testTiendasShowStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/tiendas/1');
        $response->assertResponseStatus(200);
    }
    
    public function testTiendasStore()
    {
        // Assert that the resource has been stored correctly.
        $response = $this->json('POST', '/api/tiendas', ['nombre' => 'Test tienda', 
            'logo' => 'spa.png', 'direccion' => 'Test direccion', 'telefono' => '001122233', 'web' => 'www.testtienda.com',
            'latitud' => '40.5488552', 'longitud' => '-3.6912135', 'provincia_id' => '12', 'user_id' => '76'],
            [ 'Content-Type' => 'application/json', 'Accept' => 'application/json']);

        $response
            ->assertResponseStatus(201);
        $responseArray = json_decode($response->response->content());
        return $responseArray->data->id;
    }
    
    /**
     * @depends testTiendasStore
     */
    public function testTiendasUpdate($idTienda)
    {
        // Assert that the resource has been updated correctly.
        $response = $this->json('PUT', '/api/tiendas/'.$idTienda, ['nombre' => 'Test tienda updated', 
            'logo' => 'spa.png', 'direccion' => 'Test direccion', 'telefono' => '001122233', 'web' => 'www.testtienda.com',
            'latitud' => '40.5488552', 'longitud' => '-3.6912135', 'provincia_id' => '12', 'user_id' => '76'],
            [ 'Content-Type' => 'application/json', 'Accept' => 'application/json']);

        $response
            ->assertResponseStatus(200);
    }
    
    /**
     * @depends testTiendasStore
     */
    public function testTiendasDelete($idTienda)
    {
        // Assert that the response status is correct.
        $response = $this->delete('/api/tiendas/'.$idTienda);
        $response->assertResponseStatus(204);
    }
    
    /**
     * @depends testTiendasStore
     */
    public function testTiendasRestore($idTienda)
    {
        // Assert that the resource has been restored correctly.
        $response = $this->put('/api/tiendas/'.$idTienda.'/restore');
        $response->assertResponseStatus(204);
    }
}
