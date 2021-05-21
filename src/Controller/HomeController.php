<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40.
 */

namespace App\Controller;

use App\Model\AdminManager;
use App\Model\CartManager;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ForEachLoopDeclarationSniff;

class HomeController extends AbstractController
{
    /**
     * Display home page.
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     *
     * @return string
     */
    public function index()
    {
        $manager = new AdminManager();
        $pizzas = $manager->showAllPizza();
        //$sessions = '';
        if (isset($_GET['addToCart'])) {
            switch (isset($_SESSION['cart'][$_GET['addToCart']])) {
                case false:
                    $_SESSION['cart'][$_GET['addToCart']] = 1;

                    break;

                case true:
                    ++$_SESSION['cart'][$_GET['addToCart']];

                    break;
                    //$sessions = $_SESSION['cart'];
            }
            //var_dump($sessions);
            //return $this->twig->render('Home/index.html.twig', ['pizzas' => $pizzas, 'sessions' => $sessions]);
            //}
            header('Location: /Home/index');

            exit();
            //var_dump($_SESSION['cart']);
        // $sessions = $_SESSION['cart'];
        //} elseif (!$_SESSION) {
        //    header('location:/user/login');
        }

        return $this->twig->render('Home/index.html.twig', ['pizzas' => $pizzas]);
    }

    public function product()
    {
        return $this->twig->render('Home/product.html.twig');
    }

    public function user()
    {
        return $this->twig->render('Home/user.html.twig');
    }

    public function cart()
    {

        $manager = new AdminManager();

        $arraySession = $_SESSION['cart'];
        // var_dump($_SESSION);
        //boucle pour séparer les clés des qtés
        $testKey = [];
        $arrayQuantities = []; 
        foreach ($arraySession as $key => $valueQuantity) {
             $testKey[] = $key; 
            $arrayQuantities[] = $valueQuantity;

        }

        //boucle pour stocker les id
        $arrayId = [];
        foreach ($testKey as $key => $idPizza) {
            $arrayId[] = $idPizza;

        }

        // affichage par id
        $results = [];
        foreach ($arrayId as $key => $id) {
            $results[] = $manager->findOnePizzaById($id);       
        }
        
        // if ($_POST['submit']) {
        //     $var = array_map('trim', $_GET);

        //     $cartManager = new CartManager();
        //     $cartManager->sendOrderDetailInDb($var);

        //     header('Location:/');
        // }
        
        return $this->twig->render('Home/cart.html.twig', [
            'results' => $results,
            'quantities' => $arrayQuantities
        ]);
    }



    public function error_page()
    {
        return $this->twig->render('Home/404.html.twig');
    }

    public function verifAdminAccess()
    {
        // $session = $_SESSION['role'];
        // $var = implode('',$session);

        // return $this->twig->render('layout.html.twig', [
        //     'session_role' => $var
        // ]);
    }

    // public function error_page()
    // {
    //     return $this->twig->render('Home/404.html.twig');
    // }

    // public function addToCart()
    // {
    //     if (isset($_GET['addToCart'])) {
    //         switch (isset($_SESSION['cart'][$_GET['addToCart']])) {
    //             case false:
    //                 $_SESSION['cart'][$_GET['addToCart']] = 1;

    //                 break;

    //             case true:
    //                 ++$_SESSION['cart'][$_GET['addToCart']];

    //                 break;
    //         }
    //     }

    // $manager = new AdminManager();
    // $pizza = $manager->showPizzaByid($id);

    // if($_SESSION) {
    //     $_SESSION['cart']['id'] = $pizza[0]['id'];
    //     if (!is_array($pizza[0]['id'])) {
    //         array_push($_SESSION['cart'], $pizza[0]['id']);
    //         array_count_values($_SESSION['cart']);
    //     }
    //     header('Location: /#menu');
    // } elseif(!$_SESSION) {
    //     $login  = new UserController();
    //     $var = $login->login();
    //     return $var;
    // }

    /**
     * Set the value of sessions.
     *
     * @param mixed $sessions
     *
     * @return self
     */
    public function setSessions($sessions)
    {
        $this->sessions = $sessions;

        return $this;
    }
}

    // public function addToCartFromDetail($id)
    // {
    //     $manager = new AdminManager();
    //     $pizza = $manager->showPizzaByid($id);

    //     if ($_SESSION) {
    //         $_SESSION['cart']['id'] = $pizza[0]['id'];
    //         if (!is_array($pizza[0]['id'])) {
    //             array_push($_SESSION['cart'], $pizza[0]['id']);
    //             array_count_values($_SESSION['cart']);
    //             header('Location: /cart/show');
    //         }
    //     } elseif (!$_SESSION) {
    //         $login = new UserController();
    //         $var = $login->login();

    //         return $var;
    //     }
    // }

//     public function pizzaDetail($id)
//     {
//         $manager = new AdminManager();
//         $pizza = $manager->showPizzaByid($id);

//         return $this->twig->render('Home/product.html.twig', [
//             'pizza' => $pizza,
//         ]);
//     }
