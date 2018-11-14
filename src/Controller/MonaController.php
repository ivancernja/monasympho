<?php
namespace App\Controller;

use App\Entity\Mona;
use App\Repository\MonaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MonaController extends ApiController
{
    /**
    * @Route("/mona")
    * @Method("GET")
    */
    public function index(MonaRepository $monaRepository)
    {
        $mona = $monaRepository->transformAll();

        return $this->respond($mona);
    }

    /**
     * @Route("/mona/{id}")
     * @Method("GET")
     */
    public function show($id, MonaRepository $monaRepository)
    {
        $mona = $monaRepository->find($id);

        if (! $mona) {
            return $this->respondNotFound();
        }

        $mona = $monaRepository->transform($mona);

        return $this->respond($mona);
    }

    /**
    * @Route("/mona")
    * @Method("POST")
    */
    public function create(Request $request, MonaRepository $monaRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the title
        if (! $request->get('title')) {
            return $this->respondValidationError('Please provide a title!');
        }

        $mona = new Mona;
        $mona->setTitle($request->get('title'));
        $mona->setCount(0);
        $em->persist($mona);
        $em->flush();

        return $this->respondCreated($monaRepository->transform($mona));
    }

    /**
    * @Route("/mona/{id}/count")
    * @Method("POST")
    */
    public function increaseCount($id, EntityManagerInterface $em, MonaRepository $monaRepository)
    {
        $mona = $monaRepository->find($id);

        if (! $mona) {
            return $this->respondNotFound();
        }

        $mona->setCount($mona->getCount() + 1);
        $em->persist($mona);
        $em->flush();

        return $this->respond([
            'count' => $mona->getCount()
        ]);
    }
}