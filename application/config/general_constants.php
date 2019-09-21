<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

for ($i = 1; $i <= 30; $i++) {
    $resultRank[$i] = $i;
}

for ($year = 2014; $year <= 2050; $year++) {
    $arr_year[$year] = $year;
}


$config = array(
    'Date_Format_Type' => array(1 => date("Y/m/d"), 2 => date('m/d/Y'), 3 => date('d/m/Y')),
    'time_Format_Type' => array(1 => date("H:s A"), 2 => date('H:s a'), 3 => date('H:s')),
    'Date_Format_Type_JS' => array(1 => "YYYY/MM/DD", 2 => 'MM/DD/YYYY', 3 => 'DD/MM/YYYY'),
    'time_Format_Type_JS' => array(1 => "h:mm A", 2 => 'h:mm a', 3 => 'H:mm'),
    'Rank' => $resultRank,
    'sub_modules' => array('outlet_lang'),
	'Gender' => array(1 => 'Male', 2 => 'Female'),
	'Employment_Contract_Code' => array(1 => 'Employed', 2 => 'Contractor'),
    'Absence' => array(1 => 'Holiday', 2 => 'Sick', 3 => 'Maternity', 4 => 'Paternity'),
    'Appraisal_Grade' => array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F'),
    'province' => array(1 => 'Punjab', 2 => 'Balochistan', 3 => 'Sindh', 4 => 'Kybder Pukhtoon Khuwa'),
    'city' => array(1 => 'Islamabad', 2 => 'Lahore', 3 => 'Karachi', 4 => 'Peshawar' , 5 => 'Rahim yar khan' , 6 => 'Quetta' , 7=> 'Rawalpindi', 8 => 'Bahawalpur', 9=>'Multan', 10 => 'Gujrat'),
    'add_type' => array(1 => 'Offering', 2 => 'Demanding'),
    'field_constant' => array(RADIO_BUTTON => 'Radio Button', CHECK_BOX => 'Check Box', DROPDOWN => 'Dropdown', TEXTBOX => 'Text Box' , NUMBER_BOX => 'Number Box', DATE_BOX => 'Date Box', YEAR_BOX => 'Year Box', CURRENCY_BOX => 'Currency Box', MILEAGE_BOX => 'Milleage Box', CC_BOX => 'cc Box'),

);