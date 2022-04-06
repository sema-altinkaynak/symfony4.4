<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HelloController extends AbstractController
{
    public function index(string $name): Response
    {
        return $this->render('hello/index.html.twig', [
            'controller_name' => $name,
        ]);
    }

    #[Route('/hello/{name}/{times}', name: 'manytimes',requirements: ["times"=>"\d+"])]
    public function helloManyTimes(string $name, int $times=2) : Response
    {
        if(0==$times || $times>10){
            return $this->redirectToRoute('/hello/{name}/{times}',array("name"=>$name,"times"=>3));
        }
        return $this->render('hello/hellomanytimes.html.twig',array(
            "name"=>$name,
            "times"=>$times
        ));
    }

}
