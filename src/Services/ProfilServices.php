<?php

namespace App\Services;

use App\Repository\ClientRepository;
use App\Repository\ProfilRepository;
use Symfony\Component\Security\Core\Security;

class ProfilServices {

    private $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    public function recupererProfil(ClientRepository $clientRepository, ProfilRepository $profilRepository)
    {

        if ($this->security->isGranted("ROLE_COMMERCIAL")) {
            return $profilRepository->find($this->security->getUser()->getId());
        } else if ($this->security->isGranted("ROLE_USER")) {
            // pas une erreur, Vscode n'arrive pas a recuperer l'Id du User dans UserInterface
            return $clientRepository->find($this->security->getUser()->getId()); 
        } else {
            return null;
        }
    }
}