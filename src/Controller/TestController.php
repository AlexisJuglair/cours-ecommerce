<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    /**
     * @Route("/", name="index")
     */
    public function index() 
    {
        dd("ça fonctionne");
    }

    /**
     * @Route("/test/{age<\d+>?0}", name="test", methods={"GET", "POST"}, host="localhost", schemes={"http", "https"})
     */
    public function test(Request $request, $age) 
    {
        //$request = Request::createFromGlobals();

        //dump($request);

        //$age = $request->query->get('age', 0);
        //$age = $request->attributes->get('age');

        // $age = 0;

        // if (!empty($_GET['age'])) {
        //     $age = $_GET['age'];
        // }
       
        return new Response("Vous avez $age ans !");
    }
}