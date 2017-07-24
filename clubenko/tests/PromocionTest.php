<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PromocionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function testPromocionesIndex()
    {
        // Assert that the array of cupones has these keys.
        $response = $this->get('/api/promociones');
        $response->see('titulo');
    }
    
    public function testPromocionesIndexStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/promociones');
        $response->assertResponseStatus(200);
    }
    
    public function testPromocionesShow()
    {
        // Assert that the response has the correct json structure.
        $this->get('/api/promociones/1')
             ->seeJsonStructure([
                 '*' => [
                     'titulo', 'descripcion', 'descripcion_corta'
                 ]
             ]);
    }
    
    public function testPromocionesShowStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/promociones/1');
        $response->assertResponseStatus(200);
    }
    
    public function testPromocionesStore()
    {
        // Assert that the resource has been stored correctly.
        $response = $this->json('POST', '/api/promociones', ['titulo' => 'Test promocion', 'descripcion_corta' => 'Test',
            'descripcion' => 'Test', 'condiciones' => 'Test', 'categoria_id' => '2', 'subcategoria_id' => '3',
            'logo' => 'spa.png', 'fecha_inicio' => '2017-07-12', 'fecha_fin' => '2030-07-12', 'ilimitado' => true, 'precio' => '100',
            'filtro_id' => '3', 'tipo_promocion' => 'reserva', 'tienda' => [17,18], 'confirmado' => true, 'user_id' => '75'],
            [ 'Content-Type' => 'application/json', 'Accept' => 'application/json']);

        $response
            ->assertResponseStatus(201);
        
        $responseArray = json_decode($response->response->content());
        return $responseArray->data->id;
    }
    
    /**
     * @depends testPromocionesStore
     */
    public function testPromocionesUpdate($idPromocion)
    {
        // Assert that the resource has been updated correctly.
        $response = $this->json('PUT', '/api/promociones/'.$idPromocion, ['titulo' => 'Test promocion updated', 'descripcion_corta' => 'Test',
            'descripcion' => 'Test', 'condiciones' => 'Test', 'categoria_id' => '2', 'subcategoria_id' => '3',
            'logo' => 'spa.png', 'fecha_inicio' => '2017-07-12', 'fecha_fin' => '2030-07-12', 'precio' => '100',
            'filtro_id' => '3', 'tipo_promocion' => 'reserva', 'tienda' => [17,18], 'user_id' => '75']);

        $response
            ->assertResponseStatus(200);
    }
    
    /**
     * @depends testPromocionesStore
     */
    public function testPromocionesDelete($idPromocion)
    {
        // Assert that the response status is correct.
        $response = $this->delete('/api/promociones/'.$idPromocion);
        $response->assertResponseStatus(204);
    }
    
    /**
     * @depends testPromocionesStore
     */
    public function testCuponesNotShowStatus($idPromocion)
    {
        // Assert that the response status is "not found" after soft delete.
        $response = $this->get('/api/promociones/'.$idPromocion);
        $response->assertResponseStatus(404);
    }
    
    /**
     * @depends testPromocionesStore
     */
    public function testPromocionesRestore($idPromocion)
    {
        // Assert that the resource has been restored correctly.
        $response = $this->put('/api/promociones/'.$idPromocion.'/restore');
        $response->assertResponseStatus(204);
    }
}
