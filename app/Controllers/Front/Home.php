<?php

namespace App\Controllers\Front;
use App\Controllers\BaseController;
use App\Entities\User;

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
	public function validateResetPassword(){
		$validation =  \Config\Services::validation();
		$request= \Config\Services::request();

		$data=array(
			'id_user'=>$request->getPostGet('id_user'),
			'password'=>$request->getPostGet('password'),
		);
		$model = model('Usermodel');

		$validation->setRules([
          	'password' => 'required|min_length[8]|matches[passwordConfirm]',
			'passwordConfirm'=>'required|min_length[8]',
		],
        [   // Errores-Mensajes
            'password' =>[
				'required'=>'Debe ingresar una contraseña',
				'min_length'=>'Usa 8 caracteres o más para tu contraseña',
				'matches' => 'Las contrase&ntilde;as no coinciden. Vuelve a intentarlo.'
			],
			'passwordConfirm' => [
				'required' => 'Debe ingresar una contraseña',
				'min_length'=>'Usa 8 caracteres o más para tu contraseña',
            ],
			
		]
        );
		if (!$validation->withRequest($this->request)->run()) {
			return  redirect()->back()->with('errors',$validation->getErrors());
		}else {
			$user= new User($data);
			if (true!=$model->update($user->getIDUser(), ['password' => $user->getPassword(),	'tokenPassword'=>null,'dateTokenPassword'=>null])) {
				return  redirect()->back()->with('msg',['type'=> 'danger', 'body'=>'Error al cambiar su contrase&ntilde;a. Vuelve a intentarlo.']);
			}else {
				return  redirect()->to('')->with('msg',['type'=> 'success', 'body'=>'El usuario pudo cambiar su contrase&ntilde;a. con exito.']);
			}
			// if (0!=$model->update($user->getIDUser(), ['password' => $user->getPassword(),	'tokenPassword'=>null,'dateTokenPassword'=>null])) {
			// 	return  redirect()->back()->with('msg',['type'=> 'danger', 'body'=>'Error al cambiar su contrase&ntilde;a. Vuelve a intentarlo.']);
			// }else {
			// 	echo 'bien';
			// }
		// 	<div class="alert alert-danger d-flex align-items-center" role="alert">
		// 	<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
		// 	<div>
		// 	  An example danger alert with an icon
		// 	</div>
		//   </div>
		}


		
	}
	public function validateRecoverPassword()
	{	helper('text');
		$request= \Config\Services::request();
		$validation =  \Config\Services::validation();
		$validation->setRules([
            'inputEmail' => 'required|max_length[50]|valid_email',
	    ],
        [   // Errores-Mensajes
			'inputEmail' =>[
				'required'=>'Debe ingresar un email para poder recuperar su contraseña',
				'valid_email'=>'Debe ingresar un email valido',
				'max_length'=>'Debe ingresar un email valido menor a 50 caracteres',
			],
		]
        );
		
		if (!$validation->withRequest($this->request)->run()) {
			return redirect()->back()->withInput()->with('errors', $validation->getErrors());
		}else {
			
			$user= new User();
			$token=strtoupper(random_string('alnum',8));
			if ($user->obtenerEmail($request->getPostGet('inputEmail'))==null) {
				return redirect()->back()->withInput()->with('msg',['type'=> 'danger', 'body'=>'El email ingresado no se encuentra registrado.','icon'=>'<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
				']);
				//return redirect()->back()->withInput()->with('msg', 'El email ingresado no se encuentra registrado');
			}

			$model= model('UserModel');
		
			$data=array(
				'id_user'=>$user->obtenerEmail($request->getPostGet('inputEmail'))->getIDUser(),
				'tokenPassword'=>$token,
				'dateTokenPassword'=>date('Y-m-d H:i:s',strtotime("+1 day 2 hours")),
			);
			
			if ($model->save($data)) {
			
				$fullNameUser=$user->obtenerEmail($request->getPostGet('inputEmail'))->getUsername().' '.$user->obtenerEmail($request->getPostGet('inputEmail'))->getUsersurname();
				if ($this->sendEmail($data['id_user'],$data['tokenPassword'],$request->getPostGet('inputEmail'),$fullNameUser)) {
					// echo("Bien");
					return redirect()->back()->withInput()->with('msg',['type'=> 'success', 'body'=>'Se envio email. Revise su bandeja de entrada de su correo.','icon'=>'<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>']);

					return redirect()->back()->with('msg', 'Se envio email. Revise su bandeja de entrada de su correo');
				} else {
					// echo("Mal");
					return redirect()->back()->withInput()->with('msg',['type'=> 'danger', 'body'=>'No se pudo envio email. Intente nuevamente mas tarde.','icon'=>'<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
				']);
				}
				
			} else {
				return redirect()->back()->withInput()->with('msg',['type'=> 'danger', 'body'=>'No se pudo envio email. Hubo un problema en el proceso. Intentelo nuevamente mas tarde.','icon'=>'<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
				']);
			}
		}
	}
	private function sendEmail(string $id,string $token,string $correo,string $fullNameUser){
		// $to=$correo;<strong>'.$token.'</strong><br>
		$subject='Recuperar contraseña';
		$message='<table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;">
				<tr>
					<td style="background-color: #ecf0f1">
						<div style="color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif">
							<div style="text-align: right;">
								<img src="https://img.icons8.com/ios-filled/50/000000/restaurant-table.png" alt="SRO"  width="50px"> 
							</div>
							<h2 style="color: #e67e22; margin: 0 0 7px">¿Restablecer tu contraseña?</h2>
							<p style="margin: 2px; font-size: 15px">
								Hola '.$fullNameUser.'<br>
								Si solicitaste un restablecimiento de contraseña para el correo: '.$correo.', usa el código de confirmación que aparece a continuación para completar el proceso. Si no solicitaste esto, puedes ignorar este correo electrónico.<br><br>
								
							</p>
							<div style="width: 100%; text-align: center ; padding-top: 30px;">
								<a style="text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #3498db" href="'.base_url("/resetPassword").'?id='.$id.'&cverifi='.$token.'">Reestablecer contraseña</a>	
							</div>
							<p style="color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0 ;">© 2021 Copyright: SRO</p>
						</div>
					</td>
				</tr>
			</table>';
		echo($correo.'<br>');
		echo($subject.'<br>');
		echo($message.'<br>');
		// dd();
		$email = \Config\Services::email();
		$email->setFrom('your@example.com', 'Info');
		$email->setTo($correo);
		$email->setSubject($subject);
		$email->setMessage($message);
		return $email->send();
	}
}
