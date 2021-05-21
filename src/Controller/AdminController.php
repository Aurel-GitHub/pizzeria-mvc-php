<?php
namespace App\Controller;

use App\Model\AdminManager;

class AdminController extends AbstractController
{

    /**
     * Home page Dashboard
     */
    public function home()
    {
        $adminManager = new AdminManager();

        $orderOfTheDay = $adminManager->findAllOrderForToday();

        $salesCompany = $adminManager->sales();

        $salesOfTheDay = $adminManager->salesofTheDay();
        
        return $this->twig->render('Admin/index.html.twig', [
            'sales' => $salesCompany,
            'orders' => $orderOfTheDay,
            'sales_of_day' => $salesOfTheDay
        ]);
    }

    /**
     * All Orders
     */
    public function allOrders()
    {
        $adminManager = new AdminManager();
        
        $allOrder = $adminManager->findAllOrder();

        $salesCompany = $adminManager->sales();

        $salesOfTheDay = $adminManager->salesofTheDay();


        return $this->twig->render('Admin/allorder.html.twig', [
            'orders' => $allOrder,
            'sales_of_day' => $salesOfTheDay,
            'sales' => $salesCompany
            ]);
    }


    /**
     * Order Detail
     */
    public function show($id)
    {
        $adminManager = new AdminManager();

        $showById = $adminManager->findOrderById($id);

        $salesCompany = $adminManager->sales();

        $salesOfTheDay = $adminManager->salesofTheDay();

        $showOrderDetails = $adminManager->showOrderById($id);

        $idCommande = $showOrderDetails[0]['id'];

        return $this->twig->render('Admin/show.html.twig', [
            'orders' => $showById,
            'sales_company' => $salesCompany,
            'sales_of_the_day' => $salesOfTheDay,
            'details' => $showOrderDetails,
            'idCommande' => $idCommande
        ]);
    }

    /**
     * All pizza
     */
    public function showPizza()
    {
        $adminManager = new AdminManager();

        $orderOfTheDay = $adminManager->findAllOrderForToday();

        $salesCompany = $adminManager->sales();

        $salesOfTheDay = $adminManager->salesofTheDay();
        
        $allPizzaList = $adminManager->showAllPizza();
        
        return $this->twig->render('Admin/allpizza.html.twig', [
            'sales' => $salesCompany,
            'orders' => $orderOfTheDay,
            'sales_of_day' => $salesOfTheDay,
            'all_pizzas' => $allPizzaList
        ]);
    }

    /**
     * Pizza Detail
     */
    public function detailPizza($id)
    {
        $adminManager = new AdminManager();

        $salesCompany = $adminManager->sales();

        $salesOfTheDay = $adminManager->salesofTheDay();

        $pizzaById = $adminManager->showPizzaByid($id);
    
        return $this->twig->render('Admin/detailpizza.html.twig', [
            'sales' => $salesCompany,
            'sales_of_day' => $salesOfTheDay,
            'pizzas' => $pizzaById,
        ]);
    }

    public function editPizza($id)
    {
        $adminManager = new AdminManager();

        $arrayPizza = $adminManager->findOnePizzaById($id);

        $salesCompany = $adminManager->sales();

        $salesOfTheDay = $adminManager->salesofTheDay();

        $categoryList = $adminManager->findAllCategoryForList();

        $allPizzaList = $adminManager->showAllPizza();

        $pizzaById = $adminManager->showPizzaByid($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $arrayPizza = array_map('trim', $_POST);

            $adminManager->updatePizza($arrayPizza);

            header('Location: /admin/showpizza');
        }

        return $this->twig->render('Admin/editpizza.html.twig', [
            'item' => $arrayPizza,
            'sales' => $salesCompany,
            'sales_of_day' => $salesOfTheDay,
            'categories' => $categoryList,
            'all_pizzas' => $allPizzaList,
            'pizzas' => $pizzaById,
        ]);
    }

    /**
     *Add Upload Image !!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    public function addPizza()
    {
        $adminManager = new AdminManager();

        $salesOfTheDay = $adminManager->salesofTheDay();
        
        $salesCompany = $adminManager->sales();

        $categoryList = $adminManager->findAllCategoryForList();

        $allPizzaList = $adminManager->showAllPizza();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $var = array_map('trim', $_POST);

            $id = $adminManager->addPizza($var);

            header('Location:/admin/detailpizza/' . $id);
        }

        return $this->twig->render('Admin/addpizza.html.twig', [
            'sales_of_day' => $salesOfTheDay,
            'sales' => $salesCompany,
            'categories' => $categoryList,
            'all_pizzas' => $allPizzaList
        ]);
    }

    public function deletePizza($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $manager = new AdminManager();
            $manager->deletePizzaById($id);
            header('Location:/admin/showpizza');
        }
    }



    public function addCategory()
    {
        $adminManager = new AdminManager();

        $salesOfTheDay = $adminManager->salesofTheDay();
        
        $salesCompany = $adminManager->sales();

        $categoryList = $adminManager->findAllCategoryForList();

        $allPizzaList = $adminManager->showAllPizza();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $var = array_map('trim', $_POST);

            $id = $adminManager->addCategory($var);

            header('Location:/admin/allcategory');
        }

        return $this->twig->render('Admin/addcategory.html.twig', [
            'sales_of_day' => $salesOfTheDay,
            'sales' => $salesCompany,
            'categories' => $categoryList,
            'all_pizzas' => $allPizzaList
        ]);
    }

    public function allCategory()
    {
        $adminManager = new AdminManager();

        $orderOfTheDay = $adminManager->findAllOrderForToday();

        $salesCompany = $adminManager->sales();

        $salesOfTheDay = $adminManager->salesofTheDay();
        
        $allCategoryList = $adminManager->findAllCategoryForList();
        
        return $this->twig->render('Admin/allcategory.html.twig', [
            'sales' => $salesCompany,
            'orders' => $orderOfTheDay,
            'sales_of_day' => $salesOfTheDay,
            'all_categories' => $allCategoryList
        ]);
    }
    

    public function deleteCategory($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $manager = new AdminManager();
            $manager->deleteCategoryById($id);
            header('Location:/admin/allcategory');
        }
    }

    public function allCustomers()
    {
        $adminManager = new AdminManager();

        $orderOfTheDay = $adminManager->findAllOrderForToday();

        $salesCompany = $adminManager->sales();

        $salesOfTheDay = $adminManager->salesofTheDay();
        
        $allCustomersList = $adminManager->showAllCustomers();
        
        return $this->twig->render('Admin/allcustomers.html.twig', [
            'sales' => $salesCompany,
            'orders' => $orderOfTheDay,
            'sales_of_day' => $salesOfTheDay,
            'all_customers' => $allCustomersList
        ]);
    }

    public function deleteCustomer($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $manager = new AdminManager();
            $manager->deleteCustomer($id);
            header('Location:/admin/allcustomers');
        }
    }

    public function addCustomer()
    {
        $adminManager = new AdminManager();

        $salesOfTheDay = $adminManager->salesofTheDay();
        
        $salesCompany = $adminManager->sales();

        $roleUsers = $adminManager->showAllCustomers();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $var = array_map('trim', $_POST);

            $id = $adminManager->addCustomer($var);

            header('Location:/admin/allcustomers');
        }

        return $this->twig->render('Admin/addcustomer.html.twig', [
            'sales_of_day' => $salesOfTheDay,
            'sales' => $salesCompany,
            'users' => $roleUsers
        ]);
    }
}