<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class MonaController extends ApiController
{
    /**
    * @Route("/mona")
    */
    public function moviesAction()
    {
        return $this->respond([
            [
                'title' => 'Brcko',
                'count' => 0
            ]
        ]);
    }
}