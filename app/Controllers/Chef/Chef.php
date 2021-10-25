<?php namespace App\Controllers\Chef;
use App\Controllers\BaseController;
// use App\Controllers\Menu\Plato;
use App\Entities\User;
class Chef extends BaseController{
    public function index()
	{
        // if (!session()->is_logged) {
		// 	return redirect()->route('home');
		// }
		$data['title']='Home';
		return view('Front/head',$data).view('Front/header').view('Chef/home').view('Front/sidebar').view('Chef/footer');
    }
	public function infoChef()
	{
		$userModel= model('UserModel');
		$user=$userModel->asObject()->where("id_user",session('id_user'))->first();

		$data['title']="Informacion Personal";
		$data['user']=['id_user'=>$user->id_user,
						'userDni'=>$user->dniUsuario,
						'useradress'=>$user->useradress,
						'userBirthday'=>$user->userBirthday,
						'username'=>$user->username,
						'usersurname'=>$user->usersurname,
						'usertel'=>$user->usertel,
						'useremail'=>$user->useremail,];
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Chef/infoChef').view('Chef/footer');
	}
	public function guardarInfoPersonalChef(){
		$validation =  \Config\Services::validation();
		$request= \Config\Services::request();
		$userModel= model('UserModel');

		$data=array(
			'id_user'=>$request->getVar('idUser'),
			'username'=>$request->getVar('inputName'),
			'usersurname'=>$request->getVar('inputSurname'),
			'userDni'=>$request->getVar('inputDni'),
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
			if (true!=$userModel->update($user->getIDUser(), ['username' => $user->getUsername(),	'usersurname'=>$user->getUsersurname(),'userDni'=>$user->getuserDni(),'userBirthday'=>$user->getuserBirthday(),'useradress'=>$user->getuseradress(),'usertel'=>$user->getUserTel(),'useremail'=>$user->getuseremail()])) {
				return  redirect()->back()->with('msg',['type'=> 'danger', 'body'=>'Error al actualizar sus datos. Vuelve a intentarlo.'])->withInput();
			}else {
				return  redirect()->back()->with('msg',['type'=> 'success', 'body'=>'El usuario pudo modificar sus datos con exito.']);
			}
		}
	}
	public function guardarPasswordChef()
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

	public function foodManager()
	{
		$data['title']='Home';
		return view('Front/head',$data).view('Front/header').view('Chef/food').view('Front/sidebar').view('Chef/footer');
	}
	public function foodAdd()
	{
		$data['title']='Agregar platos';
		return view('Front/head',$data).view('Front/header').view('Chef/foodAdd').view('Front/sidebar').view('Chef/footer');
	}
	public function foodEdit()
	{
		$foodModel= model('FoodModel');
		$platos=$foodModel->orderBy('tipoPlato', 'asc')->findAll();
		$data['title']='Editar platos';
		$data['foods']=$platos;
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Chef/foodEdit',$data);
	}
	public function report()
	{
		$data['title']="Reportes";
		return view('Front/head',$data).view('Front/header').view('Chef/report',$data).view('Front/sidebar').view('Chef/footer');
	}

