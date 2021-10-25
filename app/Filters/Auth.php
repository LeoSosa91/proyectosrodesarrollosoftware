<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->is_logged) {
            return redirect()->route('home')->with('msg',['type'=> 'warning', 'body'=>'Para acceder a este lugar primero debe loguear su cuenta']);
        }
        $model= model('UserModel');
        if (!$user=$model->getUserBy('id_user',session()->id_user)) {
            session()->destroy();
            return redirect()->route('home')->with('msg',['type'=> 'danger', 'body'=>'El usuario actualmente no esta disponible']);
        }
        if (!in_array($user->getRole()->name_group,$arguments)) {
            session()->destroy();
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}