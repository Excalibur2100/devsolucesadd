<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager =$entityManager;
    }


    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart)
    {
        dd($cart->getCart());
        // $cartComplete = [];

        // foreach ($cart->getCart() as $id => $quantity) {
        //     $cartComplete[]= [
        //         'product'=>$this->entityManager->getRepository(Product::class)->findOneById($id),
        //         'quantity'=> $quantity
        //     ];
        // }
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getCart()
        ]);
    }

    #[Route("/cart/add/{id}", name: "app_add_to_cart")]

    public function add(Cart $cart, $id)
    {
        $cart->add($id);


        return $this->redirectToRoute('app_cart');
    }

    #[Route("/cart/deleteCart", name: "app_delete_my_cart")]

    public function remove(Cart $cart)
    {
        $cart->remove();


        return $this->redirectToRoute('app_products');
    }

    // #[Route("/cart/remove", name: "app_delete_all_cart")]

    // public function deleteAllToCart(Cart $cart, $id)
    // {
    //     $cart->deleteAllToCart();

    //     return $this->redirectToRoute('app_products');
    // }






    // #[Route("/cart/deleteCar", name: "app_deleteCar")]

    // public function deleteCar(Cart $cart)
    // {
    //     $cart->updateCart([]);


    //     return $this->redirectToRoute('app_products');
    // }

    // #[Route("/cart/deleteAllToCart", name: "app_deleteAllToCart")]

    // public function deleteAllToCart(Cart $cart)
    // {
    //     $cart->updateCart([]);


    //     return $this->redirectToRoute('app_products');
    // }
}