  public function obtenerPlatos($fechaInicio,$fechaFinal){
  /* $request= \Config\Services::request();
  $fechaInicio=$request->getPostGet('inputFechaInicioReportePlatos');
  $fechaFinal=$request->getPostGet('inputFechaHastaReportePlatos');*/

  if ($fechaInicio == "" || $fechaFinal == "") {
          if ($fechaInicio == "" && $fechaFinal == "") {
              $data['title']="Reportes";
          $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha desde y hasta </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
          $estructura=view('Front/head',$data).view('Front/header').view('chef/report',$data).view('Front/sidebar').view('Chef/footer');
          return $estructura;
          }else{
              if ($fechaInicio == "" && $fechaFinal != "") {
                  $data['title']="Reportes";
          $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha desde </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
          $estructura=view('Front/head',$data).view('Front/header').view('chef/report',$data).view('Front/sidebar').view('Chef/footer');
          return $estructura;
              }else{
                  $data['title']="Reportes";
          $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha hasta </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
          $estructura=view('Front/head',$data).view('Front/header').view('chef/report',$data).view('Front/sidebar').view('Chef/footer');
          return $estructura;
              }
          }

      }else{

  $db = \Config\Database::connect();

  $query = $db->query('select p.nombrePlato,g.detallePlatoAlergia, r.fechaReserva, r.idMesa, r.turnoReserva, r.horario from reserva as r inner join pedido as g inner join plato as p inner join pedidoplato as c where (r.fechaReserva between "'.$fechaInicio.'" and "'.$fechaFinal.'") and r.idReserva = g.idReserva and g.nroPedido = c.nroPedido and c.idPlato = p.idPlato and r.estadoReserva = "En curso" order by p.nombrePlato asc');

   $platos="";
      if (count($query->getResultArray())==0) {
          $data['title']="Reportes";
          $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se encontraron resultados </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
          $estructura=view('Front/head',$data).view('Front/header').view('chef/report',$data).view('Front/sidebar').view('Chef/footer');
          return $estructura;
      } else {

      $pdf = new \FPDF();
      $pdf->AddPage();
      $pdf->SetFont('Arial','B',16);
      $pdf->Cell(70);
      $pdf->Cell(40,10,"SRO",0,0,'C');
      $pdf->Ln(15);
      $pdf->SetFont('Arial','',15);
      $fechaInicio2 = date("d/m/Y", strtotime($fechaInicio));
      $pdf->Cell(47,10,"Desde: ".$fechaInicio2,0,0,'C');
      $pdf->Ln(10);
      $fechaFinal2 = date("d/m/Y", strtotime($fechaFinal));
      $pdf->Cell(45,10,"Hasta: ".$fechaFinal2,0,0,'C');
      $pdf->Ln(15);
      $pdf->Cell(35);
    $pdf->Cell(41,10,'Los platos de el rango de fecha seleccionada: ',0,0,'C');
    $pdf->Ln(15);


      $aux=true;
      foreach ($query->getResultArray() as $row)
  {
          if ($aux) {
              $mesaAux=$row['idMesa'];
              $aux=false;

              $pdf->SetFont('Arial','U',13);
              $fechaReserva4 = date("d/m/Y", strtotime($row['fechaReserva']));
              $pdf->Cell(65,10,'Reserva con fecha '.$fechaReserva4.' :',0,0,'C');
              $pdf->Ln(10);

              $pdf->SetFont('Arial','B',14);
              $pdf->Cell(55,7,"Nombre plato",1);
              $pdf->Cell(34,7,"Alergia",1);
              $pdf->Cell(30,7,"Fecha res",1);
              $pdf->Cell(20,7,"Mesa",1);
              $pdf->Cell(21,7,"turno",1);
              $pdf->Cell(23,7,"horario",1);
              $pdf->Ln();
          }
          if ($mesaAux == $row['idMesa']) {
              $pdf->SetFont('Arial','',13);
              //$pdf->Cell(41,10,'Los platos de cada uno de los pedidos de la reserva con fecha '.$row['fechaReserva'].' son: ',0,0,'C');
              $pdf->Cell(55,7,$row['nombrePlato'],1);
              $pdf->Cell(34,7,$row['detallePlatoAlergia'],1);
              $fechaReserva3 = date("d/m/Y", strtotime($row['fechaReserva']));
              $pdf->Cell(30,7,$fechaReserva3,1);
              $pdf->Cell(20,7,$row['idMesa'],1);
              $pdf->Cell(21,7,$row['turnoReserva'],1);
              $pdf->Cell(23,7,$row['horario'],1);
              $mesaAux=$row['idMesa'];
              $pdf->Ln();
          }else{
              $pdf->Ln(5);
              $pdf->SetFont('Arial','U',13);
              $fechaReserva5 = date("d/m/Y", strtotime($row['fechaReserva']));
              $pdf->Cell(65,10,'Reserva con fecha '.$fechaReserva5.' :',0,0,'C');
              $pdf->Ln(10);
              $pdf->SetFont('Arial','',13);
              $pdf->SetFont('Arial','B',14);
              $pdf->Cell(55,7,"Nombre plato",1);
              $pdf->Cell(34,7,"Alergia",1);
              $pdf->Cell(40,7,"Fecha reserva",1);
              $pdf->Cell(31,7,"Num mesa",1);
              $pdf->Cell(16,7,"turno",1);
              $pdf->Cell(23,7,"horario",1);
              $pdf->Ln();

              $pdf->SetFont('Arial','',13);
              //$pdf->Cell(41,10,'Los platos de cada uno de los pedidos de la reserva con fecha '.$row['fechaReserva'].' son: ',0,0,'C');
              $pdf->Cell(55,7,$row['nombrePlato'],1);
              $pdf->Cell(34,7,$row['detallePlatoAlergia'],1);
              $fechaReserva3 = date("d/m/Y", strtotime($row['fechaReserva']));
              $pdf->Cell(40,7,$fechaReserva3,1);
              $pdf->Cell(31,7,$row['idMesa'],1);
              $pdf->Cell(16,7,$row['turnoReserva'],1);
              $pdf->Cell(23,7,$row['horario'],1);
              $mesaAux=$row['idMesa'];
              $pdf->Ln();
          }

  }

      $data = [];
      $hoy = date("dmyhis");
      $pdfFilePath = "platosFecha".$hoy.".pdf";


      $this->response->setHeader('Content-Type', 'application/pdf');
      $pdf->Output('D',$pdfFilePath,false);
      //$pdf->Output();

      }
  }

}

  public function crearReporteChef(){
    $request= \Config\Services::request();
   $fechaInicio=$request->getPostGet('inputFechaInicioReportePlatosChef');
   $fechaFinal=$request->getPostGet('inputFechaHastaReportePlatosChef');

   $this -> obtenerPlatos($fechaInicio,$fechaFinal);
  }

  public function imprimirReporteChef(){
    $request= \Config\Services::request();
    $fechaInicio=$request->getPostGet('inputFechaInicioReportePlatosChef');
    $fechaFinal=$request->getPostGet('inputFechaHastaReportePlatosChef');

    $db = \Config\Database::connect();

    $query = $db->query('select p.nombrePlato,g.detallePlatoAlergia, r.fechaReserva, r.idMesa, r.turnoReserva, r.horario from reserva as r inner join pedido as g inner join plato as p inner join pedidoplato as c where (r.fechaReserva between "'.$fechaInicio.'" and "'.$fechaFinal.'") and r.idReserva = g.idReserva and g.nroPedido = c.nroPedido and c.idPlato = p.idPlato and r.estadoReserva = "En curso" order by p.nombrePlato asc');
    echo json_encode($query->getResultArray());
    /*$encode = array();

    while($row = mysqli_fetch_assoc($query)) {
      $encode[$row['detallePlatoAlergia']][] = $row['detallePlatoAlergia'];
}

echo json_encode($encode);*/

  }
    public function signout()
	{
		session()->destroy();
		return redirect()->route('home');
	}
}
