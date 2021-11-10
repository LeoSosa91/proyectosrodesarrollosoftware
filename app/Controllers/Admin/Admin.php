<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Controllers\Menu\Promocion;
use App\Entities\User;

class Admin extends BaseController
{

    public function index()
    {
        if (!session()->is_logged) {
            return redirect()->route('home');
        }
        $data['title'] = 'Home';
        return view('Front/head', $data) . view('Front/header') . view('Front/sidebar') . view('Admin/home') . view('Admin/footer');
    }
    public function infoAdmin()
    {
        $userModel = model('UserModel');
        $user = $userModel->asObject()->where("id_user", session('id_user'))->first();

        $data['title'] = "Informacion Personal";
        $data['user'] = [
            'id_user' => $user->id_user,
            'userDni' => $user->dniUsuario,
            'useradress' => $user->useradress,
            'userBirthday' => $user->userBirthday,
            'username' => $user->username,
            'usersurname' => $user->usersurname,
            'usertel' => $user->usertel,
            'useremail' => $user->useremail,
        ];
        return view('Front/head', $data) . view('Front/header') . view('Front/sidebar') . view('Admin/infoAdmin', $data) . view('Admin/footer');
    }
    public function guardarInfoPersonal()
    {
        $validation =  \Config\Services::validation();
        $request = \Config\Services::request();
        $userModel = model('UserModel');

        $data = array(
            'id_user' => $request->getVar('idUser'),
            'username' => $request->getVar('inputName'),
            'usersurname' => $request->getVar('inputSurname'),
            'dniUsuario' => $request->getVar('inputDni'),
            'userBirthday' => $request->getVar('inputFecNac'),
            'useradress' => $request->getVar('inputAddress'),
            'usertel' => $request->getVar('inputTel'),
            'useremail' => $request->getVar('inputEmail'),
        );
        // dd($data);
        $validation->setRules(
            [
                'inputName' => 'required|min_length[5]',
                'inputSurname' => 'required|min_length[3]',
                'inputDni' => 'required|min_length[7]|max_length[8]|numeric',
                'inputFecNac' => 'required',
                'inputAddress' => 'required|min_length[3]|alpha_numeric_punct',
                'inputTel' => 'required|min_length[7]|numeric',
                'inputEmail' => 'required|valid_email',
            ],
            [   // Errores-Mensajes
                'inputName' => [
                    'required' => 'Debe ingresar una contraseña',
                    'min_length' => 'Nombre ingresado invalido',
                ],
                'inputSurname' => [
                    'required' => 'Debe ingresar una contraseña',
                    'min_length' => 'Apellido ingresado invalido',
                ],
                'inputDni' => [
                    'required' => 'Debe ingresar una contraseña',
                    'min_length' => 'DNI ingresado invalido',
                    'max_length' => 'DNI ingresado invalido',
                    'numeric' => 'Debe ingresar un DNI valido sin caracteres alfabeticos',
                ],
                'inputFecNac' => [
                    'required' => 'Debe ingresar una fecha de nacimiento',
                ],
                'inputAddress' => [
                    'required' => 'Debe ingresar una direccion',
                    'min_length' => 'Debe ingresar una direccion valida',
                    'alpha_numeric_punct' => 'Debe ingresar una direccion sin caracteres especiales'
                ],
                'inputTel' => [
                    'required' => 'Debe ingresar un numero de telefono',
                    'min_length' => 'Debe ingresar un numero de telefono valido',
                    'numeric' => 'Debe ingresar un numero de telefono valido sin caracteres alfabeticos',
                ],
                'inputEmail' => [
                    'required' => 'Debe ingresar una contraseña',
                    'valid_email' => 'Debe ingresar una direccion de correo valida',
                ],
            ]
        );
        if (!$validation->withRequest($this->request)->run()) {
            return  redirect()->back()->with('errors', $validation->getErrors())->withInput();
        } else {
            $user = new User($data);
            if (true != $userModel->update($user->getIDUser(), ['username' => $user->getUsername(),    'usersurname' => $user->getUsersurname(), 'userDni' => $user->getuserDni(), 'userBirthday' => $user->getuserBirthday(), 'useradress' => $user->getuseradress(), 'usertel' => $user->getUserTel(), 'useremail' => $user->getuseremail()])) {
                return  redirect()->back()->with('msg', ['type' => 'danger', 'body' => 'Error al actualizar sus datos. Vuelve a intentarlo.'])->withInput();
            } else {
                return  redirect()->back()->with('msg', ['type' => 'success', 'body' => 'El usuario pudo modificar sus datos con exito.']);
            }
        }
    }
    public function guardarPassword()
    {
        $validation =  \Config\Services::validation();
        $request = \Config\Services::request();
        $userModel = model('UserModel');

        $data = array(
            'id_user' => $request->getVar('idUser'),
            'password' => $request->getVar('inputPasswordNew')
        );
        $validation->setRules(
            [
                'inputPasswordNew' => 'required|min_length[8]|matches[inputConfirmPasswordNew]',
                'inputConfirmPasswordNew' => 'required|min_length[8]',
            ],
            [   // Errores-Mensajes
                'inputPasswordNew' => [
                    'required' => 'Debe ingresar una contraseña',
                    'min_length' => 'Usa 8 caracteres o más para tu contraseña',
                    'matches' => 'Las contrase&ntilde;as no coinciden. Vuelve a intentarlo.'
                ],
                'inputConfirmPasswordNew' => [
                    'required' => 'Debe ingresar una contraseña',
                    'min_length' => 'Usa 8 caracteres o más para tu contraseña',
                ],

            ]
        );
        if (!$validation->withRequest($this->request)->run()) {
            return  redirect()->back()->with('errors', $validation->getErrors());
        } else {
            $user = new User($data);
            if (true != $userModel->update($user->getIDUser(), ['password' => $user->getPassword(),    'tokenPassword' => null, 'dateTokenPassword' => null])) {
                return  redirect()->back()->with('msg', ['type' => 'danger', 'body' => 'Error al cambiar su contrase&ntilde;a. Vuelve a intentarlo.']);
            } else {
                return  redirect()->back()->with('msg', ['type' => 'success', 'body' => 'El usuario pudo cambiar su contrase&ntilde;a. con exito.']);
            }
        }
    }
    public function drinkAdd()
    {
        $db      = \Config\Database::connect();
        // $builder = $db->table('categoriabebida')->get()->getResultArray();
        // $query   = $builder->get();
        $data['title'] = 'Agregar bebida';
        $data['options'] = $db->table('categoriabebida')->get()->getResultArray();
        return view('Front/head', $data) . view('Front/header') . view('Front/sidebar') . view('Admin/drinkAdd', $data);
    }
    public function drinkEdit()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('categoriabebida');
        $query   = $builder->get();

