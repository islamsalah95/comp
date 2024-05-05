<?php



function sendEmailWithCurl($body,$to,$title) {
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://mail-sender-api1.p.rapidapi.com/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'sendto' => $to,
            'name' => 'name',
            'replyTo' => 'Noreplay@gmail.com',
            'ishtml' => 'true',
            'title' => $title,
            'body' => $body
        ]),
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: mail-sender-api1.p.rapidapi.com",
            "X-RapidAPI-Key: 2135a8002fmsh8b8a665f7121ea8p1f7fecjsne548afc779cb",
            "content-type: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
}

// sendEmailWithCurl("hello",'islamm1995@gmail.com',"Daily Report" );


// require SERVER_ROOT . '/webservice/mail/sendEmail.php';

// function getMax($array = array()){
//   $max = 0;
//   foreach ($array as $k => $v) {
//     $max = max(array($max, $v['working_hours']));
//   }
//   return $max;
// } 

// function sec2hms_new($seconds){
//     if (!is_numeric($seconds)) {
//         return '00:00:00'; // or handle the non-numeric case as needed
//     }

//     $hours = floor($seconds / 3600);
//     $minutes = floor(($seconds % 3600) / 60);
//     $seconds = $seconds % 60;

//     return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
// }

// function get_bar($w_h = 0, $ewh = 0, $r_t = '', $max_wh = 1){
//   $w_hours = ($w_h > 0) ? $w_h : 0;
//   $e_wh = ($ewh > 0) ? $ewh : 0;
//   if ($e_wh > 0) {
//     $w_hours -= $e_wh;
//   }

//   $r_type = ($r_t != '') ? $r_t : 'daily';
//   $total_hours = ($max_wh > 0 && ($max_wh / 3600) > 8) ? ($max_wh / 3600) : 8;
//   $work_hour = 0;
//   $bwh = (($w_hours / 3600) * 100 / $total_hours);
//   $bewh = (($e_wh / 3600) * 100 / $total_hours);
//   $bar_html = '<div class="bar_container"><div class="wh_container" style="width:' . $bwh . '%;background:blue"></div><div class="e_wh_container" style="width:' . $bewh . '%;background:yellow"></div></div>';
//   return $bar_html;
// }


// // function message_print($data, $lang, $r_t = '') {
// //   $msg = '<style type="text/css">
// //   .bar_container {
// //     height: 20px;
// //     margin: 0px 5px;
// //     border: 1px solid #c5c5c5;
// //     border-radius: 5px;
// //   }

// //   .wh_container {
// //     height: 18px;
// //     float: left;
// //     background: green;
// //     border-radius: 5px;
// //   }

// //   .c_wh_container {
// //     height: 18px;
// //     float: left;
// //     background: green;
// //     border-radius: 5px;
// //   }

// //   .e_wh_container {
// //     height: 18px;
// //     float: left;
// //     background: blue;
// //     border-radius: 5px;
// //   }

// //   .color_box {
// //     height: 15px;
// //     width: 15px;
// //     border: 1px solid;
// //     float: left;
// //     padding: 2px;
// //     margin: 2px;
// //   }

// //   .c_box {
// //     background: green;
// //   }

// //   .m_box {
// //     background: blue;
// //   }

// //   .e_box {
// //     background: yellow;
// //   }
  
// //   table {
// //     width: 100%;
// //     border-collapse: collapse;
// //     margin-top: 20px;
// //     border: 2px solid #ccc;
// //   }

// //   th, td {
// //     padding: 10px;
// //     border: 1px solid #ddd;
// //     text-align: center;
// //   }

// //   th {
// //     background-color: #f2f2f2;
// //   }
// // </style>
// // <div id="content-container">
// //     <div class="panel">
// //       <div class="panel-body">
// //         <table id="company_report" class="table table-striped table-bordered text-right">
// //           <thead>
// //             <tr>
// //               <th class="text-right">' . $lang['employee_name'] . '</th>
// //               <th class="min-tablet text-right">' . $lang['total_working_time'] . ' (HH:MM:SS)</th>
// //               <th style="min-width: 250px;">
// //                 <div>
// //                   <div class="color_box m_box"></div>
// //                   <div>' . $lang['mobile_work_time'] . '</div>
// //                   <div class="clearfix"></div>
// //                   <div class="color_box e_box"></div>
// //                   <div>' . $lang['manual_work_time'] . '</div>
// //                 </div>
// //               </th>
// //             </tr>
// //           </thead>
// //           <tbody>';
// // if (is_array($data['report_details'])) {
// //     usort($data['report_details'], function ($item1, $item2) {
// //         if ($item1['working_hours'] == $item2['working_hours']) return 0;
// //         return $item1['working_hours'] > $item2['working_hours'] ? -1 : 1;
// //     });
// //     $max_wh = getMax($data['report_details']);
// //     foreach ($data['report_details'] as $task) {
// //         $custom_style = '';
// //         if (in_array($task['employee_id'], $data['inactive_emp'])) {
// //             $custom_style = 'style = "color:red !important;"';
// //         }
// //         $msg .= '<tr ' . $custom_style . '>
// //                   <td>' . $task['emp_name'] . '</td>
// //                   <td class="text-right">' . sec2hms_new($task['working_hours']) . '</td>
// //                   <td>' . get_bar($task['working_hours'], $task['ewh'], $r_t, $max_wh) . '</td>
// //                 </tr>';
// //     }
// // }
// // $msg .= '</tbody>
// //         </table>
// //       </div>
// //     </div>
// //     </div>
// //     </div>';
// //     return $msg;
// // }

