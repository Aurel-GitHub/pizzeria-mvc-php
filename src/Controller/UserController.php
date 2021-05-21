<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function add()
    {
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $user = array_map('trim', $_POST);

            $userManager = new UserManager();
            $userManager->createAccount($user);

            header('Location:/');
            //  header('Location:/user/show/' . $id);
        }

        return $this->twig->render('Home/add.html.twig');
    }

    /**
     * Show informations for a specific item.
     */
    public function show(int $id): string
    {
        $userManager = new UserManager();
        // $user = $userManager->selectOneById($id);
        $user = $userManager->findOneById($id);

        return $this->twig->render('Test/show.html.twig', ['user' => $user]);
    }

    public function edit(int $id): string
    {
        $userManager = new UserManager();
        $user = $userManager->findOneById($id);

        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $user = array_map('trim', $_POST);

            $userManager->updateAccount($user);
            header('Location: /user/show/'.$id);
        }

        return $this->twig->render('Test/edit.html.twig', [
            'user' => $user,
        ]);
    }

    public function delete(int $id)
    {
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $itemManager = new UserManager();
            $itemManager->deleteById($id);
            header('Location:/');
        }
    }

    public function login()
    {
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $userManager = new UserManager();
            $user =
                [
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                ];
            $login = $userManager->login($user);

            if (password_verify($_POST['password'], $login['password'])) {
                // session_name('lePetitNaples');
                // session_start();
                $_SESSION['email'] = $login['email'];
                $_SESSION['id'] = $login['id'];
                $_SESSION['password'] = $login['password'];
                $_SESSION['firstname'] = $login['firstname'];
                $_SESSION['lastname'] = $login['lastname'];
                $_SESSION['adress'] = $login['adress'];
                $_SESSION['role'] = $login['role'];
                //$_SESSION['cart'] = [];
                // echo session_status();
                header('Location:/');
            } else {
                header('Location:/User/login');
            }
        }

        return $this->twig->render('Login/login.html.twig');
    }

    public function logout()
    {
        if ($_SESSION) {
            $_SESSION = [];
            // session_write_close();
            //session_unset();
            unset($_SESSION);
            session_destroy();
            echo session_status();
            //unset($_SESSION);
            // header('Location:/');
        }
    }

    // public function login()
    // {

    //     $emails = new UserManager();
    //     $arrayEmailFromDB = $emails->testVerifEmail();

    //     // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     //     // $verifyMail = new UserManager();
    //     //     // $test = $verifyMail->verifyEmail();

    //     //     if (isset($_POST['email'])) {
    //     //         if (in_array($_POST['email'], $arrayEmailFromDB)) {
    //     //         }
    //     //     }

    //     //     // if ($tests != $_POST['password']){

    //     // }

    //     return $this->twig->render('Home/login.html.twig', [
    //         'array' => $arrayEmailFromDB,
    //     ]);
    // }

    // /**
    //  * Set the value of user
    //  *
    //  * @return  self
    //  */
    // public function setUser($user)
    // {
    //     $this->user = $user;

    //     return $this;
    // }
}
