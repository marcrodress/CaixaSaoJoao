<?php
// Simulating an array of objects retrieval
$array = array(
  array('id' => 1, 'name' => 'John', 'age' => 25),
  array('id' => 2, 'name' => 'Jane', 'age' => 30),
  array('id' => 3, 'name' => 'Bob', 'age' => 35),
);

// Returning the array as a JSON response
header('Content-Type: application/json');
echo json_encode($array);
?>