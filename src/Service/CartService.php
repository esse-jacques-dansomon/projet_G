<?php

namespace App\Service\Panier;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService
{

    protected $session;
    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function addProduct(int $idProduct)
    {
        $cart = $this->session->get('cart',[]);
        if(!empty($cart[$idProduct])){
            $cart[$idProduct]++;
        }else{
            $cart[$idProduct] = 1;
        }
        $this->session->set('cart',  $cart);
        
    }

    public function removeProduct(int $idProduct)
    {
        $cart = $this->session->get('cart',[]);
        if(!empty($cart[$idProduct])){
            unset($cart[$idProduct]);
        }
        $this->session->set('cart', $cart);

        
    }

    public function removeItemQuantite(int $idProduct)
    {
        $cart = $this->session->get('cart',[]);
        if(!empty($cart[$idProduct])){
            
            $panier[$idProduct]=$cart[$idProduct]-1;
            if($cart[$idProduct]==0){

                $this->removeProduct($idProduct);

            }else{
                $this->session->set('cart', $cart);
            }

        }
        

        
    }

    public function getFullCart(): array
    {
        $cart = $this->session->get('cart',[]);
        $cartItem=[];
        foreach ($cart as $id => $quantity) {
           
            $cartItem[]=[
                'item' => $this->productRepository->find($id),
                'quantite' => $quantity
            ];
        }

        return $cartItem;
    }

    public function getTotal(): float
    {
        $panierWithData = $this->getFullCart();

        $total = 0;

        foreach ($panierWithData as $couple) {
            $total += $couple['item']->getPrice() * $couple['quantite'];
        }

        return $total;
    }
    public function cancelCart(){

       
       
        $this->session->remove('cart');

    }

}