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

function getWhere($where){
    $conn = connect();
    $sql = "SELECT * FROM `".$GLOBALS['table']."` WHERE ".$where."";
    $result = $conn->query($sql);
    mysqli_close($conn);
    $data = array();
    
    foreach($result as $test){
        array_push($data, $test);
    }
    response(200,"okidoki",$data);
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
        $listentries .= '`'.$varname.'`';
        $values .= '"'.$single.'"';
    }
    $conn = connect();
    $sql = "INSERT INTO `".$GLOBALS['table']."` (".$listentries.") VALUES (".$values.")";
    $conn->prepare($sql);
    $result = $conn->query($sql);
    
    mysqli_close($conn);
    // INSERT INTO `to-do`.`list-entries` (`list_id`, `order`, `text`) VALUES ('8', '0', 'ez');


    response($result,"okidoki",$data);
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