// function message_print($data, $lang,$report_title, $r_t = '') {
//   $msg2 = '
//   <!DOCTYPE html>
//   <html lang="en">
//   <head>
//     <title>Styled Table Example</title>
//     <meta charset="utf-8">
//     <meta name="viewport" content="width=device-width, initial-scale=1">
//     <style>
//       /* Define CSS styles inline */
//       body {
//         font-family: Arial, sans-serif; /* Set font family */
//         background-color: #f2f2f2; /* Set background color */
//         margin: 0; /* Remove default margin */
//         padding: 20px; /* Add padding */
//       }
//       .container {
//         max-width: 600px; /* Set maximum width */
//         margin: auto; /* Center container */
//         background-color: #fff; /* Set container background color */
//         padding: 20px; /* Add padding */
//         border-radius: 10px; /* Add border radius */
//         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add box shadow */
//       }
//       table {
//         border-collapse: collapse; /* Collapse table borders */
//         width: 100%;
//         border: 1px solid #ccc; /* Apply border to the table */
//         background-color: #fff; /* Set table background color */
//       }
//       th, td {
//         border: 1px solid #ccc; /* Apply border to table cells */
//         padding: 12px; /* Add padding to cells */
//         text-align: left; /* Align text left in cells */
//       }
//       th {
//         background-color: #f2f2f2; /* Set header background color */
//         font-weight: bold; /* Set header font weight */
//       }
//       tbody tr:nth-child(even) {
//         background-color: #f9f9f9; /* Set alternate row background color */
//       }
//       .logo {
//         width: 100px; /* Set the width of the logo */
//         height: auto; /* Maintain aspect ratio */
//       }
//     </style>
//   </head>
//   <body>
//   <div class="container">
//     <h2 style="text-align: center;"> '.$report_title.'</h2>
//     <table>
//       <thead>
//         <tr>
//           <th colspan="2"><img src="' . SITE_URL . '/uploads/logo/techsupflex.png" alt="Logo" class="logo"></th>
//         </tr>
//         <tr>
//           <th>' . $lang['employee_name'] . '</th>
//           <th>' . $lang['total_working_time'] . ' (HH:MM:SS)</th>
//         </tr>
//       </thead>
//       <tbody>';
  

//     $msg = ''; // Initialize $msg to avoid undefined variable error
//     if (is_array($data['report_details'])) {
//         usort($data['report_details'], function ($item1, $item2) {
//             if ($item1['working_hours'] == $item2['working_hours']) return 0;
//             return $item1['working_hours'] > $item2['working_hours'] ? -1 : 1;
//         });
//         $max_wh = getMax($data['report_details']);
//         foreach ($data['report_details'] as $task) {
//             $custom_style = '';
//             if (in_array($task['employee_id'], $data['inactive_emp'])) {
//                 $custom_style = 'style = "color:red !important;"';
//             }
//             $msg .= '
//                     <tr ' . $custom_style . '>
//                         <td>' . $task['emp_name'] . '</td>
//                         <td class="text-right">' . sec2hms_new($task['working_hours']) . '</td>
//                     </tr>
//             ';
//         }
//     }

//     $msg .= '</tbody>
//         </table>
//     </div>
// </body>
// </html>';

//     return $msg2 . $msg;
// }



// $db->order_by = "`id` DESC";
// $r_t = '';
// $is_rt = '';




