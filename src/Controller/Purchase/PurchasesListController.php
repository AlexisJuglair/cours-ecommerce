<?php

namespace App\Controller\Purchase;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PuchasesListController extends AbstractController
{
    public function index()
    {
        // 1. Nous devons nous assurer que la personne est connectée(sinon redirection vers la page d'accueil)

        // 2. Nous voulons savoir QUI est connecté

        // 3. Nous voulons passer l'utilsiateur connecté à Twig afin d'afficher ses commandes
    }
}

