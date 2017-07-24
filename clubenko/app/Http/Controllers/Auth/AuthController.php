<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use Input;
use BrowserDetect;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }
    
    public function login(){
        if(BrowserDetect::isDesktop()){
            return view('auth.login-comercio');
        }else{
            return view('auth.login');
            
        }
    }

    public function registro(){
        if(BrowserDetect::isDesktop()){
            return view('auth.register-comercio');
        }else{
            return view('auth.register');
            
        }
    }

    public function authenticate()
    {
        if (Auth::attempt(['dni' => Input::get('dni'), 'password' => Input::get('password')])) {

            // Authentication passed...
            if(Auth::user()->confirmado == 1){
                return redirect()->intended(route('mis_datos'));
            }else{
                return redirect()->route('logout');
            }
        }else{
            return redirect()->back()->withInput();
        }
    }

    public function logout(){
        Auth::logout(); // log the user out of our application
        return redirect('/'); // redirect the user to the login screen

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
dd('Avisar al administrador de la plataforma');
        $messages = ([
            'name.required' => 'Por favor, introduzca un nombre',
            'name.max' => 'El nombre no debe superar los 255 caracteres',

            'nombre_comercio.required' => 'Por favor, introduzca el nombre del comercio',
            'nombre_comercio.max' => 'El nombre del comercio no debe superar los 255 caracteres',

            'dni.required' => 'Por favor, introduzca un dni',
            'dni.dni' => 'El formato de dni no es válido',
            'dni.max' => 'El dni no debe superar los 255 caracteres',
            'dni.unique' => 'El dni introducido ya existe, por favor, introduzca otro dni',

            'password.required' => 'Por favor, introduzca una contraseña',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        return Validator::make($data, [
            'name' => 'required|max:255',
            'nombre_comercio' => 'required|max:255',
            'dni' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(Request $request)
    {
        $messages = ([
                'name.required' => 'Por favor, introduzca un nombre',
                'name.max' => 'El nombre no debe superar los 255 caracteres',

                'apellidos.max' => 'Los apellidos no debe superar los 255 caracteres',

                'dni.required' => 'Por favor, introduzca un dni',
                'dni.dni' => 'El formato de dni no es válido',
                'dni.max' => 'El dni no debe superar los 255 caracteres',
                'dni.unique' => 'El dni introducido ya existe, por favor, introduzca otro dni',

                'nombre_comercio.required' => 'Por favor, introduzca el nombre del comercio',
                'nombre_comercio.max' => 'El nombre del comercio no debe superar los 255 caracteres',

                'password.required' => 'Por favor, introduzca una contraseña',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres',
                'password.confirmed' => 'Las contraseñas no coinciden',

                'email.required' => 'Por favor, introduzca su email',
                'email.unique' => 'Ese email ya existe, por favor, introduzca otro email',
                'email.email' => 'Por favor, introduzca un email válido',
        ]);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'apellidos' => 'max:255',
            'nombre_comercio' => 'required|max:255',
            'dni' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'email' => 'required|unique:users|email'
        ], $messages);

        $data = $request->all();

        $user = new User();
        $user->dni = $data['dni'];
        $user->name = $data['name'];
        $user->apellidos = $data['apellidos'];
        $user->email = $data['email'];
        $user->nombre_comercio = $data['nombre_comercio'];
        $user->password = bcrypt($data['password']);
        $user->slug = $this->construir_slug($data['name']);

        //Forzamos a que sea un comercio en le registro, cambiar para dar otro valor
        $user->rol = 2;

        if ($validator->fails()) {
            return redirect()->route('registro')
                        ->withErrors($validator)
                        ->withInput();
        }else{
            $user->save();            
            return redirect()->route('login')->with('status', 'Sus datos han sido guardados correctamente.');
        }
    }

    public function construir_slug($string){
        //tomamos el nombre y apellidos insertados para construir el slug base
        $baseslug = normalizar_string($string);

        //Miramos si ese slug ya existe
        $existe = User::where('slug', $baseslug)->count();  

        //Si no existe, lo guardamos
        if($existe == 0){
            $string = $baseslug;
        //si existe, añadimos un contador al final (2, porque sería el segundo usuario con ese nombre)
        }else{
            $i = 2;
            $slug=$baseslug.'-'.$i;
            $existe = User::where('slug', $slug)->count(); 
                //volvemos a checkear si existe. Mientras exista el slug ($existe sea = 1)
            while ($existe > 0){
                // añadimos uno al contador 
                $i = $i+1;    
                $slug = $baseslug.'-'.$i;
                //y volvemos a checkear
                $existe = User::where('slug', $slug)->count(); 
            }
            //cuando no encontremos el slug en la bbdd ($existe = 0), guardamos el slug 
            $string = $slug;
        }
        return $string;
    }
}
