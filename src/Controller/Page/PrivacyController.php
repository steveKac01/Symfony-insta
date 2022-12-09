<?php

namespace App\Controller\Page;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrivacyController extends AbstractController
{
    /**
     * Privacy page.
     *
     * @return Response
     */
    #[Route('/privacy', name: 'privacy')]
    public function index(): Response
    {
        return $this->render('pages/privacy.html.twig', []);
    }
}
