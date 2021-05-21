<?php

namespace App\Model;

use PDO;

class CartManager extends AbstractManager
{
    public function sendOrderDetailInDb()
    {
        $pizzaID = $_GET['pizza_id'];
        $total = $_GET['total'];
        $quantity = $_GET['quantity'];

        $statement = $this->pdo->prepare("INSERT INTO order_details (pizza_id, total, quantity ) VALUES (:pizza_id, :total, :quantity)");
        $statement->bindValue(':pizza_id', $pizzaID, PDO::PARAM_STR);
        $statement->bindValue(':total', $total, PDO::PARAM_INT);
        $statement->bindValue(':quantity', $quantity, PDO::PARAM_INT);
            
        $statement->execute();
        return $this->pdo->lastInsertId();
    }

    public function sendOrder()
    {

    }
}
