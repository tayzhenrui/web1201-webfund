<?php
$firstname =  $_POST['firstname'];
$lastname = $_POST['lastname'];
$email =  $_POST['email'];
$message =  $_POST['message'];
$country = $_POST['country'];
$address = $_POST['address'];
$postcode =  $_POST['postcode'];
$city = $_POST['city'];


    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "contactdb";


    //create connection for database
    $conn = mysqli_connect ($host, $dbUsername, $dbPassword);

    if (mysqli_connect_error()) {
        die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
        } else {
            
        //create database
        $sql = "CREATE DATABASE contactdb";

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
        $sql = "CREATE TABLE contactus (
            ID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(20) NOT NULL,
            lastname VARCHAR(20) NOT NULL,
            email VARCHAR(40) NOT NULL,
            message VARCHAR(200) NOT NULL,
            country VARCHAR(20) NOT NULL,
            address VARCHAR(400) NOT NULL,
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


if (!empty($firstname) || !empty($lastname) || !empty($email) || !empty($message) || !empty($country) || !empty($address) || !empty($postcode) || !empty($city)) {

        if (mysqli_connect_error()) {
            die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
        } else {

            $SELECT = "SELECT email From contactus Where email = ? Limit 1";
            $INSERT = "INSERT Into contactus (firstname, lastname, email, message, country, address, postcode, city)
            values (?, ?, ?, ?, ?, ?, ?, ?)";

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
                $stmt->bind_param("ssssssis", $firstname, $lastname, $email, $message, $country, $address, $postcode, $city);
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
header("Location: https://tayzhenrui.github.io/web1201-webfund/thankyou_feedbackform.html");
 
/* Make sure that code below does not get executed when we redirect. */
exit;

?>