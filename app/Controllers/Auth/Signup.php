<?php namespace App\Controllers\Auth;
use App\Controllers\BaseController;
use App\Entities\User;
use Faker\Factory;
class Signup extends BaseController
{
	protected $configs;

	public function __construct() {
		$this->configs = config('Restaurant');
	}

	public function index()
	{	
		return view('Auth/Register');
	}
	public function store()
	{	$faker = Factory::create();
		$validation =  \Config\Services::validation();
		$request= \Config\Services::request();
		$data =[
			'id_user'=>$faker->unique()->uuid,
			'username'=>$request->getPostGet('inputName'),
			'usersurname'=>$request->getPostGet('inputSurname'),
			'userDni'=>$request->getPostGet('inputDni'),
			'userBirthday'=>$request->getPostGet('inputFecNac'),
			'useradress'=>$request->getPostGet('inputAddress'),
			'usertel'=>$request->getPostGet('inputTel'),
			'useremail'=>$request->getPostGet('inputEmail'),
			'password'=>$request->getPostGet('inputPassword'),
			'tokenPassword'=> null,
			// 'id_group'=>3,
		];
		$validation->setRules([
			'inputName' => 'required|alpha_space|min_length[3]|max_length[30]',
			'inputSurname' => 'required|alpha_space|min_length[3]|max_length[30]',
			'inputDni' => 'required|min_length[7]|max_length[8]',
			'inputFecNac' => 'required',
			'inputAddress' => 'required|alpha_numeric_space|min_length[3]',
			'inputTel' => 'required|regex_match[[0-9]{10}]',
			'inputEmail' => 'required|valid_email',
			'inputPassword' => 'required|min_length[8]|matches[inputPasswordConfirm]',
			'inputPasswordConfirm' => 'required',
		  	
		],
		[   // Errores-Mensajes
			'inputSurname' =>[
				'required'=>'Debe ingresar su/s apellido/s',
				'min_length'=>'El apellido ingresado no superá su longitud minima',
				'max_length'=>'El apellido ingresado superó su longitud maxima',
				'alpha_space'=>'El apellido solo debe contener caracteres alfabeticos y espacios'
			],
			'inputName' => [
				'required'=>'Debe ingresar su/s nombre/s',
				'min_length'=>'El nombre ingresado no superá su longitud minima',
				'max_length'=>'El nombre ingresado superó su longitud maxima',
				'alpha_space'=>'El nombre solo debe contener caracteres alfabeticos y espacios'
			],
			'inputDni' => [
				'required' => 'Debe ingresar un DNI',
                'min_length'=>'El DNI ingresado no superá su longitud minima',
            	'max_length'=>'El DNI ingresado superó su longitud maxima',
			],
			'inputFecNac' => [
				'required'=>'Debe ingresar su fecha de nacimiento'
			],
			'inputAddress' => [
				'required'=>'Debe ingresar una dirección',
				'min_length'=>'Debe ingresar una dirección valida',
				'alpha_space'=>'La direccion solo debe contener caracteres alfabeticos y espacios'
			],
			'inputTel' => [
				'required'=>'Debe ingresar un numero telefonico',
				'regex_match'=>'Debe ingresar un numero telefonico valido',
			],
			'inputEmail' => [
				'required'=>'Debe ingresar un email para poder registrarse',
				'valid_email'=>'Debe ingresar un email valido',
			],
			'inputPassword' => [
				'required'=>'Debe ingresar una contraseña',
				'min_length'=>'La contraseña ingresada no superá su longitud minima',
				'matches' => 'Las contrase&ntilde;as no coinciden.',
			],
			'inputPasswordConfirm' => [
				'required' => 'Debe ingresar una contraseña',
			],
		]
		);
		
		if (!$validation->withRequest($this->request)->run()) {
			return  redirect()->back()->with('errors',$validation->getErrors())->withInput();
		}else {
			$user= new User($data);
		$model= model('UserModel');
		$model->withGroup($this->configs->defaultGroupUser);
		
			if ($model->save($user)) {
				return  redirect()->route('home')->with('msg',['type'=> 'success', 'body'=>'Se registro correctamente.']);
				
			} else {
				return  redirect()->back()->with('msg',['type'=> 'danger', 'body'=>'Error al registrarse. Intentelo más tarde']);
			}
		}
	}
}
