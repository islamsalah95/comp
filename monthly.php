<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
define("DB_HOST", "localhost");
define("DB_NAME", "rootflex_flex");
define("DB_USER", "rootflex_flex");
define("DB_PASSWORD", "@Islam1995");
define('SITE_URL', dirname(__FILE__));


function myQuery($query){
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $result = $mysqli->query($query);
    $result = $result->fetch_all(MYSQLI_ASSOC);
    return $result;
  }




function sendEmail($body,$to,$title)  {
    $data= array(
        "api_key" => "api-D372B4C2187845EF8C5531DCEA15A316",
        "to" => [$to],
        "sender"=> "Techsup Flex <noreply@techsupflex.com>",
        "subject" => $title,
        "html_body" => $body,
        "custom_headers" => array(
            array(
                "header" => "Reply-To",
                "value" => "noreply@techsupflex.com"
            )
        ),
        // "attachments" => array(
        //     array(
        //         "filename" => "test.pdf",
        //         "fileblob" => "--base64-data--",
        //         "mimetype" => "application/pdf"
        //     ),
        //     array(
        //         "filename" => "test.txt",
        //         "fileblob" => "--base64-data--",
        //         "mimetype" => "text/plain"
        //     )
        // )
    );
    $api_url = 'https://api.smtp2go.com/v3/email/send';
    $ch = curl_init($api_url); 
    $headers = array(
        'Content-Type: application/json',
        'X-API-Key: ' . $data['api_key'] // Include API key in headers
    );
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpcode == 200) {
        $result = json_decode($response, true);
        return $result;
    } else {
        return array(
            'error' => 'An error occurred while sending the email.',
            'error_code' => 'HTTP ' . $httpcode
        );
    }
}
// //////////////////////////////////

function getMax($array = array()){
  $max = 0;
  foreach ($array as $k => $v) {
    $max = max(array($max, $v['working_hours']));
  }
  return $max;
} 

function sec2hms_new($seconds){
    if (!is_numeric($seconds)) {
        return '00:00:00'; // or handle the non-numeric case as needed
    }

    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;

    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}

function get_bar($w_h = 0, $ewh = 0, $r_t = '', $max_wh = 1){
  $w_hours = ($w_h > 0) ? $w_h : 0;
  $e_wh = ($ewh > 0) ? $ewh : 0;
  if ($e_wh > 0) {
    $w_hours -= $e_wh;
  }

  $r_type = ($r_t != '') ? $r_t : 'daily';
  $total_hours = ($max_wh > 0 && ($max_wh / 3600) > 8) ? ($max_wh / 3600) : 8;
  $work_hour = 0;
  $bwh = (($w_hours / 3600) * 100 / $total_hours);
  $bewh = (($e_wh / 3600) * 100 / $total_hours);
  $bar_html = '<div class="bar_container"><div class="wh_container" style="width:' . $bwh . '%;background:blue"></div><div class="e_wh_container" style="width:' . $bewh . '%;background:yellow"></div></div>';
  return $bar_html;
}


function message_print($data,$report_title, $r_t = '') {
  $msg2 = '
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Styled Table Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      /* Define CSS styles inline */
      body {
        font-family: Arial, sans-serif; /* Set font family */
        background-color: #f2f2f2; /* Set background color */
        margin: 0; /* Remove default margin */
        padding: 20px; /* Add padding */
      }
      .container {
        max-width: 600px; /* Set maximum width */
        margin: auto; /* Center container */
        background-color: #fff; /* Set container background color */
        padding: 20px; /* Add padding */
        border-radius: 10px; /* Add border radius */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add box shadow */
      }
      table {
        border-collapse: collapse; /* Collapse table borders */
        width: 100%;
        border: 1px solid #ccc; /* Apply border to the table */
        background-color: #fff; /* Set table background color */
      }
      th, td {
        border: 1px solid #ccc; /* Apply border to table cells */
        padding: 12px; /* Add padding to cells */
        text-align: left; /* Align text left in cells */
      }
      th {
        background-color: #f2f2f2; /* Set header background color */
        font-weight: bold; /* Set header font weight */
      }
      tbody tr:nth-child(even) {
        background-color: #f9f9f9; /* Set alternate row background color */
      }
      .logo {
        width: 100px; /* Set the width of the logo */
        height: auto; /* Maintain aspect ratio */
      }
    </style>
  </head>
  <body>
  <div class="container">
    <h2 style="text-align: center;"> '.$report_title.'</h2>
    <table>
      <thead>
        <tr>
            <th colspan="2"><img src="https://89.144.100.176/uploads/logo/company_logo/1605680340.png" alt="Logo" class="logo"></th>
        </tr>
        <tr>
          <th>' . 'Employee Name' . '</th>
          <th>' .'Working Hours' . ' </th>
        </tr>
      </thead>
      <tbody>';
  

    $msg = ''; // Initialize $msg to avoid undefined variable error
    if (is_array($data['report_details'])) {
        usort($data['report_details'], function ($item1, $item2) {
            if ($item1['working_hours'] == $item2['working_hours']) return 0;
            return $item1['working_hours'] > $item2['working_hours'] ? -1 : 1;
        });
        $max_wh = getMax($data['report_details']);
        foreach ($data['report_details'] as $task) {
            $custom_style = '';
            if (in_array($task['employee_id'], $data['inactive_emp'])) {
                $custom_style = 'style = "color:red !important;"';
            }
            $msg .= '
                    <tr ' . $custom_style . '>
                        <td>' . $task['emp_name'] . '</td>
                        <td class="text-right">' . sec2hms_new($task['working_hours']) . '</td>
                    </tr>
            ';
        }
    }

    $msg .= '</tbody>
        </table>
    </div>
</body>
</html>';

    return $msg2 . $msg;
}

