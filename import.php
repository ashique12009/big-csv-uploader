<?php

if (!empty($_FILES['file']['name'])) {
    $connect = new PDO("mysql:host=localhost;dbname=big_csv_uploader;", "root", "", array(
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,
    ));

    $total_row = count(file($_FILES['file']['tmp_name']));

    $file_location = str_replace("\\", "/", $_FILES['file']['tmp_name']);

    $query_1 = '
    LOAD DATA LOCAL INFILE "'.$file_location.'" IGNORE 
    INTO TABLE customer_table 
    FIELDS TERMINATED BY "," 
    LINES TERMINATED BY "\r\n" 
    IGNORE 1 LINES 
    (@column1,@column2,@column3,@column4) 
    SET customer_first_name = @column1, customer_last_name = @column2,  customer_email = @column3, customer_gender = @column4
    ';

    $statement = $connect->prepare($query_1);

    $statement->execute();

    $query_2 = "SELECT MAX(customer_id) as customer_id FROM customer_table";

    $statement = $connect->prepare($query_2);

    $statement->execute();

    $result = $statement->fetchAll();

    $customer_id = 0;

    foreach ($result as $row) {
        $customer_id = $row['customer_id'];
    }

    $first_customer_id = $customer_id - $total_row;

    $first_customer_id = $first_customer_id + 1;

    $query_3 = 'SET @customer_id:='.$first_customer_id.'';

    $statement = $connect->prepare($query_3);

    $statement->execute();

    $query_4 = '
    LOAD DATA LOCAL INFILE "'.$file_location.'" IGNORE 
    INTO TABLE order_table 
    FIELDS TERMINATED BY "," 
    LINES TERMINATED BY "\r\n" 
    IGNORE 1 LINES 
    (@column1,@column2,@column3,@column4,@column5,@column6,@column7) 
    SET customer_id = @customer_id:=@customer_id+1, product_name = @column5,  product_price = @column6, order_date = @column7
    ';

    $statement = $connect->prepare($query_4);

    $statement->execute();

    $output = array(
        'success' => 'Total <b>'.$total_row.'</b> Data imported'
    );

    echo json_encode($output);
}

?>