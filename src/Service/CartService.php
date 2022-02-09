<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\DetailsOrder;
use App\Entity\Order;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService
{

    protected $session;
    protected $productRepository;
    protected $manager;

    public function __construct(SessionInterface $session, ProductRepository $productRepository, EntityManagerInterface $manager)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->manager = $manager;
    }

    public function addProduct(int $idProduct, int $qte=1)
    {
        $cart = $this->session->get('panier',[]);
        if(!empty($cart[$idProduct])){
            $cart[$idProduct]+= $qte;
        }else{
            $cart[$idProduct] = $qte;
        }
        $this->session->set('panier',  $cart);
        
    }

    public function removeProduct(int $idProduct)
    {
        $cart = $this->session->get('panier',[]);
        if(!empty($cart[$idProduct])){
            unset($cart[$idProduct]);
        }
        $this->session->set('panier', $cart);

        
    }

    public function removeItemQuantite(int $idProduct)
    {
        $cart = $this->session->get('panier',[]);
        if(!empty($cart[$idProduct])){
            $panier[$idProduct]=$cart[$idProduct]-1;
            if($cart[$idProduct]==0){
                $this->removeProduct($idProduct);
            }else{
                $this->session->set('panier', $cart);
            }
        }
    }

    public function getFullCart(): array
    {
        $cart = $this->session->get('panier',[]);
        $cartItem=[];
        foreach ($cart as $id => $quantity) {
            if($this->productRepository->find($id) !=null)
            {
                $cartItem[]=[
                    'produit' =>$this->productRepository->find($id) ,
                'quantite' => $quantity
            ];
            }

        }
        return $cartItem;
    }

    public function makeOrder(Client $client): int {
        $produits= $this->getFullCart();
        foreach($produits as $item)
        {
            $commande = new Order();
            $commande->setClient($client)
                ->setIsPaid(false)
                ->setStatut('EN Cours')
                ->setReference( uniqid('BR', true))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setTotal($this->getTotal())
                ->setUpdateAt(new \DateTime());
            $this->manager->persist($commande);
            $this->manager->flush();

            foreach( $produits as $item )
            {
                 $detail = new DetailsOrder();
                $detail->setProduct($item['produit'])
                    ->setQuantity($item['quantite'])
                    ->setTotal($item['quantite'] *$item['produit']->getPrice() )
                    ->setOrdeer($commande);
                    $commande->addDetailsOrder($detail);
                $this->manager->persist($detail);
            }
            $this->manager->flush();
            $this->cancelCart();
        }
        return 1;
    }
    public function getTotal(): float
    {
        $panierWithData = $this->getFullCart();
        $total = 0;
        foreach ($panierWithData as  $couple) {
            if( $couple['produit'] != null)
                $total += $couple['produit']->getPrice() * $couple['quantite'];
        }
        return $total;
    }
    public function cancelCart(){
        $this->session->remove('panier');

    }

}