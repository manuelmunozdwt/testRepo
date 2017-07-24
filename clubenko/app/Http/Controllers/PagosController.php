<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use \Stripe\Stripe;
use \Stripe\Token;
use \Stripe\Charge;
use Validator;

class PagosController extends Controller
{



    public function __construct(){

    	if(env('APP_ENV') == 'prod'){
            Stripe::setApiKey(config('stripe.api_secret_live'));
    	}
        else{
            Stripe::setApiKey(config('stripe.api_secret'));
        }

    }


    /**
     * [crear_token creamo el token Stripe para la tarjeta]
     * @param  [array] $card [dato de la tarjeta]
     * @return [object]       [object(Token)]
     */
   	private function crear_token($card = null){

		try{

			return [true, Token::create(array('card'=>$card))];

		}catch (\Stripe\Error\Card $e){

			$error = $e->getJsonBody()['error']['param'];

			$msg_error = array(
					'number' =>'El número de tarjeta no es valido',
					'exp_month' =>'El mes de caducidad de la tarjeta no es valido',
					'exp_year' => 'El año de caducidad de la tarjeta no es valido',
					'cvc' => 'El código de seguridad de la tarjeta (CVC) no es valido',
					'incorrect_number' => 'El número de tarjeta no es correcto',
					'expired_card' => 'La tarjeta esta caducada',
					'card_declined' => 'La tarjeta ha sido rechazada',
					'processing_error' => 'Ha ocurrido un error al procesar la tarjeta'
				);

			if(isset($msg_error[$error])){
				return [false,$msg_error[$error]];
			}else{
				return [false,'No se ha encontrado ninguna información de pago'];
			}
		}

    }

    /**
     * [validar_tarjeta verificamos si tenemos los datos nesarios de una tarjeta]
     * @param  [array] $datos_tarjeta [datos de la tarjeta]
     * @return [array]                [booleno, mensajes_error]
     */
    public function validar_tarjeta($datos_tarjeta){

        $rules = [
            'number'    => 'required',
            'expiry'    => 'required',
            'cvc'       => 'required'
        ];

        $messages  = array(
            'number.required'   => 'Debe introducir un numero de tarjeta',
            'expiry.required'   => 'Debe introducir la fecha de caducidad de la tarjeta',
            'cvc.required'      => 'Debe introducir el código de seguridad de la tarjeta (CVC)',
            );

        $validar = Validator::make($datos_tarjeta,$rules,$messages);

        if($validar->fails()){
            return [false,$validar->errors()];
        }

        return [true,''];

    }
   
    /**
     * [realizar_pago realizamos el pago a un usuaraio que paga con tarjeta]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function realizar_pago($request){

    	//verficamos que tenemos todos los datos de la tarjeta
    	$validar_tarjeta = self::validar_tarjeta($request->all());

    	//si falta algun dato de tarjeta devolvemos un mesaje de error
    	if(!$validar_tarjeta[0]){
    		return redirect()->back()->withErrors($validar_tarjeta[1]);
    	}

    	//creamos el elemento tarjeta para crear un token con Stripe
    	$card['number'] = $request->number;
    	$fecha = explode(' / ',$request->expiry);
    	$card['exp_month'] = $fecha[0];
    	$card['exp_year'] = $fecha[1];
    	$card['cvc'] = $request->cvc;

    	//si el objeto no tiene importe retormas a la vista de pago confirmado
    	if($request->amount == 0){
    		return [true];
    	}

    	//creamos el token de la token
    	$token = self::crear_token($card);

    	//si al crear el token a fallado algo devolvemo el mensaje de errror
    	if(!$token[0]){
    		return [false,$token[1]];
    	}

    	try {

    		//realizamos un cargo sobre la tarjeta data
	    	$cargo = Charge::create(array(
    			"amount" => $request->amount*100,
    			"currency" => "eur",
  				"source" => $token[1]->id,
  				"description" => "Pago de prueba"
    		));

            return [true];
    		
    	} catch (\Stripe\Error\Card $e) {

    		//si el cargo ha fallodo devolvemos a la vista de pago denegado
    		return [false];
    	}
    	

    }


    public function pago_confirmado($slug = null)
    {
        
    	if (!$slug) {
			return redirect()->back();
		}

    	$data['slug'] = $slug;

        return return_vistas('public.pagos.confirmado', $data);
    }

    public function pago_cancelado()
    {
        $data = array();
        return return_vistas('public.pagos.cancelado', $data);
    }

}
