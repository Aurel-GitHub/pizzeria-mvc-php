<?php

namespace App\Controller;

use App\Model\AdminManager;

class CartController extends AbstractController
{
    // public function show()
    // {
    //     if ($_SESSION) {
    //         $idSessionArray = $_SESSION['cart'];
    //         $array1 = array_unique($idSessionArray);

    //         $arrayName = [];
    //         $arrayPrice = [];

    //         foreach ($array1 as $result) {
    //             $manager = new AdminManager();
    //             $arrayResult = $manager->showPizzaByid($result);
    //             $arrayName[] = $arrayResult[0]['name_pizza'];
    //             $arrayPrice[] = $arrayResult[0]['price'];
    //         }

    //         $arrayQuantity = array_count_values($idSessionArray);
    //         var_dump($arrayQuantity);

    //         $arrayTotal = [];

    //         foreach ($arrayPrice as $valuePrice) {
    //             foreach ($arrayQuantity as $valueQuantity) {
    //                 $valuePrice = $valuePrice * $valueQuantity;
    //             }
    //             $arrayTotal[] = $valuePrice;
    //         }

    //         $arraySum = array_sum($arrayTotal);
    //         $totalOrder = ($arraySum / 100);
    //     } elseif (!$_SESSION) {
    //         $login = new UserController();
    //         $var = $login->login();

    //         return $var;
    //     }

    //     return $this->twig->render('Home/cart.html.twig', [
    //         'names' => $arrayName,
    //         'prices' => $arrayPrice,
    //         'quantities' => $arrayQuantity,
    //         'totals' => $arrayTotal,
    //     ]);
    // }

    // public function decrease()
    // {
    // }
}
