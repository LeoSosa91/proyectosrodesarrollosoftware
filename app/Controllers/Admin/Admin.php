<?php namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Entities\User;
class Admin extends BaseController{

    public function index()
	{
        if (!session()->is_logged) {
			return redirect()->route('home');
		}
		$data['title']='Home';
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Admin/home').view('Admin/footer');
    }
	public function infoAdmin()
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
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Admin/infoAdmin',$data).view('Admin/footer');
	}
	public function guardarInfoPersonal(){
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
	public function drinkAdd()
	{
		$db      = \Config\Database::connect();
		$builder = $db->table('categoriabebida');
		$query   = $builder->get();
		// $tipoBebida='';
		// foreach ($query->getResult() as $row)
		// {
		// 	$tipoBebida.='<option';
		// 	$tipoBebida.=(old('typeDrink') == "$row->idCategoriaBebida") ? 'selected' : '';
		// 	$tipoBebida.=' value="'.$row->idCategoriaBebida.'">'.$row->nombreCategoriaBebida.'</option>';
		// }
		$data['title']='Agregar bebida';
		$data['options']=$query->getResult('array');
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Admin/drinkAdd',$data).view('Admin/footer');
	}
	public function drinkEdit()
	{
		$db      = \Config\Database::connect();
		$builder = $db->table('categoriabebida');
		$query   = $builder->get();
		$data['title']='Editar bebida';
		$beverageModel= model('BeverageModel');
		$beverage=$beverageModel->orderBy('idCategoriaBebida', 'asc')->findAll();
		$data['beverages']=$beverage;
		$data['typeBeverages']=$query->getResult('array');
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Admin/drinkEdit',$data);
	}
	public function report()
	{
		$data['title']="Reportes";
		// .view('Admin/footer')
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Admin/report',$data);
	}

  private function obtenerReporteRankingPlatos($fechaInicio,$fechaFinal) {

      /*$request= \Config\Services::request();
      $fechaInicio=$request->getPostGet('inputFechaInicioReportePlatos');
      $fechaFinal=$request->getPostGet('inputFechaHastaReportePlatos');*/

      if ($fechaInicio == "" || $fechaFinal == "") {
          if ($fechaInicio == "" && $fechaFinal == "") {
              $data['title']="Reportes";
              $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha desde y hasta </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
              $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
              return $estructura;
          }else{
              if ($fechaInicio == "" && $fechaFinal != "") {
                  $data['title']="Reportes";
                  $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha desde </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                  $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
                  return $estructura;
              }else{
                  $data['title']="Reportes";
                  $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha hasta </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                  $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
                  return $estructura;
              }
          }

      }else{

      $db = \Config\Database::connect();

      $query = $db->query('select p.nombrePlato, count(p.nombrePlato) as cantidad from reserva as r inner join pedido as g inner join plato as p inner join pedidoplato as c where (r.fechaReserva between "'.$fechaInicio.'" and "'.$fechaFinal.'") and r.idReserva = g.idReserva and g.nroPedido = c.nroPedido and c.idPlato = p.idPlato group by p.nombrePlato order by cantidad desc,p.nombrePlato limit 5');

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
      $pdf->Cell(6,10,'Los platos mas solicitados son: ',0,0,'C');
      $pdf->Ln(15);

      if (count($query->getResultArray())==0) {
          $data['title']="Reportes";
          $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se encontraron resultados </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
          $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
          return $estructura;
      } else {

          $pdf->SetFont('Arial','B',14);
          $pdf->Cell(60,7,"Nombre del plato",1);
          $pdf->Cell(30,7,"Cantidad",1);
          $pdf->Ln();

      foreach ($query->getResultArray() as $row)
  {
          $pdf->SetFont('Arial','',13);
          $pdf->Cell(60,7,$row['nombrePlato'],1);
          $pdf->Cell(30,7,$row['cantidad'],1);
          $pdf->Ln();
  }
      $data = [];
      $hoy = date("dmyhis");
      $pdfFilePath = "RankingPlatos".$hoy.".pdf";
      $this->response->setHeader('Content-Type', 'application/pdf');
      $pdf->Output('D',$pdfFilePath,false);
      //$pdf->Output();
      }
      }
  }

  private function obtenerReporteReservasCanceladas($fechaInicio,$fechaFinal){

  /*$request= \Config\Services::request();
  $fechaInicio=$request->getPostGet('inputFechaInicioReportePlatos1');
  $fechaFinal=$request->getPostGet('inputFechaFinReportePlatos1');*/

  if ($fechaInicio == "" || $fechaFinal == "") {
      if ($fechaInicio == "" && $fechaFinal == "") {
          $data['title']="Reportes";
          $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha desde y hasta </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
          $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
          return $estructura;
      }else{
          if ($fechaInicio == "" && $fechaFinal != "") {
              $data['title']="Reportes";
              $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha desde </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
              $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
              return $estructura;
          }else{
              $data['title']="Reportes";
              $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha hasta </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
              $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
              return $estructura;
          }
      }

  }else{

  $db = \Config\Database::connect();

  $query = $db->query('select dniUsuario, turnoReserva, horario, idMesa, fechaReserva from reserva where (fechaReserva between "'.$fechaInicio.'" and "'.$fechaFinal.'") and (estadoReserva = "Cancelada") order by fechaReserva desc');

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
  $pdf->Cell(4,10,'Las reservas canceladas son: ',0,0,'C');
  $pdf->Ln(15);

  $pdf->SetFont('Arial','B',14);
  $pdf->Cell(37,7,"Dni usuario",1);
  $pdf->Cell(25,7,"Turno",1);
  $pdf->Cell(40,7,"Horario",1);
  $pdf->Cell(31,7,"Num mesa",1);
  $pdf->Cell(35,7,"fecha reserva",1);
  $pdf->Ln();

  if (count($query->getResultArray())==0) {
      $data['title']="Reportes";
      $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se encontraron resultados </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
      $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
      return $estructura;
  } else {

  foreach ($query->getResultArray() as $row)
{
      $pdf->SetFont('Arial','',13);
      $pdf->Cell(37,7,$row['dniUsuario'],1);
      $pdf->Cell(25,7,$row['turnoReserva'],1);
      $pdf->Cell(40,7,$row['horario'],1);
      $pdf->Cell(31,7,$row['idMesa'],1);
      $fechaReserva6 = date("d/m/Y", strtotime($row['fechaReserva']));
      $pdf->Cell(35,7,$fechaReserva6,1);
      $pdf->Ln();
}
  $data = [];
  $hoy = date("dmyhis");
  $pdfFilePath = "ReservasCanceladas".$hoy.".pdf";
  $this->response->setHeader('Content-Type', 'application/pdf');
  $pdf->Output('D',$pdfFilePath,false);
  //$pdf->Output();
  }
}

}

public function obtenerReporteHorariosDemandados($fechaInicio,$fechaFinal){
    /*$request= \Config\Services::request();
    $fechaInicio=$request->getPostGet('inputFechaInicioReportePlatos2');
    $fechaFinal=$request->getPostGet('inputFechaFinReportePlatos2');*/

    if ($fechaInicio == "" || $fechaFinal == "") {
        if ($fechaInicio == "" && $fechaFinal == "") {
            $data['title']="Reportes";
            $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha desde y hasta </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
            return $estructura;
        }else{
            if ($fechaInicio == "" && $fechaFinal != "") {
                $data['title']="Reportes";
                $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha desde </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
                return $estructura;
            }else{
                $data['title']="Reportes";
                $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha hasta </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
                return $estructura;
            }
        }

    }else{

    $db = \Config\Database::connect();

    $query = $db->query('select horario, count(*) as cantidad from reserva where fechaReserva between "'.$fechaInicio.'" and "'.$fechaFinal.'" group by horario having count(*)>1 order by cantidad desc limit 5');

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
    $pdf->Cell(15,10,'Los horarios mas demandados son: ',0,0,'C');
    $pdf->Ln(15);

    if (count($query->getResultArray())==0) {
        $data['title']="Reportes";
        $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se encontraron resultados </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
        return $estructura;
    } else {

        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(35,7,"Horarios",1);
        $pdf->Cell(30,7,"Cantidad",1);
        $pdf->Ln();

    foreach ($query->getResultArray() as $row)
{
        $pdf->SetFont('Arial','',13);
        $pdf->Cell(35,7,$row['horario'],1);
        $pdf->Cell(30,7,$row['cantidad'],1);
        $pdf->Ln();
}
    $data = [];
    $hoy = date("dmyhis");
    $pdfFilePath = "HorariosDemandados".$hoy.".pdf";
    $this->response->setHeader('Content-Type', 'application/pdf');
    $pdf->Output('D',$pdfFilePath,false);
    //$pdf->Output();
    }
}

}

public function obtenerReporteclientesNoAsistencia($fechaInicio,$fechaFinal){
    /*$request= \Config\Services::request();
    $fechaInicio=$request->getPostGet('inputFechaInicioReportePlatos3');
    $fechaFinal=$request->getPostGet('inputFechaFinReportePlatos3');*/

    if ($fechaInicio == "" || $fechaFinal == "") {
        if ($fechaInicio == "" && $fechaFinal == "") {
            $data['title']="Reportes";
            $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha desde y hasta </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
            return $estructura;
        }else{
            if ($fechaInicio == "" && $fechaFinal != "") {
                $data['title']="Reportes";
                $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha desde </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
                return $estructura;
            }else{
                $data['title']="Reportes";
                $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha hasta </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
                return $estructura;
            }
        }

    }else{

    $db = \Config\Database::connect();

    $query = $db->query('select u.dniUsuario, u.nombreUsuario, u.apellidoUsuario, u.emailUsuario, u.telefono, r.fechaReserva from reserva as r inner join usuario as u where (r.fechaReserva between "'.$fechaInicio.'" and "'.$fechaFinal.'") and (r.asistenciaReserva = "No asistio") and r.id_user = u.id_user order by u.apellidoUsuario asc');

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
    $pdf->Cell(48,10,'Los clientes que no asistieron a las reservas son: ',0,0,'C');
    $pdf->Ln(15);

    if (count($query->getResultArray())==0) {
        $data['title']="Reportes";
        $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se encontraron resultados </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
        return $estructura;
    } else {

        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(30,7,"Dni usuario",1);
        $pdf->Cell(28,7,"Nombre",1);
        $pdf->Cell(28,7,"Apellido",1);
        $pdf->Cell(45,7,"Email",1);
        $pdf->Cell(28,7,"telefono",1);
        $pdf->Cell(37,7,"Fecha reserva",1);
        $pdf->Ln();

    foreach ($query->getResultArray() as $row)
{
        $pdf->SetFont('Arial','',13);
        $pdf->Cell(30,7,$row['dniUsuario'],1);
        $pdf->Cell(28,7,$row['nombreUsuario'],1);
        $pdf->Cell(28,7,$row['apellidoUsuario'],1);
        $pdf->Cell(45,7,$row['emailUsuario'],1);
        $pdf->Cell(28,7,$row['telefono'],1);
        $fechaInicio8 = date("d/m/Y", strtotime($row['fechaReserva']));
        $pdf->Cell(37,7,$fechaInicio8,1);
        $pdf->Ln();
  }
    $data = [];
    $hoy = date("dmyhis");
    $pdfFilePath = "ClientesNoAsistieron".$hoy.".pdf";
    $this->response->setHeader('Content-Type', 'application/pdf');
    $pdf->Output('D',$pdfFilePath,false);
    //$pdf->Output();
    }
}
}

public function obtenerReporteReservasDelDia($fechaInicio,$fechaFinal){
    /*$request= \Config\Services::request();
    $fechaInicio=$request->getPostGet('inputFechaInicioReportePlatos4');
    $fechaFinal=$request->getPostGet('inputFechaFinReportePlatos4');*/

    if ($fechaInicio == "" || $fechaFinal == "") {
        if ($fechaInicio == "" && $fechaFinal == "") {
            $data['title']="Reportes";
            $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha desde y hasta </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
            return $estructura;
        }else{
            if ($fechaInicio == "" && $fechaFinal != "") {
                $data['title']="Reportes";
                $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha desde </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
                return $estructura;
            }else{
                $data['title']="Reportes";
                $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se ingresó fecha hasta </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
                return $estructura;
            }
        }

    }else{

    $db = \Config\Database::connect();


    $query = $db->query('select dniUsuario, turnoReserva, horario, idMesa, fechaReserva, asistenciaReserva from reserva where fechaReserva between "'.$fechaInicio.'" and "'.$fechaFinal.'" and (estadoReserva = "En Curso") order by fechaReserva desc');

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
    $pdf->Cell(51,10,'Las reservas del rango de fecha seleccionada son: ',0,0,'C');
    $pdf->Ln(15);

    if (count($query->getResultArray())==0) {
        $data['title']="Reportes";
        $data['errorAlert']='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong> No se encontraron resultados </strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $estructura=view('Front/head',$data).view('Front/header').view('Front/sidebar').view('admin/report',$data);
        return $estructura;
    } else {

    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(38,7,"Dni usuario",1);
    $pdf->Cell(25,7,"Turno",1);
    $pdf->Cell(30,7,"Horario",1);
    $pdf->Cell(31,7,"Num mesa",1);
    $pdf->Cell(30,7,"Fecha",1);
    $pdf->Cell(33,7,"Asistencia",1);
    $pdf->Ln();

    foreach ($query->getResultArray() as $row)
{
        $pdf->SetFont('Arial','',13);
        $pdf->Cell(38,7,$row['dniUsuario'],1);
        $pdf->Cell(25,7,$row['turnoReserva'],1);
        $pdf->Cell(30,7,$row['horario'],1);
        $pdf->Cell(31,7,$row['idMesa'],1);
        $fechaInicio7 = date("d/m/Y", strtotime($row['fechaReserva']));
        $pdf->Cell(30,7,$fechaInicio7,1);
        $pdf->Cell(33,7,$row['asistenciaReserva'],1);
        $pdf->Ln();
}
    $data = [];
    $hoy = date("dmyhis");
    $pdfFilePath = "ReservasDia".$hoy.".pdf";
    $this->response->setHeader('Content-Type', 'application/pdf');
    $pdf->Output('D',$pdfFilePath,false);
    //$pdf->Output();
    }
}

}


  public function crearReporte(){
    $request= \Config\Services::request();
    $fechaInicio=$request->getPostGet('inputFechaInicioReportePlatos');
    $fechaFinal=$request->getPostGet('inputFechaHastaReportePlatos');
    $tipoRepo=$request->getPostGet('inputTipoReporte');
    switch ($tipoRepo) {
      case '1':
        $this -> obtenerReporteRankingPlatos($fechaInicio,$fechaFinal);
        //return $repo;
        break;
        case '2':
          $this -> obtenerReporteReservasCanceladas($fechaInicio,$fechaFinal);
          //return $repo;
          break;
          case '3':
            $this -> obtenerReporteHorariosDemandados($fechaInicio,$fechaFinal);
            //return $repo;
            break;
            case '4':
              $this -> obtenerReporteclientesNoAsistencia($fechaInicio,$fechaFinal);
              //return $repo;
              break;
              case '5':
                return $this ->obtenerReporteReservasDelDia($fechaInicio,$fechaFinal);
                //return $repo;
                break;
      /*default:
        // code...
        break;*/
    }

  }

  public function imprimirReporte(){
    $request= \Config\Services::request();
    $fechaInicio=$request->getPostGet('FechaInicioReportePlatos');
    $fechaFinal=$request->getPostGet('FechaHastaReportePlatos');
    $tipoRepo=$request->getPostGet('TipoReporte');

    switch ($tipoRepo) {
      case '1':
      //Ranking platos
        $db = \Config\Database::connect();
        $query = $db->query('select p.nombrePlato, count(p.nombrePlato) as cantidad from reserva as r inner join pedido as g inner join plato as p inner join pedidoplato as c where (r.fechaReserva between "'.$fechaInicio.'" and "'.$fechaFinal.'") and r.idReserva = g.idReserva and g.nroPedido = c.nroPedido and c.idPlato = p.idPlato group by p.nombrePlato order by cantidad desc,p.nombrePlato limit 5');
        echo json_encode($query->getResultArray());
        break;
        case '2':
        //reservas canceladas
          $db = \Config\Database::connect();
          $query = $db->query('select id_user, turnoReserva, horario, idMesa, fechaReserva from reserva where (fechaReserva between "'.$fechaInicio.'" and "'.$fechaFinal.'") and (estadoReserva = "Cancelada") order by fechaReserva desc');
          echo json_encode($query->getResultArray());
          break;
          case '3':
          //horarios mas demandados
            $db = \Config\Database::connect();
            $query = $db->query('select horario, count(*) as cantidad from reserva where fechaReserva between "'.$fechaInicio.'" and "'.$fechaFinal.'" group by horario having count(*)>1 order by cantidad desc limit 5');
            echo json_encode($query->getResultArray());
            break;
            case '4':
            //clientes no asistencia
              $db = \Config\Database::connect();
              $query = $db->query('select u.dniUsuario, u.nombreUsuario, u.apellidoUsuario, u.emailUsuario, u.telefono, r.fechaReserva from reserva as r inner join usuario as u where (r.fechaReserva between "'.$fechaInicio.'" and "'.$fechaFinal.'") and (r.asistenciaReserva = "No asistio") and r.id_user = u.id_user order by u.apellidoUsuario asc');
              echo json_encode($query->getResultArray());
              break;
              case '5':
              //reservas del dia
                $db = \Config\Database::connect();
                $query = $db->query('select dniUsuario, turnoReserva, horario, idMesa, fechaReserva, asistenciaReserva from reserva where fechaReserva between "'.$fechaInicio.'" and "'.$fechaFinal.'" and (estadoReserva = "En Curso") order by fechaReserva desc');
                echo json_encode($query->getResultArray());
                break;
    }
  }
	public function encuesta()
	{
		$data['title']="Encuesta";
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Admin/encuesta').view('Admin/footer');
	}
	public function listadoClientes()
	{
		$data['title']="Clientes";
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Admin/listadoClients').view('Admin/footer');
	}
	public function promocionAdd()
	{
		$data['title']="Promociones";
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Admin/promocionAdd');
	}
	public function promocionEdit()
	{
		$db      = \Config\Database::connect();
		$builder = $db->table('promocion');
		$query   = $builder->get();
		$data['title']="Promociones";
		$data['promociones']=$query->getResultArray();
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Admin/promocionEdit',$data);
	}
	public function tableEdit()
	{
		return view('Front/head').view('Front/header').view('Front/sidebar').view('Admin/tableEdit').view('Admin/footer');
	}
    public function signout()
	{
		session()->destroy();
		return redirect()->route('home');
	}
}
