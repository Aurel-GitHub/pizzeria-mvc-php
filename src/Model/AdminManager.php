<?php

namespace App\Model;

use PDO;

class AdminManager extends AbstractManager
{
    public function findAllOrder()
    {
        $statement = $this->pdo->prepare("SELECT o.id, o.created_at, u.firstname, u.lastname, od.total FROM `order` AS o INNER JOIN `order_details` AS od ON od.order_id = o.id LEFT JOIN `user` AS u ON u.id = o.id_client ORDER BY o.created_at DESC ");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findOrderById($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM `order` WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function findAllOrderForToday()
    {
        $statement = $this->pdo->prepare("SELECT o.id, o.created_at, u.firstname, u.lastname, od.quantity, p.price 
        FROM `order` AS o INNER JOIN `order_details` AS od ON od.order_id = o.id 
        INNER JOIN `pizzas` AS p ON p.id = od.pizza_id 
        LEFT JOIN `user` AS u ON u.id = o.id_client 
        WHERE DAY(o.created_at) = DAY(NOW()) 
        ORDER BY o.created_at 
        DESC LIMIT 20");
        
        $statement->execute();
        return $statement->fetchAll();
    }

    public function sales()
    {
        $statement = $this->pdo->prepare("SELECT SUM(total) AS total_of_year FROM order_details");
        $statement->execute();
        return $statement->fetch();
    }

    public function salesofTheDay()
    {
        $statement = $this->pdo->prepare("SELECT SUM(total) AS total_of_day 
        FROM `order_details` AS od 
        LEFT JOIN `order` AS o ON o.id = od.order_id
        WHERE DAY(o.created_at) = DAY(NOW()) ");
        $statement->execute();
        return $statement->fetch();
    }

    public function showOrderById($id)
    {
        $statment = $this->pdo->prepare("SELECT o.id, o.created_at, u.firstname, u.lastname, od.quantity, p.price, p.name_pizza 
        FROM `order` AS o 
        INNER JOIN `order_details` AS od ON od.order_id = o.id 
        INNER JOIN `pizzas` AS p ON p.id = od.pizza_id 
        LEFT JOIN `user` AS u ON u.id = o.id_client
        WHERE o.id =:id ");
        $statment->bindValue('id', $id, \PDO::PARAM_INT);

        $statment->execute();
        return $statment->fetchAll();
    }
 
    /**
     *
     *  TODO Add Image in request
     */
    public function showAllPizza()
    {
        $statement = $this->pdo->prepare("SELECT p.id , p.name_pizza, p.price, p.image, p.isActived, c.name_category, p.description 
        FROM `pizzas` AS p 
        INNER JOIN `category` AS c ON c.id = p.category_id ");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function showPizzaByid($id)
    {
        $statement = $this->pdo->prepare("SELECT p.id, p.name_pizza, p.description, p.price, p.image, p.isActived ,c.name_category 
        FROM `pizzas` AS p 
        INNER JOIN `category` AS c ON c.id = p.category_id
        WHERE p.id =:id ");

        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        $statement->execute();
        return $statement->fetchAll();
    }

    public function findOnePizzaById($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM `pizzas` WHERE id=:id");

        $statement->bindValue('id', $id, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
    
    /**
     * TODO upload image
     */
    public function addPizza($pizza)
    {
        if ($_POST['submit']) {
            $name_pizza = strip_tags($_POST['name_pizza']);
            $description = strip_tags($_POST['description']);
            $price = strip_tags($_POST['price'] * 100);
            $isActived = strip_tags($_POST['isActived']);
            $category  = strip_tags($_POST['category_id']);
            $image = strip_tags($_POST['image']);
            // $image = $_FILES['image']['name'];

            // $uploadDir = __DIR__.'/';

            // $uploadFile = $uploadDir . basename($_FILES['image']['name']);

            // $test = $_FILES['image']['name'];

            // move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);

            $statement = $this->pdo->prepare("INSERT INTO pizzas (name_pizza, description, price, image, isActived, category_id ) VALUES (:name_pizza, :description, :price, :image, :isActived, :category_id)");
            $statement->bindValue(':name_pizza', $name_pizza, PDO::PARAM_STR);
            $statement->bindValue(':description', $description, PDO::PARAM_STR);
            $statement->bindValue(':price', $price, PDO::PARAM_INT);
            $statement->bindValue(':image', $image, PDO::PARAM_STR);
            $statement->bindValue(':isActived', $isActived, PDO::PARAM_BOOL);
            $statement->bindValue(':category_id', $category, PDO::PARAM_STR);
            
            $statement->execute();
        
            return (int)$this->pdo->lastInsertId();
        }
    }


    public function findAllCategoryForList()
    {
        $statement = $this->pdo->prepare("SELECT * FROM `category` ");
        
        $statement->execute();
        return $statement->fetchAll();
    }


    public function updatePizza($pizza)
    {
        $statement = $this->pdo->prepare("UPDATE pizzas SET id = :id , name_pizza = :name_pizza, 
        description = :description, price = :price, image = :image, isActived = :isActived, category_id = :category_id WHERE id=:id");
       
        $id = strip_tags(($_POST['id']));
        $name_pizza = strip_tags($_POST['name_pizza']);
        $description = strip_tags($_POST['description']);
        $price = strip_tags($_POST['price'] * 100);
        $image = strip_tags($_POST['image']);
        $isActived = strip_tags($_POST['isActived']);
        $category  = strip_tags($_POST['category_id']);

        /**
         * conserver les : en 1er arg de bindValue ??????
         */
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':name_pizza', $name_pizza, PDO::PARAM_STR);
        $statement->bindValue(':description', $description, PDO::PARAM_STR);
        $statement->bindValue(':price', $price, PDO::PARAM_INT);
        $statement->bindValue(':image', $image, PDO::PARAM_STR);
        $statement->bindValue(':isActived', $isActived, PDO::PARAM_BOOL);
        $statement->bindValue(':category_id', $category, PDO::PARAM_STR);
        
        return $statement->execute();
    }

    public function deletePizzaById(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM `pizzas` WHERE id=:id");
        $statement->bindValue('id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function addCategory()
    {
        if ($_POST['submit']) {
            $name_category = strip_tags($_POST['name_category']);

            $statement = $this->pdo->prepare("INSERT INTO category (name_category ) VALUES (:name_category)");
            $statement->bindValue(':name_category', $name_category, PDO::PARAM_STR);
            
            $statement->execute();
        
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function deleteCategoryById(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM `category` WHERE id=:id");
        $statement->bindValue('id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function showAllCustomers()
    {
        $statement = $this->pdo->prepare("SELECT * FROM `user` ");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function deleteCustomer($id)
    {
        $statement = $this->pdo->prepare("DELETE FROM `user` WHERE id=:id");
        $statement->bindValue('id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function addCustomer()
    {
        $firstname = strip_tags($_POST['firstname']);
        $lastname = strip_tags($_POST['lastname']);
        $email = strip_tags($_POST['email']);
        $adress = strip_tags($_POST['adress']);
        $password = strip_tags($_POST['password']);
        $passwordHash  = password_hash($password, PASSWORD_ARGON2ID);
        $role = strip_tags($_POST['role']);

        $statement = $this->pdo->prepare("INSERT INTO user (firstname, lastname, email, adress, password, role ) VALUES (:firstname, :lastname, :email, :adress, :password, :role)");
        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->bindValue(':adress', $adress, \PDO::PARAM_STR);
        $statement->bindValue(':password', $passwordHash, \PDO::PARAM_STR);
        $statement->bindValue(':role', $role, PDO::PARAM_BOOL);
        $statement->execute();

        return (int)$this->pdo->lastInsertId();
    }
}