<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Artist;
use App\Repository\AlbumRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class BrowseController extends AbstractController
{
    #[Route('/browse', name: 'app_browse')]
    public function index(): Response
    {
        return $this->render('browse/index.html.twig', [
            'controller_name' => 'BrowseController',
        ]);
    }

    #[Route('/browse/artists',name:'artist')]
    public function artists(ManagerRegistry $doctrine) : Response
    {
        $artistes = $doctrine->getRepository(Artist::class)->findBy([],['name'=>'ASC']);

        return $this->render("/browse/artists.html.twig",array(
            "artists"=>$artistes
        ));
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param int $artistId
     * @return Response
     */
    #[Route('/browse/albums/{artistId}', name: "album",requirements: ['artistId'=>'\d+'])]
    public function albums(ManagerRegistry $doctrine,int $artistId) : Response
    {


        $nom = $doctrine->getRepository(Artist::class)->find($artistId);
        if($artistId==0){
            return new Response(Response::HTTP_BAD_REQUEST);
        }
        if(!$nom){
            throw $this->createNotFoundException('The artist does not exist');

        }

        return $this->render("/browse/albums.html.twig",array(
            "artiste"=>$nom
        ));
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    #[Route('/browse/track/{id}',name: 'tracks')]
    #[Entity('album', expr: 'repository.findWithTracksAndSongs(id)')]
    public function tracks(ManagerRegistry $doctrine,Album $album): Response
    {


        return $this->render('browse/tracks.html.twig',array(
            "albums"=>$album,
        ));
    }
}
