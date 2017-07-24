<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CuponTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function testApplication()
    {
        $this->get('/api/cupones/1', ['Authorization' => 'Basic ' . 'ZGFyd29mdEBkYXJ3b2Z0LmNvbToxMjM0NTY='])
                ->seeJsonStructure([
                 '*' => [
                     'titulo', 'descripcion', 'descripcion_corta'
                 ]
             ]);
    }
    
    public function testCuponesIndex()
    {
        // Assert that the array of cupones has these keys.
        $response = $this->get('/api/cupones');
        $response->see('titulo');
    }
    
    public function testCuponesIndexStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/cupones');
        $response->assertResponseStatus(200);
    }
    
    public function testCuponesShow()
    {
        // Assert that the response has the correct json structure.
        $this->get('/api/cupones/1')
             ->seeJsonStructure([
                 '*' => [
                     'titulo', 'descripcion', 'descripcion_corta'
                 ]
             ]);
    }
    
    public function testCuponesShowStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/cupones/1');
        $response->assertResponseStatus(200);
    }
    
    public function testCuponesStore()
    {
        // Assert that the resource has been stored correctly.
        $response = $this->json('POST', '/api/cupones', ['titulo' => 'Test cuponc', 'descripcion_corta' => 'Test',
            'descripcion' => 'Test', 'condiciones' => 'Test', 'categoria_id' => '2', 'subcategoria_id' => '3',
            'logo' => 'spa.png', 'fecha_inicio' => '2017-07-12', 'fecha_fin' => '2030-07-12', 'ilimitado' => true,
            'filtro_id' => '3', 'tienda' => [17,18], 'confirmado' => true, 'user_id' => '75'],
            [ 'Content-Type' => 'application/json', 'Accept' => 'application/json']);

        $response
            ->assertResponseStatus(201);
        
        
        $responseArray = json_decode($response->response->content());
        return $responseArray->data->id;
        
    }
    
    /**
     * @depends testCuponesStore
     */
    public function testCuponesUpdate($idCupon)
    {
        // Assert that the resource has been updated correctly.
        $response = $this->json('PUT', '/api/cupones/'.$idCupon, ['titulo' => 'Test cuponc updated', 'descripcion_corta' => 'Test',
            'descripcion' => 'Test', 'condiciones' => 'Test', 'categoria_id' => '2', 'subcategoria_id' => '3',
            'logo' => 'spa.png', 'fecha_inicio' => '2017-07-12', 'fecha_fin' => '2030-07-12',
            'filtro_id' => '3', 'tienda' => [17], 'user_id' => '75'],
            [ 'Content-Type' => 'application/json', 'Accept' => 'application/json']);

        $response
            ->assertResponseStatus(200);
    }
    
    /**
     * @depends testCuponesStore
     */
    public function testCuponesDelete($idCupon)
    {
        // Assert that the response status is correct.
        $response = $this->delete('/api/cupones/'.$idCupon);
        $response->assertResponseStatus(204);
    }
    
    /**
     * @depends testCuponesStore
     */
    public function testCuponesNotShowStatus($idCupon)
    {
        // Assert that the response status is "not found" after soft delete.
        $response = $this->get('/api/cupones/'.$idCupon);
        $response->assertResponseStatus(404);
    }
    
    /**
     * @depends testCuponesStore
     */
    public function testCuponesRestore($idCupon)
    {
        // Assert that the resource has been restored correctly.
        $response = $this->put('/api/cupones/'.$idCupon.'/restore');
        $response->assertResponseStatus(204);
    }
}
