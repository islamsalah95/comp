<?php
define("DB_HOST", "localhost");
define("DB_NAME", "truck");
define("DB_USER", "root");
define("DB_PASSWORD", "");

function sqlPrevious_jobs( $employee_id ,  $company_id ){
    try {
      // Create a new PDO instance
      $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
      
      // Set PDO error mode to exception
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      $sql = "
  SELECT 
      pa.employee_id, 
      pa.project_id, 
      p.project_name, 
      p.rating,
      p.start_date AS project_start_date,
      p.end_date AS project_end_date, 
      t.start_date AS task_start_date,
      t.end_date AS task_end_date, 
      co.start_date AS contract_start_date,
      co.end_date AS contract_end_date,
      co.job_title as titl ,
      co.working_hours as total_working_hours,
      c.company_name, 
      GROUP_CONCAT(DISTINCT t.task_name) AS task_name, 
      SUM(sc.check_out_time) AS working_hours 
  FROM 
      project_assign pa 
  LEFT JOIN 
      projects p ON pa.project_id = p.project_id 
  LEFT JOIN 
      company c ON pa.company_id = c.id 
  LEFT JOIN 
      to_do_list t ON pa.project_id = t.project_id 
  LEFT JOIN 
      shift_check sc ON (pa.project_id = sc.project_id AND pa.employee_id = sc.employee_id AND pa.company_id = sc.company_id AND t.task_id = sc.task_id) 
  LEFT JOIN 
      employee_company_map co ON ( co.id = (SELECT id FROM employee_company_map WHERE employee_id = :employee_id AND 
      company_id = :company_id  AND 
      p.start_date BETWEEN start_date AND end_date))
  WHERE 
      pa.employee_id = :employee_id 
      AND pa.company_id = :company_id 
  GROUP BY 
      pa.employee_id, 
      pa.project_id, 
      p.project_name, 
      p.rating,
      p.start_date,
      p.end_date,
      t.start_date,
      t.end_date,
      co.start_date,
      co.end_date,
      co.job_title,
      co.working_hours,
      c.company_name;
  ";
  
      // Prepare the SQL statement
      $stmt = $db->prepare($sql);
      
      // Bind parameters
      $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
      $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
      
      // Execute the statement
      $stmt->execute();
      
      // Fetch the result as an array
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      // Print the result array
     return  $result   ;
      
  } catch(PDOException $e) {
    return $e->getMessage();
  }

      }
      
function myQuery($query){
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $result = $mysqli->query($query);
    $result = $result->fetch_all(MYSQLI_ASSOC);
    return $result;
  }

function update($sql){
    $mysqli = new mysqli("localhost", "rootflex_flex", "@Islam1995", "rootflex_flex");
    $result = $mysqli->query($sql);
    return $result;
    // if ($mysqli->query($sql) === TRUE) {
    //     echo "Record(s) updated successfully";
    // } else {
    //     echo "Error updating record: " . $mysqli->error;
    // }
    
    
  }

?>