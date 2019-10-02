<?php

namespace App\Application\Common\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TestsController
 * @package App\Application\Common\Controller
 */
class TestsController extends BaseController
{
    /**
     * @var string
     */
    protected $yes = 'yes ça marche';
    /**
     * @var string
     */
    protected $cool = "Cool on va bien s'amuser";

    /**
     * @Route("/", name="home.index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('test/home.html.twig', [
            'yes' => $this->yes,
            'cool' => $this->cool,
        ]);
    }
}