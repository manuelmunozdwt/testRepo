<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ComentarioTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function testComentariosIndex()
    {
        // Assert that the array of categorias has these keys.
        $response = $this->get('/api/comentarios');
        $response->see('comentario');
    }
    
    public function testComentariosIndexStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/comentarios');
        $response->assertResponseStatus(200);
    }
    
    public function testComentariosShow()
    {
        // Assert that the response has the correct json structure.
        $this->get('/api/comentarios/1')
             ->seeJsonStructure([
                 '*' => [
                     'comentario', 'cupon'
                 ]
             ]);
    }
    
    public function testComentariosShowStatus()
    {
        // Assert that the response status is correct.
        $response = $this->get('/api/comentarios/1');
        $response->assertResponseStatus(200);
    }
    
    
    public function testComentariosStore()
    {
        // Assert that the resource has been stored correctly.
        $response = $this->json('POST', '/api/comentarios', ['comentario' => 'comentario', 
            'cupon_id' => '1', 'user_id' => '76'],
            [ 'Content-Type' => 'application/json', 'Accept' => 'application/json']);

        $response
            ->assertResponseStatus(201);
        $responseArray = json_decode($response->response->content());
        return $responseArray->data->id;
    }
    
    /**
     * @depends testComentariosStore
     */
    public function testComentariosUpdate($idComentario)
    {
        // Assert that the resource has been updated correctly.
        $response = $this->json('PUT', '/api/comentarios/'.$idComentario, ['comentario' => 'comentario updated', 
            'cupon_id' => '1', 'user_id' => '76'],
            [ 'Content-Type' => 'application/json', 'Accept' => 'application/json']);

        $response
            ->assertResponseStatus(200);
    }
    
    /**
     * @depends testComentariosStore
     */
    public function testComentariosDelete()
    {
        // Assert that the response status is correct.
        $response = $this->delete('/api/comentarios/'.$idComentario);
        $response->assertResponseStatus(204);
    }
}
