<?php
require_once('../csv.class.php');
$lines = new CsvReader('../../uploads/two-lines.csv');
echo "<table>\n";
	var_dump($lines);
foreach ($lines as $line_number => $values) {

	echo '<tr>';
	echo '<td>'.$line_number.'</td>';
	foreach ($values as $value) {
		echo '<td>'.$value."</td>";
	}
	echo "</tr>\n";
}
echo '</table>';