        $data['title'] = 'Editar bebida';
        $beverageModel = model('BeverageModel');
        $beverage = $beverageModel->orderBy('idCategoriaBebida', 'asc')->findAll();
        $data['beverages'] = $beverage;
        $data['typeBeverages'] = $query->getResult('array');
        return view('Front/head', $data) . view('Front/header') . view('Front/sidebar') . view('Admin/drinkEdit', $data);
    }
    public function report()
    {
        $data['title'] = "Reportes";
        return view('Front/head', $data) . view('Front/header') . view('Front/sidebar') . view('Admin/report', $data);
    }
    private function obtenerReporteRankingPlatos($fechaInicio,$fechaFinal,$array) {

        /*$request= \Config\Services::request();
        $fechaInicio=$request->getPostGet('inputFechaInicioReportePlatos');
        $fechaFinal=$request->getPostGet('inputFechaHastaReportePlatos');*/
  
  
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
  
  
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(60,7,"Nombre del plato",1);
            $pdf->Cell(30,7,"Cantidad",1);
            $pdf->Ln();
  
        foreach ($array as $row)
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
  
    private function obtenerReporteReservasCanceladas($fechaInicio,$fechaFinal,$array){
  
    /*$request= \Config\Services::request();
    $fechaInicio=$request->getPostGet('inputFechaInicioReportePlatos1');
    $fechaFinal=$request->getPostGet('inputFechaFinReportePlatos1');*/
  
  
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
  
  
    foreach ($array as $row)
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
  
  public function obtenerReporteHorariosDemandados($fechaInicio,$fechaFinal,$array){
      /*$request= \Config\Services::request();
      $fechaInicio=$request->getPostGet('inputFechaInicioReportePlatos2');
      $fechaFinal=$request->getPostGet('inputFechaFinReportePlatos2');*/
  
  
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
  
  
          $pdf->SetFont('Arial','B',14);
          $pdf->Cell(35,7,"Horarios",1);
          $pdf->Cell(30,7,"Cantidad",1);
          $pdf->Ln();
  
      foreach ($array as $row)
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
  
  public function obtenerReporteclientesNoAsistencia($fechaInicio,$fechaFinal,$array){
      /*$request= \Config\Services::request();
      $fechaInicio=$request->getPostGet('inputFechaInicioReportePlatos3');
      $fechaFinal=$request->getPostGet('inputFechaFinReportePlatos3');*/
  
  
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
  
  
          $pdf->SetFont('Arial','B',14);
          $pdf->Cell(30,7,"Dni usuario",1);
          $pdf->Cell(28,7,"Nombre",1);
          $pdf->Cell(28,7,"Apellido",1);
          $pdf->Cell(45,7,"Email",1);
          $pdf->Cell(28,7,"telefono",1);
          $pdf->Cell(37,7,"Fecha reserva",1);
          $pdf->Ln();
  
      foreach ($array as $row)
  {
          $pdf->SetFont('Arial','',13);
          $pdf->Cell(30,7,$row['dniUsuario'],1);
          $pdf->Cell(28,7,$row['username'],1);
          $pdf->Cell(28,7,$row['usersurname'],1);
          $pdf->Cell(45,7,$row['useremail'],1);
          $pdf->Cell(28,7,$row['usertel'],1);
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
  
  public function obtenerReporteReservasDelDia($fechaInicio,$fechaFinal,$array){
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
  
  
  
      $pdf->SetFont('Arial','B',14);
      $pdf->Cell(38,7,"Dni usuario",1);
      $pdf->Cell(25,7,"Turno",1);
      $pdf->Cell(30,7,"Horario",1);
      $pdf->Cell(31,7,"Num mesa",1);
      $pdf->Cell(30,7,"Fecha",1);
      $pdf->Cell(33,7,"Asistencia",1);
      $pdf->Ln();
  
      foreach ($array as $row)
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


    public function crearReporte()
    {
        //Agregado lo del boton descargar para validaciones fechas
        $request = \Config\Services::request();
        $fechaInicio = $request->getPostGet('inputFechaInicioReportePlatos');
        $fechaFinal = $request->getPostGet('inputFechaHastaReportePlatos');
        $tipoRepo = $request->getPostGet('inputTipoReporte');

        $validation =  \Config\Services::validation();


        if ($fechaInicio == "" || $fechaFinal == "") {
            return  redirect()->route('reportAdmin')->with('msg', ['type' => 'danger', 'body' => 'Error, no se ingreso un rango de fechas.Ingrese un rango de fechas valido.']);
        }

        switch ($tipoRepo) {
            case '1':
                $validation->setRules(
                    [
                        'inputFechaInicioReportePlatos' => 'required|validateDate[' . $fechaInicio . ']|valid_date',
                        'inputFechaHastaReportePlatos' => 'required|validateDate[' . $fechaFinal . ']|valid_date',
                        'inputTipoReporte' => 'required|in_list[1,2,3,4,5]',
                    ],

                    [   // Errores-Mensajes
                        'inputFechaInicioReportePlatos' => [
                            'required' => 'Debe ingresar una fecha.',
                            'validateDate' => 'Debe ingresar una fecha menor. ',
                            'valid_date' => 'Debe ingresar una fecha valida.'
                        ],
                        'inputFechaHastaReportePlatos' => [
                            'required' => 'Debe ingresar una fecha.',
                            'validateDate' => 'Debe ingresar una fecha menor. ',
                            'valid_date' => 'Debe ingresar una fecha valida.'
                        ],
                        'inputTipoReporte' => [
                            'required' => 'Debe ingresar un tipo de reporte',
                            'in_list' => 'Debe seleccionar una opcion valida'
                        ]
                    ]
                );

                if (!$validation->withRequest($this->request)->run()) {

                    return  redirect()->back()->with('errors', $validation->getErrors())->withInput();
                } else {
                }
                $db = \Config\Database::connect();

                $query = $db->query('select p.nombrePlato, count(p.nombrePlato) as cantidad from reserva as r inner join pedido as g inner join plato as p inner join pedidoplato as c where (r.fechaReserva between "' . $fechaInicio . '" and "' . $fechaFinal . '") and r.idReserva = g.idReserva and g.nroPedido = c.nroPedido and c.idPlato = p.idPlato group by p.nombrePlato order by cantidad desc,p.nombrePlato limit 5');

                if (count($query->getResultArray()) == 0) {
                    //dd("aca if");
                    return  redirect()->route('reportAdmin')->with('msg', ['type' => 'danger', 'body' => 'Error, no se pudo encontrar platos en el rango de fechas. Ingrese nuevamente.']);
                    //return redirect()->back();
                }
                $this->obtenerReporteRankingPlatos($fechaInicio, $fechaFinal, $query->getResultArray());
                //return $repo;
                break;
            case '2':
                $validation->setRules(
                    [
                        'inputFechaInicioReportePlatos' => 'required|validarFechaIngresadaInicioMayor['.$fechaInicio.','.$fechaFinal.']|valid_date',
                        'inputFechaHastaReportePlatos' => 'required|validarFechaIngresadaFinMenor[' . $fechaInicio . ',' . $fechaFinal . ']|valid_date',
                        'inputTipoReporte' => 'required|in_list[1,2,3,4,5]',
                    ],
                    //Descomentado los input con el tema de las fechas y ya hecha las validaciones
                    [   // Errores-Mensajes
                        'inputFechaInicioReportePlatos' => [
                            'required' => 'Debe ingresar una fecha.',
                            // 'fechamayor'=>'Debe ingresar una fecha mayor o igual a la fecha actual. ',
                            'validarFechaIngresadaInicioMayor' => 'Error. Se ingreso una fecha mayor a la fecha fin. Vuelvalo a intentar. ',
                            'valid_date' => 'Debe ingresar una fecha valida.'
                        ],
                        'inputFechaHastaReportePlatos' => [
                            'required' => 'Debe ingresar una fecha.',
                            // 'validarfechasfut'=>'Debe ingresar una fecha mayor a la seleccionada 2. ',
                            'validarFechaIngresadaFinMenor' => 'Error. Se ingreso una fecha menor a la fecha inicio. Vuelvalo a intentar. ',
                            'valid_date' => 'Debe ingresar una fecha valida.'
                        ],
                        'inputTipoReporte' => [
                            'required' => 'Debe ingresar un tipo de reporte',
                            'in_list' => 'Debe seleccionar una opcion valida'
                        ]
                    ]
                );

                if (!$validation->withRequest($this->request)->run()) {

                    return  redirect()->back()->with('errors', $validation->getErrors())->withInput();
                } else {
                }
                $db = \Config\Database::connect();

                $query = $db->query('select u.dniUsuario, res.turnoReserva, res.horario, res.idMesa, res.fechaReserva from reserva as res inner join user as u on u.id_user=res.id_user where (res.fechaReserva between "' . $fechaInicio . '" and "' . $fechaFinal . '") and (res.estadoReserva = "Cancelado") order by res.fechaReserva desc');
                if (count($query->getResultArray()) == 0) {
                    //dd("aca if");
                    return  redirect()->route('reportAdmin')->with('msg', ['type' => 'danger', 'body' => 'Error, no se pudo encontrar platos en el rango de fechas. Ingrese nuevamente.']);
                    //return redirect()->back();
                }
                $this->obtenerReporteReservasCanceladas($fechaInicio, $fechaFinal, $query->getResultArray());
                //return $repo;
                break;
            case '3':
                $validation->setRules(
                    [
                        'inputFechaInicioReportePlatos' => 'required|validateDate[' . $fechaInicio . ']|valid_date',
                        'inputFechaHastaReportePlatos' => 'required|validateDate[' . $fechaFinal . ']|valid_date',
                        'inputTipoReporte' => 'required|in_list[1,2,3,4,5]',
                    ],

                    [   // Errores-Mensajes
                        'inputFechaInicioReportePlatos' => [
                            'required' => 'Debe ingresar una fecha.',
                            'validateDate' => 'Debe ingresar una fecha menor. ',
                            'valid_date' => 'Debe ingresar una fecha valida.'
                        ],
                        'inputFechaHastaReportePlatos' => [
                            'required' => 'Debe ingresar una fecha.',
                            'validateDate' => 'Debe ingresar una fecha menor. ',
                            'valid_date' => 'Debe ingresar una fecha valida.'
                        ],
                        'inputTipoReporte' => [
                            'required' => 'Debe ingresar un tipo de reporte',
                            'in_list' => 'Debe seleccionar una opcion valida'
                        ]
                    ]
                );

                if (!$validation->withRequest($this->request)->run()) {

                    return  redirect()->back()->with('errors', $validation->getErrors())->withInput();
                } else {
                }
                $db = \Config\Database::connect();

                $query = $db->query('select horario, count(*) as cantidad from reserva where fechaReserva between "' . $fechaInicio . '" and "' . $fechaFinal . '" group by horario having count(*)>=1 order by cantidad desc limit 5');
                if (count($query->getResultArray()) == 0) {
                    //dd("aca if");
                    return  redirect()->route('reportAdmin')->with('msg', ['type' => 'danger', 'body' => 'Error, no se pudo encontrar platos en el rango de fechas. Ingrese nuevamente.']);
                    //return redirect()->back();
                }
                $this->obtenerReporteHorariosDemandados($fechaInicio, $fechaFinal, $query->getResultArray());
                //return $repo;
                break;
            case '4':
                $validation->setRules(
                    [
                        'inputFechaInicioReportePlatos' => 'required|validateDate[' . $fechaInicio . ']|valid_date',
                        'inputFechaHastaReportePlatos' => 'required|validateDate[' . $fechaFinal . ']|valid_date',
                        'inputTipoReporte' => 'required|in_list[1,2,3,4,5]',
                    ],

                    [   // Errores-Mensajes
                        'inputFechaInicioReportePlatos' => [
                            'required' => 'Debe ingresar una fecha.',
                            'validateDate' => 'Debe ingresar una fecha menor. ',
                            'valid_date' => 'Debe ingresar una fecha valida.'
                        ],
                        'inputFechaHastaReportePlatos' => [
                            'required' => 'Debe ingresar una fecha.',
                            'validateDate' => 'Debe ingresar una fecha menor. ',
                            'valid_date' => 'Debe ingresar una fecha valida.'
                        ],
                        'inputTipoReporte' => [
                            'required' => 'Debe ingresar un tipo de reporte',
                            'in_list' => 'Debe seleccionar una opcion valida'
                        ]
                    ]
                );

                if (!$validation->withRequest($this->request)->run()) {

                    return  redirect()->back()->with('errors', $validation->getErrors())->withInput();
                } else {
                }

                $db = \Config\Database::connect();

                $query = $db->query('select u.dniUsuario, u.username, u.usersurname, u.useremail, u.usertel, r.fechaReserva from reserva as r inner join user as u where (r.fechaReserva between "' . $fechaInicio . '" and "' . $fechaFinal . '") and (r.asistenciaReserva = "No asistio") and r.id_user = u.id_user order by u.usersurname asc');
                if (count($query->getResultArray()) == 0) {
                    //dd("aca if");
                    return  redirect()->route('reportAdmin')->with('msg', ['type' => 'danger', 'body' => 'Error, no se pudo encontrar platos en el rango de fechas. Ingrese nuevamente.']);
                    //return redirect()->back();
                }
                $this->obtenerReporteclientesNoAsistencia($fechaInicio, $fechaFinal, $query->getResultArray());
                //return $repo;
                break;
            case '5':
                $validation->setRules(
                    [
                        'inputFechaInicioReportePlatos' => 'required|validarFechaIngresadaInicioMayor['.$fechaInicio.','.$fechaFinal.']|valid_date',
                        'inputFechaHastaReportePlatos' => 'required|validarFechaIngresadaFinMenor[' . $fechaInicio . ',' . $fechaFinal . ']|valid_date',
                        'inputTipoReporte' => 'required|in_list[1,2,3,4,5]',
                    ],
                    //Descomentado los input con el tema de las fechas y ya hecha las validaciones
                    [   // Errores-Mensajes
                        'inputFechaInicioReportePlatos' => [
                            'required' => 'Debe ingresar una fecha.',
                            // 'fechamayor'=>'Debe ingresar una fecha mayor o igual a la fecha actual. ',
                            'validarFechaIngresadaInicioMayor' => 'Error. Se ingreso una fecha mayor a la fecha fin. Vuelvalo a intentar. ',
                            'valid_date' => 'Debe ingresar una fecha valida.'
                        ],
                        'inputFechaHastaReportePlatos' => [
                            'required' => 'Debe ingresar una fecha.',
                            // 'validarfechasfut'=>'Debe ingresar una fecha mayor a la seleccionada 2. ',
                            'validarFechaIngresadaFinMenor' => 'Error. Se ingreso una fecha menor a la fecha inicio. Vuelvalo a intentar. ',
                            'valid_date' => 'Debe ingresar una fecha valida.'
                        ],
                        'inputTipoReporte' => [
                            'required' => 'Debe ingresar un tipo de reporte',
                            'in_list' => 'Debe seleccionar una opcion valida'
                        ]
                    ]
                );

                if (!$validation->withRequest($this->request)->run()) {

                    return  redirect()->back()->with('errors', $validation->getErrors())->withInput();
                } else {
                }
                $db = \Config\Database::connect();

                $query = $db->query('select u.dniUsuario, r.turnoReserva, r.horario, r.idMesa, r.fechaReserva, r.asistenciaReserva from reserva as r inner join user as u on u.id_user = r.id_user where fechaReserva between "' . $fechaInicio . '" and "' . $fechaFinal . '" and (r.estadoReserva = "En Curso") and u.deleted_at is null order by r.fechaReserva desc');
                if (count($query->getResultArray()) == 0) {
                    //dd("aca if");
                    return  redirect()->route('reportAdmin')->with('msg', ['type' => 'danger', 'body' => 'Error, no se pudo encontrar platos en el rango de fechas. Ingrese nuevamente.']);
                    //return redirect()->back();
                }
                return $this->obtenerReporteReservasDelDia($fechaInicio, $fechaFinal, $query->getResultArray());
                //return $repo;
                break;
            default:
                return  redirect()->route('reportAdmin')->with('msg', ['type' => 'danger', 'body' => 'Error, debe seleccionar un tipo de reporte. Seleccione nuevamente.']);
                break;
        }
    }

    public function imprimirReporte()
    {
        $request = \Config\Services::request();
        $fechaInicio = $request->getPostGet('inputFechaInicioReportePlatos');
        $fechaFinal = $request->getPostGet('inputFechaHastaReportePlatos');
        $tipoRepo = $request->getPostGet('inputTipoReporte');


        $db = \Config\Database::connect();
        switch ($tipoRepo) {
            case '1':
                //Ranking platos
                $query = $db->query('select p.nombrePlato, count(p.nombrePlato) as cantidad from reserva as r inner join pedido as g inner join plato as p inner join pedidoplato as c where (r.fechaReserva between "' . $fechaInicio . '" and "' . $fechaFinal . '") and r.idReserva = g.idReserva and g.nroPedido = c.nroPedido and c.idPlato = p.idPlato group by p.nombrePlato order by cantidad desc,p.nombrePlato limit 5');
                echo json_encode($query->getResultArray());
                break;
            case '2':
                //reservas canceladas
                $query = $db->query('select u.dniUsuario, res.turnoReserva, res.horario, res.idMesa, res.fechaReserva from reserva as res inner join user as u on u.id_user=res.id_user where (res.fechaReserva between "' . $fechaInicio . '" and "' . $fechaFinal . '") and (res.estadoReserva = "Cancelado") order by res.fechaReserva desc');
                echo json_encode($query->getResultArray());
                break;
            case '3':
                //horarios mas demandados
                $query = $db->query('select horario, count(*) as cantidad from reserva where fechaReserva between "' . $fechaInicio . '" and "' . $fechaFinal . '" group by horario having count(*)>=1 order by cantidad desc limit 5');
                echo json_encode($query->getResultArray());
                break;
            case '4':
                //clientes no asistencia
                $query = $db->query('select u.dniUsuario, u.username, u.usersurname, u.useremail, u.usertel, r.fechaReserva from reserva as r inner join user as u where (r.fechaReserva between "' . $fechaInicio . '" and "' . $fechaFinal . '") and (r.asistenciaReserva = "No asistio") and r.id_user = u.id_user order by u.usersurname asc');
                echo json_encode($query->getResultArray());
                break;
            case '5':
                //reservas del dia
                $query = $db->query('select u.dniUsuario,res.turnoReserva, res.horario, res.idMesa, res.fechaReserva, res.asistenciaReserva from reserva as res INNER join user u on u.id_user=res.id_user where res.fechaReserva between "' . $fechaInicio . '" and "' . $fechaFinal . '" and (res.estadoReserva = "En Curso") order by res.fechaReserva asc');
                echo json_encode($query->getResultArray());
                break;
        }
    }
    public function encuesta()
    {
        $db = \Config\Database::connect();
        $data['title'] = "Encuesta";
        $data['listadoPreguntaEncuesta'] = $db->table('encuestapreg')->get()->getResultArray();
        return view('Front/head', $data) . view('Front/header') . view('Front/sidebar') . view('Admin/encuesta', $data);
    }
    public function modificarEncuesta()
    {
        $db = \Config\Database::connect();
        $request = \Config\Services::request();
        $data = array(
            'idPregunta' => $request->getPostGet('preguntaAnterior'),
            'preguntaEncuesta' => $request->getPostGet('preguntaNueva'),
        );
        $query = $db->table('encuestapreg')->where('idPregunta', $request->getPostGet('preguntaAnterior'))->update($data);
        if ($query === false) {
            return  redirect()->route('encuesta')->with('msg', ['type' => 'danger', 'body' => 'No se ha podido actualizar. Intentelo más tarde.']);
        } else {
            return  redirect()->route('encuesta')->with('msg', ['type' => 'success', 'body' => 'Se ha actualizado con exito']);
        }
    }
    public function listadoClientes()
    {
        $db = \Config\Database::connect();
        $data['title'] = "Clientes";
        $data['listadoClientes'] = $db->table('user')->getWhere(['id_group' => 3])->getResultArray();
        return view('Front/head', $data) . view('Front/header') . view('Front/sidebar') . view('Admin/listadoClients', $data);
    }
    public function verificarPenalidades()
    {
        $db = \Config\Database::connect();
        $request = \Config\Services::request();
        $id = $request->getPostGet('id');
        $query = $db->query('call verPenalidades("' . $id . '")');
        if ($query) {
            echo json_encode(array("status" => true, 'data' => $query->getResultArray()));
        } else {
            echo json_encode(array("status" => false));
        }
    }
    public function cargarDatosCliente()
    {

        $request = \Config\Services::request();
        $id = $request->getPostGet('id');
        $userModel = model('UserModel');
        $data = $userModel->where('id_user', $id)->first();
        if ($data) {
            echo json_encode(array("status" => true, 'data' => $data));
        } else {
            echo json_encode(array("status" => false));
        }
    }
    public function habilitarCliente()
    {
        $request = \Config\Services::request();
        $id = $request->getPostGet('idUserHabilitar');

        $userModel = model('UserModel');
        $data = [
            'deleted_at' => null
        ];
        
        if (!$userModel->update($id, $data)) {
            return  redirect()->route('listadoClientes')->with('msg', ['type' => 'danger', 'body' => 'No se pudo habilitar al cliente.Intentelo más tarde']);;
        }else{
            return  redirect()->route('listadoClientes')->with('msg', ['type' => 'success', 'body' => 'Se pudo habilitar con exito al cliente.']);;
        }

        
    }
    public function borrarCliente()
    {
        $request = \Config\Services::request();
        $id = $request->getPostGet('idUserDelete');
        $db      = \Config\Database::connect();
        $query = $db->query('call verificarClienteReservaEnCurso("' . $id . '")');
        $flag = null;
        $mjs = '';
        foreach ($query->getResultArray() as $row) {
            $mjs = $row['Mensaje'];
            $flag = $row['flag'];
        }

        if ($flag == 1) {
            return  redirect()->route('listadoClientes')->with('msg', ['type' => 'success', 'body' => $mjs]);
        } else {
            return  redirect()->route('listadoClientes')->with('msg', ['type' => 'warning', 'body' => $mjs]);
        }
    }

    public function validarModificarCliente()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules(
            [
                'dniUsuario' => 'required|min_length[7]|max_length[8]',
                'nombreUsuario' => 'required|min_length[3]|max_length[50]',
                'apellidoUsuario' => 'required|min_length[3]|max_length[50]',
                'correoUsuario' => 'required|valid_email',
                'fechaNacUsuario' => 'required|valid_date',
                'direccionUsuario' => 'required|min_length[10]',
                'telefonoUsuario' => 'required|min_length[3]|numeric'
                //|alpha_numeric_punct
            ],
            [   // Errors
                'dniUsuario' => [
                    'required' => 'Se debe ingresar un nro de DNI',
                    'min_length' => 'Su DNI es incorrecto, es muy corto. Ingrese nuevamente',
                    'max_length' => 'Su DNI es incorrecto, es muy largo. Ingrese nuevamente',
                ],
                'nombreUsuario' => [
                    'required' => 'Se debe ingresar un nombre',
                    'min_length' => 'Su nombre es incorrecto, es muy corto. Ingrese nuevamente',
                    'max_length' => 'Su nombre es incorrecto, es muy largo. Ingrese nuevamente',
                ],
                'apellidoUsuario' => [
                    'required' => 'Se debe ingresar un apellido',
                    'min_length' => 'Su apellido es incorrecto, es muy corto. Ingrese nuevamente',
                    'max_length' => 'Su apellido es incorrecto, es muy largo. Ingrese nuevamente',
                ],
                'fechaNacUsuario' => [
                    'required' => 'Se debe ingresar una fecha de nacimiento',
                    'valid_date' => 'Se debe ingresar una fecha de nacimiento valida. Ingrese nuevamente',

                ],
                'correoUsuario' => [
                    'required' => 'Se debe ingresar un email',
                    'valid_email' => 'Se debe ingresar un email valido. Por favor intentelo nuevamente',
                ],
                'direccionUsuario' => [
                    'required' => 'Se debe ingresar un direccion',
                    'min_length' => 'Su direccion es incorrecto, es muy corto. Ingrese nuevamente',
                    //'alpha_numeric_punct' => 'Debe contener solo caracteres alfanumericos, espacios y algunos caracteres especiales',
                ],
                'telefonoUsuario' => [
                    'required' => 'Se debe ingresar un telefono',
                    'min_length' => 'Su telefono es incorrecto, es muy corto. Ingrese nuevamente',
                    'numeric' => 'Debe contener solo caracteres numericos',
                ],
            ]
        );
        if (!$validation->withRequest($this->request)->run()) {
            echo json_encode(array("status" => false, 'data' => $validation->getErrors()));
        } else {
            echo json_encode(array("status" => true, 'data' => []));
        }
    }
    public function guardarCliente()
    {

        $db = \Config\Database::connect();
        $request = \Config\Services::request();

        $user = array(
            'dniUsuario' => $request->getPostGet('dniUsuario'),
            'username' => $request->getPostGet('nombreUsuario'),
            'usersurname' => $request->getPostGet('apellidoUsuario'),
            'useremail' => $request->getPostGet('correoUsuario'),
            'userBirthday' => $request->getPostGet('fechaNacUsuario'),
            'useradress' => $request->getPostGet('direccionUsuario'),
            'usertel' => $request->getPostGet('telefonoUsuario'),
        );
        $data = [
            'id_user' => $request->getPostGet('idUser'),
        ];
        $query = $db->table('user')->where($data)->update($user);
        if ($query === false) {
            return  redirect()->route('listadoClientes')->with('msg', ['type' => 'danger', 'body' => 'No se ha podido actualizar al cliente. Intentelo más tarde.']);
        } else {
            return  redirect()->route('listadoClientes')->with('msg', ['type' => 'success', 'body' => 'Se ha actualizado con exito al cliente']);
        }
    }


    public function promocionAdd()
    {
        $data['title'] = "Promociones";
        return view('Front/head', $data) . view('Front/header') . view('Front/sidebar') . view('Admin/promocionAdd');
    }
    public function promocionEdit()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('promocion');
        $query   = $builder->get();
        $data['title'] = "Promociones";
        $data['promociones'] = $query->getResultArray();
        return view('Front/head', $data) . view('Front/header') . view('Front/sidebar') . view('Admin/promocionEdit', $data);
    }
    public function tableEdit()
    {
        return view('Front/head') . view('Front/header') . view('Front/sidebar') . view('Admin/tableEdit') . view('Admin/footer');
    }
    public function signout()
    {
        session()->destroy();
        return redirect()->route('home');
    }
}
