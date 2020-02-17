<?php
/*
*   Plugin Name: Employee Reader
*   Description: plugin to read the MySQL DB employee table row data (4 columns)
*   Version: 1.0 
*   Author: Isaiah Easo
*   File: wp-employee-reader.php
*   Folder to create: employee-reader
*   Short code: [wp-employee-reader-shortcode]
*/
   
  add_shortcode( 'wp-employee-reader-shortcode', 'wp_employee_reader_entry_point' );


function wp_employee_reader_entry_point( $attributes ) {
	
	global $wpdb;
	//
	// PLEASE NOTE
	//    employee, the is the database table name without the prefix
	//    *** YOU MUST add the prefix before the table name***
	//    ***  We will use the $wpdb object prefix value ***
	//   
	
	//Echo out the Database table prefix as retrieved form the $wpdb object
	//
	echo "The PREFIX IS: ";
	$wpdb->prefix . "<br>";
	
	//Use the concatinaiton operator to join the table prefix to the word employee
	// to create the correct db prefix + table name
	//
	$tableName =   $wpdb->prefix . "employee"; 
	
	//Echo out the $tablename varaible, which is the db prefix + table name
	//
	echo "The PREFIX + Table Name is: ";
	echo $tableName . "<br>";
	 
	//Query the vomments table and assign the returned array of table row objects
	// to the $result variable
	//
	$result = $wpdb->get_results( "SELECT * FROM $tableName");

    //Echo out a table header using start string values
    //
	echo "<table border=\"1\">";
	
	echo "<tr>";
	echo "<th>"  . "ID"        . "</th>" 
		. "<th>" . "Name"    . "</th>" 
		. "<th>" . "Age" . "</th>" 
		. "<th>" . "Eye Color"     . "</th>"
		. "<th>" . "Salary"     . "</th>"
		. "<th>" . "Age Data"     . "</th>";
	echo "</tr>";

	//Iterate the array of DB row objects and put them in HTML table cells
	// 
	foreach($result as $row)  {
	 
		echo "<tr>";
		
		$storeSalary = $row->Salary;
		setlocale(LC_MONETARY, 'en_US.UTF-8');
		$displaySalary = money_format('%(#10n', $storeSalary);
		
		//Each table row column data item is accessed using it's column name 
		//
		echo   "<td>" . $row->ID . "</td>"
			. "<td>" . $row->Name . "</td>"
			. "<td>" . $row->Age . "</td>"
			. "<td>" . "<font color=$row->EyeColor>" . $row->EyeColor  . "</font>" . "</td>"
			. "<td>" . $displaySalary  . "</td>";
	
		if(($row->Age) <= 21) {
			echo	"<td>" . "Young" . "</td>";
		}
		elseif((($row->Age) > 21) && (($row->Age) < 45)) {
			echo	"<td>" . "Young Adult" . "</td>";
		}
		elseif((($row->Age) >= 45) && (($row->Age) < 65)) {
			echo	"<td>" . "Adult" . "</td>";
		}
		else {
			echo	"<td>" . "Old Adult" . "</td>";
		}
		echo "</tr>";
	}

	echo "</table>";
}
?>
