<?php
require_once '../connection_manager.php';
session_start();

if (!isset($_SESSION["username"], $_SESSION["type"]) || $_SESSION["type"] != 'customer') {
    die("Incorrect session info");
}

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = json_decode(file_get_contents("php://input"), true);
    $conn = getConnection();
    $grandTotal = 0;
    $restaurantId = $json['restaurantId'];
    $customerId = $_SESSION["customerId"];

    $food_order_stmt = "INSERT INTO food_order (food_id, order_id, count) VALUES ";

    foreach ($json['foodList'] as $foodItem) {
        $foodId = $foodItem['id'];
        $foodCount = $foodItem['count'];
        $total = $foodItem['total'];
        $sql_query = "($foodId, #ORDER_ID#, $foodCount), ";

        $grandTotal += $total;
        $food_order_stmt .= $sql_query;
    }

    $food_order_stmt = rtrim($food_order_stmt, ', ');

    $order_stmt = "INSERT INTO orders(customer_id, restaurant_id, delivery_man_id, status, total_amount)
                    VALUES ($customerId, $restaurantId, null, 'Processing', $grandTotal);";
    mysqli_query($conn, $order_stmt);

    $result = mysqli_query($conn, "SELECT LAST_INSERT_ID() as id;");
    if (mysqli_num_rows($result) == 0) {
        $response = getResponse(false, "Can't add order");
        echo json_encode($response);
        die();
    }

    $row = mysqli_fetch_assoc($result);
    $order_id = $row['id'];

    $food_order_stmt = preg_replace('/#ORDER_ID#/i', $order_id, $food_order_stmt);

    mysqli_query($conn, $food_order_stmt);

    $response = getResponse(true, "Order placed.");
} else {
    $response = getResponse(false, "Wrong request method.");
}

function getResponse($status, $msg) {
    return array(
        'status' => $status,
        'message' => $msg
    );
}

echo json_encode($response);