<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store_data";

$conn = new mysqli($servername, $username, $password, $dbname );
if(!$conn){
    die("Database unable to conect".$conn->connect_error);
}
else{
    echo "Database connected sucessfully <br/>";
    
}

// to create a new table
$sql = "CREATE TABLE starwar2 (ID int NOT NULL AUTO_INCREMENT, Name text, API text, PRIMARY KEY(ID))";

if($conn->query($sql) ===TRUE){
    echo "New table has been created successfully <br/>";
}else{
    echo "faied to create new table. $conn->connect_error";
}

// initiate cURL
$cURL = curl_init('https://swapi.dev/api/planets/1/');

if(!$cURL){
    die("unable to initialize curl handle");
}

// return curl 
curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);

// execute curl

$result = curl_exec($cURL);

if(curl_errno($cURL)){
    echo(curl_error($cURL));
    die();
};


// close curl
curl_close($cURL);


// convert curl to json format, with  array
$curl_handle = json_decode($result, true);


// output result
echo "<pre>";
print_r($curl_handle);
echo "</pre>";
echo "<br/>";

foreach($curl_handle as $name => $api){
    $query = "INSERT INTO starwar2 (Name, API ) VALUES (\"".$name."\", \"".$api."\")";
    $conn->query($query);
    
    if($conn->errno){
        echo ($conn->error);
        die();
    }
}
?>
   