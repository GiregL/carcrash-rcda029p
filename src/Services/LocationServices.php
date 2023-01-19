<?php

namespace App\Services;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Repository\LocationRepository;
use Symfony\Component\Security\Core\Security;

/**
 * Services de gestion de locations
 */
class LocationServices
{
    private $clientRepository;
    private $locationRepository;

    public function __construct(ClientRepository $clientRepository, LocationRepository $locationRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * Retourne la liste des locations en cours d'un client.
     * Triées du plus vieux au plus récent.
     * @param Client $client Client concerné
     * @return array Array des locations en cours d'un client
     */
    public function recupererLocationsEnCoursClient(Client $client): array
    {
        if ($this->clientRepository->find($client->getId()) !== null)
        {
            return [];
        }
        return $this->locationRepository->recupererLocationsEnCoursClient($client);
    }
}
