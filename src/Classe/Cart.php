<?php

namespace App\Classe;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\Foreach_;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    private $requestStack;
    private $product;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $product)
    {
        $this->requestStack = $requestStack;
        $this->product = $product;
    }

    public function add($id)
    {
        $cart = $this->session->getCart('cart', []);

        //if (isset($cart[$id])) {
        if (!empty($cart[$id])) {
            //produit déjà dans le panier on incrémente
            $cart[$id]++;
        } else {
            //produit pas encore dans le panier on ajoute
            $cart[$id] = 1;
        }
        $this->updateCart($cart, $cart);
    }

    public function deleteFromCart($id)
    {
        $cart = $this->getCart();
        //si produit déjà dans le panier
        if (isset($cart[$id])) {
            //si il y a plus d'une fois le produit dans le panier on décrémente
            if ($cart[$id] >1) {
                $cart[$id] --;
            } else {
                //Sinon on supprime
                unset($cart[$id]);
            }
            //on met à jour la session
            $this->updateCart($cart);
        }
    }

    public function deleteAllToCart($id)
    {
        $cart = $this->getCart();
        //si produit(s) déjà dans le panier
        if (isset($cart[$id])) {
            //on supprime
            unset($cart[$id]);
        }
        //on met à jour la session
        $this->updateCart($cart);
    }

    public function remove()
    {
        //on supprime tous les produits (on vide le panier)
        $this->updateCart([]);
    }

    public function updateCart($cart)
    {
        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function getCart()
    {
        $session = $this->requestStack->getSession();
        return $session->get('cart', []);
    }

    public function getFull()
    {
        $cartComplete= [];

        if ($this->getCart()) {
            foreach ($this->getCart() as $id => $quantity) {
                $product_object=$this->entityManager->getRepository(Product::class)->findOneById($id);

                if (!$product_object) {
                    $this->deleteAllToCart($id);
                }
                $cartComplete[]= [
                    'product'=>$product_object,
                    'quantty' =>$quantity
                ];
            }
        }
        return $cartComplete;
    }
}
