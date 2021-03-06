<?php

namespace App\Controllers\Chef;

use App\Controllers\BaseController;
// use App\Controllers\Menu\Plato;
use App\Entities\User;

class Chef extends BaseController
{
	public function index()
	{
		// if (!session()->is_logged) {
		// 	return redirect()->route('home');
		// }
		$data['title'] = 'Home';
		return view('Front/head', $data) . view('Front/header') . view('Chef/home') . view('Front/sidebar') . view('Chef/footer');
	}
	public function infoChef()
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
		return view('Front/head', $data) . view('Front/header') . view('Front/sidebar') . view('Chef/infoChef') . view('Chef/footer');
	}
	public function guardarInfoPersonalChef()
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
				'inputAddress' => 'required|min_length[3]|alpha_numeric_space',
				'inputTel' => 'required|min_length[7]|numeric',
				'inputEmail' => 'required|valid_email',
			],
			[   // Errores-Mensajes
				'inputName' => [
					'required' => 'Debe ingresar una contrase??a',
					'min_length' => 'Nombre ingresado invalido',
				],
				'inputSurname' => [
					'required' => 'Debe ingresar una contrase??a',
					'min_length' => 'Apellido ingresado invalido',
				],
				'inputDni' => [
					'required' => 'Debe ingresar una contrase??a',
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
					'alpha_numeric_space' => 'Debe ingresar una direccion sin caracteres especiales'
				],
				'inputTel' => [
					'required' => 'Debe ingresar un numero de telefono',
					'min_length' => 'Debe ingresar un numero de telefono valido',
					'numeric' => 'Debe ingresar un numero de telefono valido sin caracteres alfabeticos',
				],
				'inputEmail' => [
					'required' => 'Debe ingresar una contrase??a',
					'valid_email' => 'Debe ingresar una direccion de correo valida',
				],
			]
		);
		if (!$validation->withRequest($this->request)->run()) {
			return  redirect()->back()->with('errors', $validation->getErrors())->withInput();
		} else {
			$user = new User($data);
			if (true != $userModel->update($user->getIDUser(), ['username' => $user->getUsername(),	'usersurname' => $user->getUsersurname(), 'userDni' => $user->getuserDni(), 'userBirthday' => $user->getuserBirthday(), 'useradress' => $user->getuseradress(), 'usertel' => $user->getUserTel(), 'useremail' => $user->getuseremail()])) {
				return  redirect()->back()->with('msg', ['type' => 'danger', 'body' => 'Error al actualizar sus datos. Vuelve a intentarlo.'])->withInput();
			} else {
				return  redirect()->back()->with('msg', ['type' => 'success', 'body' => 'El usuario pudo modificar sus datos con exito.']);
			}
		}
	}
	public function guardarPasswordChef()
	{
		$validation =  \Config\Services::validation();
		$request = \Config\Services::request();
		$userModel = model('UserModel');

		$data = array(
			'id_user' => $request->getVar('idUserPass'),
			'password' => $request->getVar('inputPasswordNew')
		);
		$validation->setRules(
			[
				'inputPasswordNew' => 'required|min_length[8]|matches[inputConfirmPasswordNew]',
				'inputConfirmPasswordNew' => 'required|min_length[8]',
			],
			[   // Errores-Mensajes
				'inputPasswordNew' => [
					'required' => 'Debe ingresar una contrase??a',
					'min_length' => 'Usa 8 caracteres o m??s para tu contrase??a',
					'matches' => 'Las contrase&ntilde;as no coinciden. Vuelve a intentarlo.'
				],
				'inputConfirmPasswordNew' => [
					'required' => 'Debe ingresar una contrase??a',
					'min_length' => 'Usa 8 caracteres o m??s para tu contrase??a',
				],

			]
		);
		if (!$validation->withRequest($this->request)->run()) {
			return  redirect()->back()->with('errors', $validation->getErrors());
		} else {
			$user = new User($data);
			if (true != $userModel->update($user->getIDUser(), ['password' => $user->getPassword(),	'tokenPassword' => null, 'dateTokenPassword' => null])) {
				return  redirect()->back()->with('msg', ['type' => 'danger', 'body' => 'Error al cambiar su contrase&ntilde;a. Vuelve a intentarlo.']);
			} else {
				return  redirect()->back()->with('msg', ['type' => 'success', 'body' => 'El usuario pudo cambiar su contrase&ntilde;a. con exito.']);
			}
		}
	}

	public function foodManager()
	{
		$data['title'] = 'Home';
		return view('Front/head', $data) . view('Front/header') . view('Chef/food') . view('Front/sidebar') . view('Chef/footer');
	}
	public function foodAdd()
	{
		$data['title'] = 'Agregar platos';
		return view('Front/head', $data) . view('Front/header') . view('Chef/foodAdd') . view('Front/sidebar') . view('Chef/footer');
	}
	public function foodEdit()
	{
		$db      = \Config\Database::connect();
		$data['title'] = 'Editar platos';
		$data['foods'] = $db->query('SELECT * FROM `listado_platos`')->getResultArray();
		return view('Front/head', $data) . view('Front/header') . view('Front/sidebar') . view('Chef/foodEdit', $data);
	}
	public function report()
	{
		$data['title'] = "Reportes";
		return view('Front/head', $data) . view('Front/header') . view('Chef/report', $data) . view('Front/sidebar') . view('Chef/footer');
	}

	private function obtenerPlatos($fechaInicio, $fechaFinal, $array)
	{
		/* $request= \Config\Services::request();
		$fechaInicio=$request->getPostGet('inputFechaInicioReportePlatos');
		$fechaFinal=$request->getPostGet('inputFechaHastaReportePlatos');*/
		$platos = "";

		$pdf = new \FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(70);
		$pdf->Cell(40, 10, "SRO", 0, 0, 'C');
		$pdf->Ln(15);
		$pdf->SetFont('Arial', '', 15);
		$fechaInicio2 = date("d/m/Y", strtotime($fechaInicio));
		$pdf->Cell(47, 10, "Desde: " . $fechaInicio2, 0, 0, 'C');
		$pdf->Ln(10);
		$fechaFinal2 = date("d/m/Y", strtotime($fechaFinal));
		$pdf->Cell(45, 10, "Hasta: " . $fechaFinal2, 0, 0, 'C');
		$pdf->Ln(15);
		$pdf->Cell(35);
		$pdf->Cell(41, 10, 'Los platos de el rango de fechas seleccionadas: ', 0, 0, 'C');
		$pdf->Ln(15);


		$aux = true;
		foreach ($array as $row) {
			if ($aux) {
				$mesaAux = $row['idMesa'];
				$aux = false;

				$pdf->SetFont('Arial', 'U', 13);
				$fechaReserva4 = date("d/m/Y", strtotime($row['fechaReserva']));
				$pdf->Cell(65, 10, 'Informacion platos:', 0, 0, 'C');
				$pdf->Ln(10);

				$pdf->SetFont('Arial', 'B', 14);
				$pdf->Cell(55, 7, "Nombre plato", 1);
				$pdf->Cell(15, 7, "Cant", 1);
				$pdf->Cell(34, 7, "Alergia", 1);
				$pdf->Cell(30, 7, "Fecha res", 1);
				$pdf->Cell(20, 7, "Mesa", 1);
				$pdf->Cell(21, 7, "turno", 1);
				$pdf->Cell(23, 7, "horario", 1);
				$pdf->Ln();
			}
			if ($mesaAux == $row['idMesa']) {
				$pdf->SetFont('Arial', '', 13);
				//$pdf->Cell(41,10,'Los platos de cada uno de los pedidos de la reserva con fecha '.$row['fechaReserva'].' son: ',0,0,'C');
				$pdf->Cell(55, 7, $row['nombrePlato'], 1);
				$pdf->Cell(15, 7, $row['cantidad'], 1);
				$pdf->Cell(34, 7, $row['detallePlatoAlergia'], 1);
				$fechaReserva3 = date("d/m/Y", strtotime($row['fechaReserva']));
				$pdf->Cell(30, 7, $fechaReserva3, 1);
				$pdf->Cell(20, 7, $row['idMesa'], 1);
				$pdf->Cell(21, 7, $row['turnoReserva'], 1);
				$pdf->Cell(23, 7, $row['horario'], 1);
				$mesaAux = $row['idMesa'];
				$pdf->Ln();
			} else {
				$pdf->Ln(5);
				$pdf->SetFont('Arial', 'U', 13);
				$fechaReserva5 = date("d/m/Y", strtotime($row['fechaReserva']));
				$pdf->Cell(65, 10, 'Reserva con fecha ' . $fechaReserva5 . ' :', 0, 0, 'C');
				$pdf->Ln(10);
				$pdf->SetFont('Arial', '', 13);
				$pdf->SetFont('Arial', 'B', 14);
				$pdf->Cell(55, 7, "Nombre plato", 1);
				$pdf->Cell(15, 7, 'Cant', 1);
				$pdf->Cell(34, 7, "Alergia", 1);
				$pdf->Cell(40, 7, "Fecha reserva", 1);
				$pdf->Cell(31, 7, "Num mesa", 1);
				$pdf->Cell(16, 7, "turno", 1);
				$pdf->Cell(23, 7, "horario", 1);
				$pdf->Ln();

				$pdf->SetFont('Arial', '', 13);
				//$pdf->Cell(41,10,'Los platos de cada uno de los pedidos de la reserva con fecha '.$row['fechaReserva'].' son: ',0,0,'C');
				$pdf->Cell(55, 7, $row['nombrePlato'], 1);
				$pdf->Cell(15, 7, $row['cantidad'], 1);
				$pdf->Cell(34, 7, $row['detallePlatoAlergia'], 1);
				$fechaReserva3 = date("d/m/Y", strtotime($row['fechaReserva']));
				$pdf->Cell(40, 7, $fechaReserva3, 1);
				$pdf->Cell(31, 7, $row['idMesa'], 1);
				$pdf->Cell(16, 7, $row['turnoReserva'], 1);
				$pdf->Cell(23, 7, $row['horario'], 1);
				$mesaAux = $row['idMesa'];
				$pdf->Ln();
			}
			//$pdf->Output();

		}
		$data = [];
		$hoy = date("dmyhis");
		$pdfFilePath = "platosFecha" . $hoy . ".pdf";


		$this->response->setHeader('Content-Type', 'application/pdf');
		$pdf->Output('D', $pdfFilePath, false);
	}

	public function crearReporteChef()
	{
		$request = \Config\Services::request();
		$fechaInicio = $request->getPostGet('inputFechaInicioReportePlatosChef');
		$fechaFinal = $request->getPostGet('inputFechaHastaReportePlatosChef');

		if ($fechaInicio == "" || $fechaFinal == "") {
			return  redirect()->route('reportChef')->with('msg', ['type' => 'danger', 'body' => 'Error, no se ingreso un rango de fechas.Ingrese un rango de fechas valido.']);
		}
		$db = \Config\Database::connect();

		$query = $db->query('select p.nombrePlato,COUNT(p.nombrePlato)as cantidad,g.detallePlatoAlergia, r.fechaReserva, r.idMesa, r.turnoReserva, r.horario from reserva as r inner join pedido as g inner join plato as p inner join pedidoplato as c where (r.fechaReserva between "' . $fechaInicio . '" and "' . $fechaFinal . '") and r.idReserva = g.idReserva and g.nroPedido = c.nroPedido and c.idPlato = p.idPlato and r.estadoReserva = "En curso" group by p.nombrePlato,r.fechaReserva,r.turnoReserva order by r.fechaReserva asc,p.nombrePlato');

		if (count($query->getResultArray()) == 0) {
			//dd("aca if");
			return  redirect()->route('reportChef')->with('msg', ['type' => 'danger', 'body' => 'Error, no se pudo encontrar platos en el rango de fechas. Ingrese nuevamente.']);
			//return redirect()->back();
		}
		$this->obtenerPlatos($fechaInicio, $fechaFinal, $query->getResultArray());
	}


	public function imprimirReporteChef()
	{
		$request = \Config\Services::request();
		$fechaInicio = $request->getPostGet('inputFechaInicioReportePlatosChef');
		$fechaFinal = $request->getPostGet('inputFechaHastaReportePlatosChef');

		$db = \Config\Database::connect();

		$query = $db->query('select p.nombrePlato,COUNT(p.nombrePlato)as cantidad,g.detallePlatoAlergia, r.fechaReserva, r.idMesa, r.turnoReserva, r.horario from reserva as r inner join pedido as g inner join plato as p inner join pedidoplato as c where (r.fechaReserva between "' . $fechaInicio . '" and "' . $fechaFinal . '") and r.idReserva = g.idReserva and g.nroPedido = c.nroPedido and c.idPlato = p.idPlato and r.estadoReserva = "En curso" group by p.nombrePlato,r.fechaReserva,r.turnoReserva order by r.fechaReserva asc,p.nombrePlato');
		if (sizeof($query->getResultArray()) > 0) {
			echo json_encode(["status" => true, "data" => $query->getResultArray()]);
		} else {
			echo json_encode(["status" => false]);
		}

	}
	public function signout()
	{
		session()->destroy();
		return redirect()->route('home');
	}
}
