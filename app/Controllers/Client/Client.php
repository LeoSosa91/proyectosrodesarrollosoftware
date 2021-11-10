<?php
namespace App\Controllers\Client;
use App\Controllers\BaseController;
use App\Entities\User;

class Client extends BaseController 
{
    public function index()
	{	
		$data['title']="Home";
		if (!session()->is_logged) {
			return redirect()->route('home');
		}
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Clients/home');
	}
    public function infoClient()
	{	
		$userModel= model('UserModel');
		$user=$userModel->asObject()->where("id_user",session('id_user'))->first();
		$data['title']="Informacion Personal";
		$data['user']=[
			'id_user'=>$user->id_user,
			'userDni'=>$user->dniUsuario,
			'useradress'=>$user->useradress,
			'userBirthday'=>$user->userBirthday,
			'username'=>$user->username,
			'usersurname'=>$user->usersurname,
			'usertel'=>$user->usertel,
			'useremail'=>$user->useremail
		];
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Clients/infoClient');
	}
	public function guardarInfoPersonal(){
		$validation =  \Config\Services::validation();
		$request= \Config\Services::request();
		$userModel= model('UserModel');

		$data=array(
			'id_user'=>$request->getVar('idUser'),
			'username'=>$request->getVar('inputName'),
			'usersurname'=>$request->getVar('inputSurname'),
			'dniUsuario'=>$request->getVar('inputDni'),
			'userBirthday'=>$request->getVar('inputFecNac'),
			'useradress'=>$request->getVar('inputAddress'),
			'usertel'=>$request->getVar('inputTel'),
			'useremail'=>$request->getVar('inputEmail'),
		);
		// dd($data);
		$validation->setRules([
			'inputName' => 'required|min_length[5]',
		  	'inputSurname'=>'required|min_length[3]',
			'inputDni'=>'required|min_length[7]|max_length[8]|numeric',
			'inputFecNac'=>'required',
			'inputAddress'=>'required|min_length[3]|alpha_numeric_space',
			'inputTel'=>'required|min_length[7]|numeric',
			'inputEmail'=>'required|valid_email',
		],
		[   // Errores-Mensajes
			'inputName' =>[
				'required'=>'Debe ingresar una contraseña',
				'min_length'=>'Nombre ingresado invalido',
			],
			'inputSurname' => [
				'required' => 'Debe ingresar una contraseña',
				'min_length'=>'Apellido ingresado invalido',
			],
			'inputDni' => [
				'required' => 'Debe ingresar una contraseña',
				'min_length'=>'DNI ingresado invalido',
				'max_length'=>'DNI ingresado invalido',
				'numeric'=>'Debe ingresar un DNI valido sin caracteres alfabeticos',
			],
			'inputFecNac' => [
				'required' => 'Debe ingresar una fecha de nacimiento',
			],
			'inputAddress' => [
				'required' => 'Debe ingresar una direccion',
				'min_length'=>'Debe ingresar una direccion valida',
				'alpha_numeric_space'=>'Debe ingresar una direccion sin caracteres especiales'
			],
			'inputTel' => [
				'required' => 'Debe ingresar un numero de telefono',
				'min_length'=>'Debe ingresar un numero de telefono valido',
				'numeric'=>'Debe ingresar un numero de telefono valido sin caracteres alfabeticos',
			],
			'inputEmail' => [
				'required' => 'Debe ingresar una contraseña',
				'valid_email'=>'Debe ingresar una direccion de correo valida',
			],
		]
		);
		if (!$validation->withRequest($this->request)->run()) {
			return  redirect()->back()->with('errors',$validation->getErrors())->withInput();
		}else {
			$user= new User($data);
			if (true!=$userModel->update($user->getIDUser(), ['username' => $user->getUsername(),	'usersurname'=>$user->getUsersurname(),'dniUsuario'=>$user->getuserDni(),'userBirthday'=>$user->getuserBirthday(),'useradress'=>$user->getuseradress(),'usertel'=>$user->getUserTel(),'useremail'=>$user->getuseremail()])) {
				return  redirect()->back()->with('msg',['type'=> 'danger', 'body'=>'Error al actualizar sus datos. Vuelve a intentarlo.'])->withInput();
			}else {
				return  redirect()->back()->with('msg',['type'=> 'success', 'body'=>'El usuario pudo modificar sus datos con exito.']);
			}
		}
	}
	public function guardarPassword()
	{
		$validation =  \Config\Services::validation();
		$request= \Config\Services::request();
		$userModel= model('UserModel');
		
		$data=array(
			'id_user'=>$request->getVar('idUser'),
			'password'=>$request->getVar('inputPasswordNew')
		);
		$validation->setRules([
			'inputPasswordNew' => 'required|min_length[8]|matches[inputConfirmPasswordNew]',
		  	'inputConfirmPasswordNew'=>'required|min_length[8]',
		],
		[   // Errores-Mensajes
			'inputPasswordNew' =>[
				'required'=>'Debe ingresar una contraseña',
				'min_length'=>'Usa 8 caracteres o más para tu contraseña',
				'matches' => 'Las contrase&ntilde;as no coinciden. Vuelve a intentarlo.'
			],
			'inputConfirmPasswordNew' => [
				'required' => 'Debe ingresar una contraseña',
				'min_length'=>'Usa 8 caracteres o más para tu contraseña',
			],
			
		]
		);
		if (!$validation->withRequest($this->request)->run()) {
			return  redirect()->back()->with('errors',$validation->getErrors());
		}else {
			$user= new User($data);
			if (true!=$userModel->update($user->getIDUser(), ['password' => $user->getPassword(),	'tokenPassword'=>null,'dateTokenPassword'=>null])) {
				return  redirect()->back()->with('msg',['type'=> 'danger', 'body'=>'Error al cambiar su contrase&ntilde;a. Vuelve a intentarlo.']);
			}else {
				return  redirect()->back()->with('msg',['type'=> 'success', 'body'=>'El usuario pudo cambiar su contrase&ntilde;a. con exito.']);
			}
		}
	}
	public function reservasCanceladas()
	{
		$data['title']="Mis Reservas";
		$db = \Config\Database::connect();
		$condition=[
			'estadoReserva'=>'Cancelado',
			'id_user'=>session()->get('id_user'),
		];
		$query = $db->table('reserva')->where($condition)->get();
		$data['title']="Mis Reservas Canceladas";
		$data['reservasCanceladas']=$query->getResult('array');
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Clients/reservasCanceladas',$data);
	}
	public function reservasEnCurso()
	{
		$data['title']="Mis Reservas En Curso";
		$db = \Config\Database::connect();
		$condition=[
			'estadoReserva'=>'En curso',
			'id_user'=>session()->get('id_user'),
		];
		$query = $db->table('reserva')->where($condition)->get();
		$data['title']="Mis Reservas En Curso";
		$data['reservasEnCurso']=$query->getResult('array');
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Clients/reservasEnCurso',$data);
	}
	public function obtenerReservaCliente(){
		$request= \Config\Services::request();
        $db = \Config\Database::connect();
		$idReserva=intval($request->getPostGet('id'));
		$query = $db->table('reserva')->where('idReserva', $idReserva)->get();
		$query1 = $db->query('call cantiPedidos("'.$idReserva.'");');
		$query2 = $db->query('call buscarPedidoPlatoCliente("'.$idReserva.'");');
		$query3 = $db->query('call buscarPedidoBebidaCliente("'.$idReserva.'");');
		$data=[
			'reserva'=>$query->getResult('array'),
			'cantPedido'=>$query1->getResult('array'),
			'platos'=>$query2->getResult('array'),
			'bebidas'=>$query3->getResult('array')
		];
			
		echo json_encode($data);

	}
	public function reservasRealizadas(){
		$db = \Config\Database::connect();
		$condition=[
			'estadoReserva'=>'Hecha',
			'id_user'=>session()->get('id_user'),
		];
		$query = $db->table('reserva')->where($condition)->get();
		$data['title']="Mis Reservas Realizadas";
		$data['reservasHechas']=$query->getResult('array');
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Clients/reservasRealizadas',$data);
	}
	public function completarEncuesta(){
        $data['title']="Encuesta";
		$estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Clients/encuesta');
        return $estructura;
    }
	public function enviarEncuesta(){
        $db = \Config\Database::connect();
        $request= \Config\Services::request();
        switch ($request->getPostGet('valor')) {
            case 'Mala':
                $respuesta="Mala";
                break;
            case 'Buena':
                $respuesta="Buena";
                break;
            case 'Muy Buena':
                $respuesta="Muy Buena";
                break;
            default:
                $respuesta="Sin Calificacion";
                break;
        }
		
		$idEncuesta=uniqid('', true);
		$data=[
			'idEncuesta'=>$idEncuesta,
            'idPregunta'=>1,
			'calificacionEncuesta'=>$respuesta,
            'descripcionEncuesta'=>'Valoracion del proceso de realizacion de una reserva',
        ];
		// dd($data);
		$db->table('encuesta')->insert($data);
		$db->query('UPDATE `reserva` SET `idEncuesta`="'.$idEncuesta.'" WHERE idReserva='.session()->get('idReserva'));
		
        return redirect()->route('homeClient');
    }
	public function signout(){
		session()->destroy();
		return redirect()->route('home');
	}
}