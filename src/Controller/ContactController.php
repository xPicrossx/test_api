<?php

namespace App\Controller;

use App\Repository\ContactRepository; //cette ligne a rajouter
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(ContactRepository $repo): JsonResponse //la on a rajouté le ContactRepo $repo, ainsi que la ligne dessus
    {

        $contacts = $repo->findAll();

        return $this->json([
            'contacts' => $contacts
        ]);
    }
}
