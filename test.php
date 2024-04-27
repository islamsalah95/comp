<?php

define("DB_HOST", "localhost");
define("DB_NAME", "truck");
define("DB_USER", "root");
define("DB_PASSWORD", "");

    // Create a new PDO instance
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    
    // Set PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $sql = "SELECT * FROM `employee`";
    $user_id = 464;
    $sql = "
        SELECT company.* 
        FROM company
        INNER JOIN employee_company ON employee_company.company_id = company.id 
        INNER JOIN employee ON employee.employee_id = employee_company.employee_id  
        WHERE employee.employee_id =$user_id;
    ";
    // Prepare the SQL statement
    $stmt = $db->prepare($sql);
    // Execute the statement
    $stmt->execute();
    // Fetch the result as an array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Print the result array
             print_r( $results);
  
//     try {

//         foreach($results as $result){

//             // $sql2 = "UPDATE employee 
//             // SET company_id = 55 
//             // WHERE company_id NOT IN (1, 3, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62);";
//             $sql2 = "INSERT INTO employee_company (employee_id, company_id) VALUES (:employee_id, :company_id)";
//             $stmt = $db->prepare($sql2);
//             $employee_id = $result['employee_id']; // Replace with the actual employee ID
//             $company_id = $result['company_id']; // Replace with the actual company ID
//             $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
//             $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
//             $stmt->execute();
//              print_r([
//             'employee_id' => $result['employee_id'], 
//             'company_id' => $result['company_id'] ,
//             'message' =>"Record inserted successfully.",
//             ]);
//         }
            
// } catch(PDOException $e) {
//     echo "Error: " . $e->getMessage();
// }



?>
