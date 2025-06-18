<?php

function getConnection()
{
    $conn = mysqli_connect("localhost", "root", "", "food");

    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}