// function test($company_id,$time){
//   if (isset($time) && $time != "none" && $time=='daily') {
//     $start_date = date('Y-m-d');
//     $end_date = date('Y-m-d');
//     $r_t = 'daily';
//     $is_rt = 'daily';
// } elseif (isset($time) && $time != "none" && $time=='weekly') {
//     $end_date = date('Y-m-d');
//     $start_date = date('Y-m-d', strtotime("-6 days"));
//     $r_t = 'weekly';
//     $is_rt = 'weekly';
// } elseif (isset($time) && $time != "none" && $time=='monthly') {
//     $end_date = date('Y-m-d');
//     $start_date = date('Y-m-d', strtotime("-1 months"));
//     $r_t = 'monthly';
//     $is_rt = 'monthly';
// } else {
//     $start_date = date('Y-m-d');
//     $end_date = date('Y-m-d');
//     $r_t = 'daily';
//     $is_rt = 'daily';
// }
//   $date_format = "DD-MM-YYYY";
//     $user_companies = array($company_id);
//     $companies = $db->myQuery("SELECT emp.company_id, c.company_name FROM employee_company_map emp LEFT JOIN company c on c.id = emp.company_id WHERE employee_id  IN (SELECT e.employee_id FROM employee e LEFT JOIN employee_company_map m on m.employee_id = e.employee_id WHERE m.company_id = " .$company_id. " and e.department = 3)");
//     if (!empty($companies)) {
//         foreach ($companies as $c) {
//             $user_companies[] = $c['company_id'];
//         }
//     }
//     $report_details = $db->myQuery("SELECT e.employee_id, e.emp_name,
//     SUM(case
//         when sc.manual_edit = 1
//         then sc.check_out_time else 0
//         end)
//     as ewh,
//     SUM(sc.check_out_time) as working_hours  
//     from `employee` e left join `shift_check` sc on sc.employee_id = e.employee_id and sc.current_dt BETWEEN '" . $start_date . "' AND '" . $end_date . "' 
//     where (e.company_id = '" . $company_id . "' and e.department = 2) 
//     or (e.company_id in (" . implode(',', $user_companies) . ") and e.department = 3) 
//     GROUP by e.employee_id
//     ORDER BY e.`emp_name` ASC");

//     $iasql = "SELECT e.employee_id FROM `employee` e LEFT JOIN shift_check sc on sc.employee_id = e.employee_id WHERE e.company_id = " . $company_id . " and e.department = 2 and sc.employee_id is null group by e.employee_id";
//     $inactive_employees =  myQuery($iasql);
    
//     $inactive_emp = array();
//     if (count($inactive_employees) > 0) {
//         foreach ($inactive_employees as $inactive_employee) {
//             $inactive_emp[] = $inactive_employee['employee_id'];
//         }
//     }

//     return [
//       'inactive_emp' => $inactive_emp,
//       'report_details' => $report_details,
//     ];

//   }



// // all companies
// $companies = $db->myQuery("
// SELECT id, company_name, daily_report, weekly_report, monthly_report
// FROM company
// WHERE is_valid = 1");


// foreach ($companies  as $company) {
//   // echo "<div>" .$company['company_name']. "</div>";

//   $managers = $db->run("SELECT employee_id, company_id, emp_name, department, email FROM `employee` WHERE `department` IN ('1') AND `company_id` = :company_id", ['company_id' =>$company['id'] ])->fetchAll();

//   if($company['daily_report']== 1){
//     // echo "<div>" . "daily_report" . $company['daily_report']. "</div>";

//     $data=test($company['id'],'daily');

//     $msg=message_print($data, $lang,"Daily Report",$r_t = '');
  
//     foreach ($managers as $manager) {
//       // echo "<div>" .$manager['email']. "</div>";

//       if (file_exists(SERVER_ROOT . '/webservice/mail/sendEmail.php') ) {
//           sendEmail($msg,$manager['email'],"Daily Report",'Chick Your Email Please' );
//       }
//       // echo $msg ;

//     }
    
//   }

//   if($company['weekly_report']== 1){
//     // echo "<div>" . "weekly_report" . $company['weekly_report']. "</div>";

//     $data=test($company['id'],'weekly');

//     $msg=message_print($data, $lang,"Weekly Report",$r_t = '');
  

//     foreach ($managers as $manager) {
//       // echo "<div>" .$manager['email']. "</div>";

//       if (file_exists(SERVER_ROOT . '/webservice/mail/sendEmail.php') ) {
//           sendEmail($msg,$manager['email'],"Daily Report",'Chick Your Email Please' );
//       }
//       // echo $msg ;

//     }
    
//   }

//   if($company['monthly_report']== 1){
//     // echo "<div>" . "monthly_report" . $company['monthly_report']. "</div>";

//     $data=test($company['id'],'monthly');

//     $msg=message_print($data, $lang,"Monthl Report",$r_t = '');
  
//     foreach ($managers as $manager) {
//       // echo "<div>" .$manager['email']. "</div>";
//       if (file_exists(SERVER_ROOT . '/webservice/mail/sendEmail.php') ) {
//           sendEmail($msg,$manager['email'],"Daily Report",'Chick Your Email Please' );
//       }
//       // echo $msg ;

//     }
    
//   }
// }


?>