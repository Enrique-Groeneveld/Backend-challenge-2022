<?
    $GLOBALS['table'] = $table;

function getall(){
    $conn = connect();
    $sql = "SELECT * FROM `".$GLOBALS['table']."`";
    $result = $conn->query($sql);
    mysqli_close($conn);
    $result2 = array();
    foreach($result as $test){
        array_push($result2, $test);
    }
    return $result2;
}
