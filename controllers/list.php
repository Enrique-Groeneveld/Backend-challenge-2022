<?
    require_once '../models/lists.php';


function index(){
    $test2 = "thoughts";
    loadView('index');
}

function getEntriesWithLists(){
    $lists =  getAll();
    $data = Array();
    require_once '../models/list-entries.php';  
    foreach ($lists as $list){  
        $list['entries'] = array();
        $where = '`list_id` =' . $list['id'];
        $entries = getWhere($where);
        foreach ($entries as $entrie){
            array_push($list['entries'], $entrie);
        }
        array_push($data, $list);
    }
    ob_end_clean();
    response(200,"okidoki",$data);
}

function deleteList($id){
    $query = ' `id` = '.$id;
    $lists =  getWhere($query);
    
    $data = Array();
    foreach ($lists as $list){  
        var_dump ($list['id']);
        delete($list['id']);

        $list['entries'] = array();
        $where = '`list_id` =' . $id;
        require_once '../models/list-entries.php';  

        $entries = getWhere($where);
        foreach ($entries as $entrie){
            delete($entrie['id']);
            array_push($list['entries'], $entrie);
        }
        array_push($data, $list);
    }

    response(200,"okidoki",$data);



}
  


