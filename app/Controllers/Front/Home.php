<?php

namespace App\Controllers\Front;
use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
	{	
		return view('Front/home');
	}
    public function recoverPassword()
	{
		return view('Front/recover_password');
	}
	public function signIn(){
		if (!$this->validate([
			'email'=>'required|valid_email',
			'password'=>'required'
		],[
			'email'=>[
				'required' => 'Ingresa un correo electronico',
				'valid_email' => 'Ingresa un correo electronico valido',
			],
			'password'=>[
				'required' => 'Ingresa una contraseña',
			],
		])) {
			return redirect()->back()->with('errors',$this->validator->getErrors())->withInput();
		}
		$email=trim($this->request->getVar('email')); 
		$password=trim($this->request->getVar('password'));

		$model= model('UserModel');
		if (!$user=$model->getUserBy('useremail',$email)) {
			return  redirect()->back()->with('msg',['type'=> 'danger', 'body'=>'Este usuario no se encuentra registrado en el sistema.']);
		}
		
		if (!password_verify($password,$user->password)) {
			return  redirect()->back()->with('msg',['type'=> 'danger', 'body'=>'Las credenciales no son validas.']);
		}
		session()->set([
			'id_user'=>$user->id_user,
			'group'=>$user->getRole()->name_group,
			'is_logged'=>true,
		]);
		switch ($user->getRole()->name_group) {
			case 'Cliente':
				return redirect()->route('homeClient')->with('msg',['type'=> 'success', 'body'=>'Bienvenido '.$user->usersurname.' '.$user->username]);
				break;
			case 'Administrador':
				return redirect()->route('homeAdmin')->with('msg',['type'=> 'success', 'body'=>'Bienvenido Administrador '.$user->usersurname.' '.$user->username]);
				break;
			case 'Chef':
				return redirect()->route('homeChef')->with('msg',['type'=> 'success', 'body'=>'Bienvenido Chef '.$user->usersurname.' '.$user->username]);
				break;
			default:
			echo'mal';
				// return  redirect()->back()->with('msg',['type'=> 'danger', 'body'=>'Este usuario no puede acceder. Disculpe las molestias.']);
				break;
		}
		
	}
}
