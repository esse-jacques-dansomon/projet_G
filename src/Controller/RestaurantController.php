<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\BurgerRepository;
use App\Repository\ClientRepository;
use App\Repository\ComplementRepository;
use App\Repository\MenuRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{


    /**
     * @Route("/restaurant", name="restaurant")
     */
    public function restaurant(BurgerRepository  $burgerRepository, MenuRepository $menuRepository, ComplementRepository  $complementRepository): Response
    {
        $menus = $menuRepository->findAll();
        $burgers =$burgerRepository->findAll();
        $complements = $complementRepository->findAll();
        return $this->render('restaurant/restaurant.html.twig', [
            'menues' => $menus,
            'burgers' => $burgers,
            'complements' => $complements
        ]);
    }


    /**
     * @Route("/produit-detail/{id}", name="product-detail")
     */
    public function menu( ?Product  $produit): Response
    {
        if($produit != null )
        {
            return $this->render('restaurant/produit.html.twig', [
                'produit'=> $produit
            ]);
        }
        return $this->redirectToRoute('restaurant');

    }

    /**
     * @Route("/panier", name="panier")
     */
    public function panier(CartService $cartService ): Response
    {
        $produits = $cartService->getFullCart();
        $tatalPanier = $cartService->getTotal();
        return $this->render('restaurant/panier.html.twig', [
            'produits'=>$produits,
            'total'=>$tatalPanier,
        ]);
    }

    /**
     * @Route("/mes-commandes", name="commandes")
     */
    public function mes_commandes(): Response
    {
        return $this->render('restaurant/mes-commandes.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/checkout", name="checkout")
     */
    public function checkout(CartService $cartService, ClientRepository  $clientRepository): Response
    {
        $client = $clientRepository->find($this->getUser()->getId());
        $cartService->makeOrder($client);
        return $this->redirectToRoute('commandes');
    }


    /**
     * @Route("/add-to-cart/{id}", name="add-to-cart")
     */
    public function ajouterAuPanier(CartService $cartService, ?Product $product ): Response
    {
        if($product != null)
        {
            $cartService->addProduct($product->getId());
            return $this->redirectToRoute("panier");
        }

        return $this->redirectToRoute("restaurant");
    }

    /**
     * @Route("/remove-produit-du-panier/{id}", name="remove-to-cart")
     */
    public function envelerDuPanier(CartService $cartService, ?Product $product ): Response
    {
        if($product != null)
        {
            $cartService->removeProduct($product->getId());
            return $this->redirectToRoute("panier");
        }
        return $this->redirectToRoute("restaurant");
    }


}
