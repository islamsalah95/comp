<?php
$company_id= isset($_SESSION['company_id']) ? $_SESSION['company_id']  : '' ;
$url = $company_id . '___' . str_replace('_', '', SITE_URL) . '/';
$url_encrpt = $security->encrypt($url, key);
echo json_encode($url_encrpt);
