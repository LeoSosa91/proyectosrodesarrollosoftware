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
		// .view('Front/script_client')
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
	public function reserva()
	{
		$modelPlatos= model('FoodModel');
		$modelBebidas= model('BeverageModel');
		$platos=$modelPlatos->orderBy('idCategoriaPlato', 'asc')->findAll();
		$bebidas=$modelBebidas->orderBy('idCategoriaBebida', 'asc')->findAll();
		$data['title']="Reservar";
		$data['platos']=$platos;
		$data['bebidas']=$bebidas;	
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Clients/reservar',$data).view('Front/script_client');
	}
	public function guardarReserva(){
		$request= \Config\Services::request();
		
		$userModel = model('Usermodel');
		$user = $userModel->getUserBy('id_user',$request->getPostGet('idUser'));
		$data=array(
			'asistenciaReserva'=>'En espera',
			'fechaReserva'=>$request->getPostGet('fechaRes'),
			'estadoReserva'=>'En curso',
			'precioTotalReserva'=>doubleval($request->getPostGet('preciototal')),
			'turnoReserva'=>$request->getPostGet('turno'),
			'idMesa'=>intval($request->getPostGet('idMesaRes')),
			'horario'=>$request->getPostGet('horario'),
			'dniUsuario'=>intval($user->getuserDni()),
			'idEncuesta'=>null ,
			'idPromocion'=>intval($request->getPostGet('idprom')),
		);
		$array = json_decode($request->getPostGet('pedidos'),True);

		$db      = \Config\Database::connect();
		$db->table('reserva')->insert($data);
		
		//Busca reserva en base y la almacena en un variable--inicio
		$query=$db->query('call buscarReserva("'.$data['fechaReserva'].'","'.$data['horario'].'","'.$data['idMesa'].'")');
		
		foreach ($query->getResult() as $row) {
			$idReserva=$row->idReserva;
		}
		//Busca reserva en base y la almacena en un variable--fin

		$newdata=[
            'id_user'=>session()->get('id_user'),
			'group'=>session()->get('group'),
            'idReserva'=>$idReserva,
            'login'=>TRUE,
        ];

        $this->session->set($newdata);
		// Se inserta en tabla pedido los diferentes pedidos/menus pedidos por el cliente--inicio
		for ($index=0; $index <sizeof($array) ; $index++) { 
			$pedidos[]=[
				'observacionPedido' =>"Pedido completo",
				'detallePlatoAlergia'=>$array[$index]['alergia'],
				'idReserva'=>$idReserva,
			];
		}
		$db->table('pedido')->insertBatch($pedidos);
		// Se inserta en tabla pedido los diferentes pedidos/menus pedidos por el cliente--fin

		//Busca numero de pedido en base y la almacena en un variable--inicio
		$query1=$db->query('call obtenerNumeroPedido('.$idReserva.')');
		$listaNroPedido=[];
		foreach ($query1->getResult() as $row) {
			array_push($listaNroPedido,$row->nroPedido);
		}
		//Busca numero de pedido en base y la almacena en un variable--fin

		//Almacenar los platos y bebidas en arrays para luego ser enviados a base-- inicio
		for ($index=0; $index <sizeof($array) ; $index++) { 
		
			for ($p=0; $p <sizeof($array[$index]['platos']) ; $p++) { 
				$pedidosPlatos[]=[
					'nroPedido' =>$listaNroPedido[$index],
					'idPlato'=>$array[$index]['platos'][$p]['id'],
				];
			}

			for ($r=0; $r <sizeof($array[$index]['bebidas']) ; $r++) { 
				$pedidosBebidas[]=[
					'nroPedido' =>$listaNroPedido[$index],
					'idBebida'=>$array[$index]['bebidas'][$r]['id'],
				];
			}
		}
		//Almacenar los platos y bebidas en arrays para luego ser enviados a base-- fin

		//--Envio de datos a tabla pedidoPlato y pedidoBebida -- inicio
		$db->table('pedidoPlato')->insertBatch($pedidosPlatos);
		$db->table('pedidoBebida')->insertBatch($pedidosBebidas);
		//--Envio de datos a tabla pedidoPlato y pedidoBebida -- fin

		return redirect()->route('completarEncuesta');
	}
	public function modificarDatosReserva(){
		$request= \Config\Services::request();
		$db = \Config\Database::connect();
		$data=array(
			// 'idReserva'=>intval($request->getPostGet('idReserva')),
			'fechaReserva'=>$request->getPostGet('inputFecha'),
			'estadoReserva'=>'En curso',
			'turnoReserva'=>$request->getPostGet('idTurnoRes'),
			'idMesa'=>intval($request->getPostGet('idMesaRes')),
			'horario'=>$request->getPostGet('idHora'),
		);
		
		$query = $db->table('reserva')->where('idReserva', intval($request->getPostGet('idReserva')))->update($data);
		if ($query) {
			return  redirect()->route('reservasEnCursoClient')->with('msg',['type'=> 'success', 'body'=>'Se modifico con exito su reserva.']);
		} else {
			return  redirect()->route('reservasEnCursoClient')->with('msg',['type'=> 'danger', 'body'=>'Error, no se modifico su reserva. Intentelo mas tarde']);
		}
	}
	public function cancelarReserva(){
        $request= \Config\Services::request();
        $db = \Config\Database::connect();
        $tipoCancelacion=$request->getPostGet('tipoCancelacion');
        $idReservaCancelar=$request->getPostGet('idReservaCancelar');

        if ($tipoCancelacion=="SinPenalidad") {
            $query=$db->query('UPDATE `reserva` SET `asistenciaReserva`="No Asistio",`estadoReserva`= "Cancelado" WHERE idReserva='.$idReservaCancelar);
            if ($query) {
                return  redirect()->route('homeClient')->with('msg',['type'=> 'success', 'body'=>'Se cancelo con exito su reserva.']);
            } else {
                return  redirect()->route('homeClient')->with('msg',['type'=> 'danger', 'body'=>'Error, no se cancelo su reserva. Intentelo mas tarde']);
            }
        } 
		else {
			
			$penalidad = [
				'fechaPenalidadCliente' => date("Y-m-d"),
				'horaPenalidadCliente'  => date("H:i:s"),
				'estadoPenalidadCliente'  => 'Activo',
				'fechaPenalidadClienteFin'  => date("Y-m-d", mktime(date('H'), date('i'), date('s'), date('m'), date('d')+14, date('Y'))),
				'idPenalidad'  => 2,
				'id_user'  => session()->get('id_user'),
			];
			
			$query=$db->table('penalidadCliente')->insert($penalidad);
			$reserva=[
				'asistenciaReserva'=>"No Asistio",
				'estadoReserva'=>"Cancelado",
			];
			
			$query1=$db->table('reserva')->where('idReserva', $idReservaCancelar)->update($reserva);
			if ($query && $query1) {
				return  redirect()->route('homeClient')->with('msg',['type'=> 'warning', 'body'=>'Se cancelo con exito su reserva. Pero obtuvo una penalidad']);
            } else {
                return  redirect()->route('homeClient')->with('msg',['type'=> 'danger', 'body'=>'Error, no se cancelo su reserva. Intentelo mas tarde']);
            }

        }
	}
	public function reservasCanceladas()
	{
		$data['title']="Mis Reservas";
		$db = \Config\Database::connect();
		$query = $db->table('reserva')->where('estadoReserva', "Cancelado")->get();
		$data['title']="Mis Reservas Canceladas";
		$data['reservasCanceladas']=$query->getResult('array');
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Clients/reservasCanceladas',$data);
	}
	public function reservasEnCurso()
	{
		$data['title']="Mis Reservas En Curso";
		$db = \Config\Database::connect();
		$query = $db->table('reserva')->where('estadoReserva', "En curso")->get();
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
	public function modificarPedidoPlatoBebidaCliente(){
		$request= \Config\Services::request();
        $db = \Config\Database::connect();
		$idViejo= $request->getPostGet('inputIdAnterior') ;
        $idNuevo= $request->getPostGet('selectModPedPlatoBebida');
        $nroPedido=intval($request->getPostGet('inputNroPedido'));
		$cantidad=intval($request->getPostGet('inputModCantidad'));
		$tipo=$request->getPostGet('inputTipo');
		$idReserva=intval($request->getPostGet('inputIdReserva'));
		// dd($idReserva);
		switch ($tipo) {
			case 'Bebida':
				$pedido=[
					'idBebida'=>$idNuevo,
					'cantidad'=>$cantidad,
				];
				$data=[
					'nroPedido'=>$nroPedido,
					'idBebida'=>$idViejo,
				];
				
				$query=$db->table('pedidobebida')->where($data)->update($pedido);
				//dd($pedido);
				$total=$db->query('call calcularTotalReserva('.$idReserva.')')->getResultArray();
				// dd(doubleval($total[0]['sum(total)']) );
				$reserva=[
					'precioTotalReserva'=>doubleval($total[0]['sum(total)']),
				];
				$query1=$db->table('reserva')->where('idReserva',$idReserva)->update($reserva);
				//dd($db->query('call calcularTotalReserva('.$idReserva.')')->getResultArray());
				if ($query) {
					return  redirect()->route('reservasEnCursoClient')->with('msg',['type'=> 'success', 'body'=>'Se modifico con exito su bebida del pedido.']);
				}
				return  redirect()->route('reservasEnCursoClient')->with('msg',['type'=> 'danger', 'body'=>'Error, no se pudo modificar bebida de su pedido. Intentelo mas tarde']);
				break;
			case 'Plato':
				$pedido=[
					'idPlato'=>$idNuevo,
					'cantidad'=>$cantidad,
				];
				$data=[
					'nroPedido'=>$nroPedido,
					'idPlato'=>$idViejo,
				];
				
				$query=$db->table('pedidoplato')->where($data)->update($pedido);
				$total=$db->query('call calcularTotalReserva('.$idReserva.')')->getResultArray();
				$reserva=[
					'precioTotalReserva'=>doubleval($total[0]['sum(total)']),
				];
				$query1=$db->table('reserva')->where('idReserva',$idReserva)->update($reserva);
				if ($query) {
					return  redirect()->route('reservasEnCursoClient')->with('msg',['type'=> 'success', 'body'=>'Se modifico con exito su plato del pedido.']);
				}
				return  redirect()->route('reservasEnCursoClient')->with('msg',['type'=> 'danger', 'body'=>'Error, no se pudo modificar plato de su pedido. Intentelo mas tarde']);
				break;
				
			default:
				return  redirect()->route('reservasEnCursoClient')->with('msg',['type'=> 'danger', 'body'=>'Error, no se pudo modificar plato/bebida de su pedido. Intentelo mas tarde']);
				break;
		}
		
	}
	
	public function reservasRealizadas()
	{
		$db = \Config\Database::connect();
		$query = $db->table('reserva')->where('estadoReserva', "Hecha")->get();
		$data['title']="Mis Reservas Realizadas";
		$data['reservasHechas']=$query->getResult('array');
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Clients/reservasRealizadas',$data);
	}
	public function consultarReserva()
	{
		$request= \Config\Services::request();
		$fechaRes=$request->getPostGet('fechaRes');
		$horaRes=$request->getPostGet('horario');
		$cantPersRes=null;
		$idUser=intval(session()->get('idUser'));
		$numeroMesa = null;
		$db = \Config\Database::connect();
		$query=$db->query('SELECT idReserva,dniUsuario FROM reserva WHERE fechaReserva = "'.$fechaRes.'" AND id_user = "'.$idUser.'"');
		$row = $query->getResultArray();
			if (isset($row)==false){
				echo json_encode(array("status" => false ));
			}else{
				// echo json_encode(array("status" => true ));
				switch (intval($request->getPostGet('cantPers'))) {
				case (intval($request->getPostGet('cantPers')) <=2):
					$cantPersRes=2;
					break;
					case (intval($request->getPostGet('cantPers')) > 2):
					$cantPersRes=4;
					break;
				}
				$query = $db->query('select m.idMesa from mesa as m left join reserva as r on m.idMesa = r.idMesa and r.fechaReserva = "'.$fechaRes.'" and r.horario= "'.$horaRes.'" where m.cantPersonasEnMesa = '.$cantPersRes.' and r.idReserva is null limit 1 ');

				if (!$query->getResult()) {
					$data=array(
						'numeroMesa'=>0,
					);
					echo json_encode(array("status" => false,"statusMesaEncontrada" => false));
				} else {
					foreach ($query->getResult('array') as $row)
					{
						$numeroMesa = intval($row['idMesa']);
					}
					$data=array(
						'numeroMesa'=>$numeroMesa,
					);
					echo json_encode(array("status" => true ,'data' => $data,"statusMesaEncontrada" => true));
				}

			}
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
