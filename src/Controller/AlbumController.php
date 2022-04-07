<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{
    #[ParamConverter("album",options: ["id"=>"id"])]
    #[Route('/album', name: 'app_album')]
    public function index(): Response
    {
        return $this->render('album/index.html.twig', [
            'controller_name' => 'AlbumController',
        ]);
    }

    #[ParamConverter("album",options: ["id"=>"id"])]
    #[Route('/album/edit/{id}',name: "edit")]
    public function edit(Album $album){

        $element = new AlbumType();
        $form = $this->createForm(AlbumType::class,$album);

        return $this->renderForm("album/edit.html.twig",array(
            'form'=>$form
        ));
    }

    #[ParamConverter("album",options: ["id"=>"id"])]
    #[Route('/album/delete/{id}',name: "delete")]
    public function delete(Album $album){

        return $this->render("album/delete.html.twig",array());
    }

    #[Route("/album/new",name: "new")]
    public function new(){
        return $this->render("album/new.html.twig",array());
    }

}