// $db->order_by = "`id` DESC";
$r_t = '';
$is_rt = '';

function test($company_id,$time){
  if (isset($time) && $time != "none" && $time=='daily') {
    $start_date = date('Y-m-d');
    $end_date = date('Y-m-d');
    $r_t = 'daily';
    $is_rt = 'daily';
} elseif (isset($time) && $time != "none" && $time=='weekly') {
    $end_date = date('Y-m-d');
    $start_date = date('Y-m-d', strtotime("-6 days"));
    $r_t = 'weekly';
    $is_rt = 'weekly';
} elseif (isset($time) && $time != "none" && $time=='monthly') {
    $end_date = date('Y-m-d');
    $start_date = date('Y-m-d', strtotime("-1 months"));
    $r_t = 'monthly';
    $is_rt = 'monthly';
} else {
    $start_date = date('Y-m-d');
    $end_date = date('Y-m-d');
    $r_t = 'daily';
    $is_rt = 'daily';
}
  $date_format = "DD-MM-YYYY";
    $user_companies = array($company_id);
    $companies = myQuery("SELECT emp.company_id, c.company_name FROM employee_company_map emp LEFT JOIN company c on c.id = emp.company_id WHERE employee_id  IN (SELECT e.employee_id FROM employee e LEFT JOIN employee_company_map m on m.employee_id = e.employee_id WHERE m.company_id = " .$company_id. " and e.department = 3)");
    if (!empty($companies)) {
        foreach ($companies as $c) {
            $user_companies[] = $c['company_id'];
        }
    }
    $report_details = myQuery("SELECT e.employee_id, e.emp_name,
    SUM(case
        when sc.manual_edit = 1
        then sc.check_out_time else 0
        end)
    as ewh,
    SUM(sc.check_out_time) as working_hours  
    from `employee` e left join `shift_check` sc on sc.employee_id = e.employee_id and sc.current_dt BETWEEN '" . $start_date . "' AND '" . $end_date . "' 
    where (e.company_id = '" . $company_id . "' and e.department = 2) 
    or (e.company_id in (" . implode(',', $user_companies) . ") and e.department = 3) 
    GROUP by e.employee_id
    ORDER BY e.`emp_name` ASC");

    $iasql = "SELECT e.employee_id FROM `employee` e LEFT JOIN shift_check sc on sc.employee_id = e.employee_id WHERE e.company_id = " . $company_id . " and e.department = 2 and sc.employee_id is null group by e.employee_id";
    $inactive_employees =  myQuery($iasql);
    
    $inactive_emp = array();
    if (count($inactive_employees) > 0) {
        foreach ($inactive_employees as $inactive_employee) {
            $inactive_emp[] = $inactive_employee['employee_id'];
        }
    }

    return [
      'inactive_emp' => $inactive_emp,
      'report_details' => $report_details,
    ];

  }

// all companies
$companies = myQuery("
SELECT id, company_name, daily_report, weekly_report, monthly_report
FROM company
WHERE is_valid = 1");

foreach ($companies  as $company) {
  // echo "<div>" .$company['company_name']. "</div>";

  $managers = myQuery("SELECT employee_id, company_id, emp_name, department, email FROM `employee` WHERE `department` IN ('1') AND `company_id` = " . $company['id']);




  if($company['monthly_report']== 1){
    // echo "<div>" . "monthly_report" . $company['monthly_report']. "</div>";

    $data=test($company['id'],'monthly');

    $msg=message_print($data,"Monthl Report",$r_t = '');
  
    foreach ($managers as $manager) {
      // echo "<div>" .$manager['email']. "</div>";
          sendEmail($msg,$manager['email'],"Monthly Report");
      
      echo $msg ;

    }
    
  }
}


?>