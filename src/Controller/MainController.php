<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Profil;
use App\Services\LocationServices;
use App\Services\ProfilServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="app_main_")
 */
class MainController extends AbstractController
{

    private $profilService;
    private $locationService;

    public function __construct(ProfilServices $profilService, LocationServices $locationService)
    {
        $this->profilService = $profilService;
        $this->locationService = $locationService;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $currentUser = $this->profilService->recupererProfil();
        $locations = [];

        if ($currentUser instanceof Client) {   // L'utilisateur est un Client
            $locations = $this->locationService->recupererLocationsEnCoursClient($currentUser);

        }

        return $this->render('main/index.html.twig', [
            'locations' => $locations
        ]);
    }
}