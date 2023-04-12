<?php

    //connect to db
    $conn = mysqli_connect('localhost', 'inumakie', 'Amnes1ac&', 'yue_reviews');

    //check connection
    if(!$conn){
        echo 'Connection error: ' . mysqli_connect_error();
    }

?>