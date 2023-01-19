<?php

namespace App\Services;

use App\Repository\ClientRepository;
use App\Repository\ProfilRepository;
use Symfony\Component\Security\Core\Security;

class ProfilServices {

    private $security;
    private $profilRepository;
    private $clientRepository;

    public function __construct(Security $security, ClientRepository $clientRepository, ProfilRepository $profilRepository) {
        $this->security = $security;
        $this->profilRepository = $profilRepository;
        $this->clientRepository = $clientRepository;
    }

    public function recupererProfil()
    {
        if ($this->security->isGranted("ROLE_COMMERCIAL")) {
            return $this->profilRepository->find($this->security->getUser()->getId());
        } else if ($this->security->isGranted("ROLE_USER")) {
            // pas une erreur, Vscode n'arrive pas a recuperer l'Id du User dans UserInterface
            return $this->clientRepository->recupererClientByUserId($this->security->getUser()->getId());
        } else {
            return null;
        }
    }
}