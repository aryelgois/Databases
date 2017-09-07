<?php
/*
 * Let's generate a .sql to populate the Address database with Brazil's states
 * and counties.
 */

use aryelgois\Databases\Address;

require __DIR__ . '/../vendor/autoload.php';


/*
 * Define an array with all included countries
 *
 * The script will look for files named 'source_{country}.json' inside data/Address
 */
$countries = ['brazil'];

// create object
$address = new Address($countries);

// output sql
echo '<pre>' . $address->output() . '</pre>';
