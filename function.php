<?php
function autoNumber($id, $table){
	global $con;
	
	$query = $con->query("SELECT MAX(RIGHT(".$id.", 4)) as max_id FROM ".$table." ORDER BY ".$id."");
	
	$data = $query->fetch_array();
	$id_max = $data['max_id'];
	if($id_max != NULL){
		$sort_num = (int) substr($id_max, 1, 4);
		$sort_num++;
		$new_code = sprintf("%04s", $sort_num);
	}
	else{
		$new_code = "0001";
	}
	
	return $new_code;
	
}

function autoNumberUserAdmin($id, $table){
	global $con;
	
	$query = $con->query("SELECT MAX(RIGHT(".$id.", 4)) as max_id FROM ".$table." WHERE LEFT(".$id.", 3) LIKE 'KUA' ORDER BY ".$id."");
	
	$data = $query->fetch_array();
	$id_max = $data['max_id'];
	if($id_max != NULL){
		$sort_num = (int) substr($id_max, 1, 4);
		$sort_num++;
		$new_code = sprintf("%04s", $sort_num);
	}
	else{
		$new_code = "0001";
	}
	
	return $new_code;
	
}

function autoNumberUserSiswa($id, $table){
	global $con;
	
	$query = $con->query("SELECT MAX(RIGHT(".$id.", 4)) as max_id FROM ".$table." WHERE LEFT(".$id.", 3) LIKE 'KUS' ORDER BY ".$id."");
	
	$data = $query->fetch_array();
	$id_max = $data['max_id'];
	if($id_max != NULL){
		$sort_num = (int) substr($id_max, 1, 4);
		$sort_num++;
		$new_code = "KUS" . sprintf("%04s", $sort_num);
	}
	else{
		$new_code = "KUS0001";
	}
	
	return $new_code;
	
}


function autoNumberHasil($id, $table){
	global $con;
	$curym = date('Ym');
	
	$query = $con->query("SELECT MAX(RIGHT(".$id.", 4)) as max_id FROM ".$table." ORDER BY ".$id."");
	
	$data = $query->fetch_array();
	$id_max = $data['max_id'];
	if($id_max != NULL){
		$sort_num = (int) substr($id_max, 1, 4);
		$sort_num++;
		$new_code = $curym . sprintf("%04s", $sort_num);
	}
	else{
		$new_code = $curym . "0001";
	}
	
	return $new_code;
	
}

function autoNumberPembayaran($id, $table){
	global $con;
	$my = date('Ym');
	
	$query = $con->query("SELECT MAX(RIGHT(".$id.", 4)) as max_id FROM ".$table." ORDER BY ".$id."");
	
	$data = $query->fetch_array();
	$id_max = $data['max_id'];
	if($id_max != NULL){
		$sort_num = (int) substr($id_max, 1, 4);
		$sort_num++;
		$new_code = "KP" . $my . sprintf("%04s", $sort_num);
	}
	else{
		$new_code = "KP" . $my . "0001";
	}
	
	return $new_code;
	
}

?>