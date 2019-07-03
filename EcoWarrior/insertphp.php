<?php
$firstname =  $_POST['firstname'];
$lastname = $_POST['lastname'];
$email =  $_POST['email'];
$productchosen = $_POST['productchosen'];
$remark =  $_POST['remark'];
$country = $_POST['country'];
$shippingaddress = $_POST['shippingaddress'];
$postcode =  $_POST['postcode'];
$city = $_POST['city'];


    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "assignment1";


    //create connection for database
    $conn = mysqli_connect ($host, $dbUsername, $dbPassword);

    if (mysqli_connect_error()) {
        die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
        } else {
            
        //create database
        $sql = "CREATE DATABASE assignment1";

        if ($conn->query($sql) === TRUE) {
            echo "Database created successfully";
        } else {
            echo "Error creating database: " . $conn->error;
        }
    }

        $conn->close();

        $conn = mysqli_connect ($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
        } else {

        //sql to create table
        $sql = "CREATE TABLE purchase (
            ID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(20) NOT NULL,
            lastname VARCHAR(20) NOT NULL,
            email VARCHAR(40) NOT NULL,
            productchosen VARCHAR(20) NOT NULL,
            remark VARCHAR(20) NOT NULL,
            country VARCHAR(20) NOT NULL,
            shippingaddress VARCHAR(400) NOT NULL,
            postcode VARCHAR(10) NOT NULL,
            city VARCHAR(20) NOT NULL,
            reg_date TIMESTAMP
            )";

    if ($conn->query($sql) === TRUE) {
        echo "Table MyGuests created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
        } 
        
        $conn->close();        

        //create connection again with the table and database
        $conn = mysqli_connect ($host, $dbUsername, $dbPassword, $dbname);


if (!empty($firstname) || !empty($lastname) || !empty($email) || !empty($productchosen) || !empty($remark) || !empty($country) || !empty($shippingaddress) || !empty($postcode) || !empty($city)) {

        if (mysqli_connect_error()) {
            die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
        } else {

            $SELECT = "SELECT email From purchase Where email = ? Limit 1";
            $INSERT = "INSERT Into purchase (firstname, lastname, email, productchosen, remark, country, shippingaddress, postcode, city)
            values (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            //Prepare statement
            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            $rnum = $stmt->num_rows;

            if ($rnum==0) {
                $stmt->close();
            
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("sssssssis", $firstname, $lastname, $email, $productchosen, $remark, $country, $shippingaddress, $postcode, $city);
                $stmt->execute();
                echo "New record inserted successfully";
            } else {
                echo "Someone already register using this email";
            }
            $stmt->close();
            $conn->close();

        }
} else {
    echo "All fields are required";
    die();
}

/* Redirect browser */
header("Location: https://tayzhenrui.github.io/web1201-webfund/thankyou_purchaseform.html");
 
/* Make sure that code below does not get executed when we redirect. */
exit;

?>