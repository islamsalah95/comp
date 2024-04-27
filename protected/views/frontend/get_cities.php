<?php
// Include database connection or any necessary configuration files

// Retrieve the country ID from the Ajax request
$countryId = isset($_POST['country_id']) ? $_POST['country_id'] : 1 ;

// Query to fetch cities based on the selected country
$cities = myQuery("SELECT id, name FROM cities WHERE country_id = $countryId");

// Render options for cities dropdown
$options = '<option value=""></option>';
foreach ($cities as $city) {
    $options .= '<option value="' . $city['id'] . '">' . $city['name'] . '</option>';
}

echo $options;
?>

