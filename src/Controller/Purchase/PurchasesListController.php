<?php

namespace App\Controller\Purchase;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class PurchasesListController extends AbstractController
{
    protected $security;
    protected $router;
    protected $twig;

    public function __construct(Security $security, RouterInterface $router, Environment $twig)
    {
        $this->security = $security;
        $this->router = $router;
        $this->twig = $twig;
    }

    /**
     * @Route("/purchases", name="purchase_index")
     */
    public function index()
    {
        // 1. Nous devons nous assurer que la personne est connectée (sinon redirection vers la page d'accueil) -> Security
        /** @var User */
        $user = $this->security->getUser();

        if (!$user) 
        {
            // Générer une URL en fonction du nom d'une route -> UrlGeneratorRouterInterface
            throw new AccessDeniedException("Vous devez être connecté pour accéder à vos commandes");
            
        }

        // 2. Nous voulons savoir QUI est connecté -> Security
        // 3. Nous voulons passer l'utilsiateur connecté à Twig afin d'afficher ses commandes -> Environment de twig / Response
        $html = $this->twig->render('purchase/purchase.html.twig', [
            'purchases' => $user->getPurchases()
        ]);
        return new Response($html);
    }
}