<?
function getAll(){
    $conn = connect();
    $sql = "SELECT * FROM `".$GLOBALS['table']."`";
    $result = $conn->query($sql);
    mysqli_close($conn);
    $data = array();
    foreach($result as $test){
        array_push($data, $test);
    }
    response(200,"okidoki",$data);
    return $data;
}

function delete($id){
    $message = '';
    $status = '';
    $result = '';
    if(!ctype_digit($id)){
        $status = 500;
        $message = "Not integer nice try!";
    }
    else{
        $conn = connect();
        $sql = "DELETE FROM `".$GLOBALS['table']."` WHERE `id` = ".$id;
        var_dump($sql);
        $status = $conn->query($sql);
        mysqli_close($conn);
        if($status){
            $status = 200;
        }
    }
    response($status, $message ,$result);
}

function getWhere($where){
    $conn = connect();
    $sql = "SELECT * FROM `".$GLOBALS['table']."` WHERE ".$where."";
    $result = $conn->query($sql);
    mysqli_close($conn);
    $data = array();
    
    foreach($result as $test){
        array_push($data, $test);
    }
    // response(200,"okidoki",$data);
    return $data;
}

function insert(){
    $body= file_get_contents("php://input"); 
    $data = json_decode($body, true);
    $listentries = "";
    $values = " ";
    foreach ($data as $varname => $single){
        clean($single);
        $test = $single;
        $listentries .= '`'.$varname.'`,';
        $values .= '"'.$single.'",';
    }
    $listentries = rtrim($listentries, ',');
    $values = rtrim($values, ',');
    $conn = connect();
    $sql = "INSERT INTO `".$GLOBALS['table']."` (".$listentries.") VALUES (".$values.")";
    $conn->prepare($sql);
    $result = $conn->query($sql);
    $result ? 200 : 500;
    mysqli_close($conn);
    // INSERT INTO `to-do`.`list-entries` (`list_id`, `order`, `text`) VALUES ('8', '0', 'ez');


    response($result,"okidoki",$data);
}

function update($id){

//     UPDATE table_name
// SET column1 = value1, column2 = value2, ...
// WHERE condition;
    $body= file_get_contents("php://input"); 
    $data = json_decode($body, true);
    clean($data);

    $values = '';
    foreach ($data as $varname => $single){
        $column = '`'.$varname.'`';
        $value = '"'.$single.'"';
        $total = $column.'='.$value.',';
        $values .= $total;
    }    
    $values = rtrim($values, ',');

    $conn = connect();
    $sql = "UPDATE `".$GLOBALS['table']."` SET $values WHERE `id` = ".$id."";
    echo $sql;
    $result = $conn->query($sql);
    mysqli_close($conn);
    $data = array();
    

    response(200,"okidoki",$data);
    return $data;
}

function loadView($filename, $data = null)
{
	if ($data) {
		foreach($data as $key => $value) {
			$$key = $value;
		}
	} 
	// require( 'view/templates/header.php');
	require( '../views/' . $filename . '.php');
	// require( 'view/templates/footer.php');
}


function response($status,$status_message,$data)
{
    
	header("HTTP/1.1 ".$status);
	
	$response['status']=$status;
	$response['status_message']=$status_message;
	$response['data']=$data;
	
	$json_response = json_encode($response);
	echo $json_response;
}
    
function clean($data) {
    $data = filter_var($data,
    FILTER_SANITIZE_STRING);
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}