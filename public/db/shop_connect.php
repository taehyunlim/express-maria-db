<?php
require_once(__DIR__.'/../../../../incl.inc.php');
$var = null;

if($_REQUEST['test'] == "1"){
	echo "<pre>";
}
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
    $getData = $action($var);
}

function SelectConst(){
	$urls = ['reg' => \uploadInfo::URL_SHOP_BUSINESS_REG, 'photo' => \uploadInfo::URL_SHOP_PHOTO, 'thumb' => \uploadInfo::URL_SHOP_THUMBNAIL, 'request' => \uploadInfo::URL_SHOP_REQUEST_THUMB];

	echo json_encode($urls, JSON_PRETTY_PRINT);
}

function SelectList(){
	$dataDB = \dooub\DB\Mongo::getData();
	$query = "";
	if($_REQUEST['srch'] != null && $_REQUEST['srch'] != ""){
		if($_REQUEST['p'] != null && $_REQUEST['p'] != ""){
			$res = $dataDB->shop->find(['show' => true, 'is_paid' => $_REQUEST['p']],['info.name.ko' => ['$regex' => $_REQUEST['srch']]]);
		}else{
			$res = $dataDB->shop->find(['show' => true, 'info.name.ko' => ['$regex' => $_REQUEST['srch']]]);
		}
	}else{
		if($_REQUEST['p'] != null && $_REQUEST['p'] != ""){
			$res = $dataDB->shop->find(['show' => true, 'is_paid' => $_REQUEST['p']=="true"?true:false]);
		}else{
			$res = $dataDB->shop->find(['show' => true]);
		}
	}
	/*	,[
			'limit' => 10,
			'sort' => ['pop' => -1],
		]);
	*/
	$rtnarray = array();
	$lastnow = null;
	foreach($res as $row) {
		$rtnarray[] = $row;
		$lastnow = $row;
	}

	echo json_encode($rtnarray, JSON_PRETTY_PRINT);
}

function SelectReqList(){
	$dataDB = \dooub\DB\Mongo::getData();

	if($_REQUEST['srch'] != null && $_REQUEST['srch'] != ""){
		$res = $dataDB->shop->find(['show' => false, 'info.name.ko' => ['$regex' => $_REQUEST['srch']]]);
	}else{
		$res = $dataDB->shop->find(['show' => false]);
	}

	$rtnarray = array();
	$lastnow = null;
	foreach($res as $row) {
		$rtnarray[] = $row;
		$lastnow = $row;
	}

	echo json_encode($rtnarray, JSON_PRETTY_PRINT);
}

function SelectOne(){
	$dataDB = \dooub\DB\Mongo::getData();

	$res = $dataDB->shop->findOne(['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])]);

	echo json_encode($res, JSON_PRETTY_PRINT);
}

function UpdateOne(){
	$dataDB = \dooub\DB\Mongo::getData();
	if($_REQUEST['enabled'] != null && $_REQUEST['enabled'] != "" && $_REQUEST['is_paid'] != null && $_REQUEST['is_paid'] != ""){
		$res = $dataDB->shop->updateOne(
			['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])],
			['$set' => ['enabled' => $_REQUEST['enabled']=='true'?true:false, 'is_paid' => $_REQUEST['is_paid']=='true'?true:false]],
			['upsert' => true]
		);

		echo "ok";
	}
}

function UpdateReq(){
	$dataDB = \dooub\DB\Mongo::getData();
	if($_REQUEST['is_enabled'] != null && $_REQUEST['is_enabled'] != "") {
		$res = $dataDB->shop->updateOne(
			['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])],
			['$set' => ['show' => $_REQUEST['is_enabled']=='true'?true:false]],
			['upsert' => true]
		);

		echo "ok";
	}
}

function DeleteOne(){
	$dataDB = \dooub\DB\Mongo::getData();
	$res = $dataDB->shop->deleteOne(['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])]);

	echo "ok";
}

function ProperSongList(){
	$dataDB = \dooub\DB\Mongo::getData();

	$res = $dataDB->shopmusic->find(['shop_id' => $_REQUEST['oid']]);

	$rtnarray = array();
	foreach($res as $row) {
		$rtnarray[] = $row;
	}
	echo json_encode($rtnarray, JSON_PRETTY_PRINT);
}

function BestSongList(){
	$dataDB = \dooub\DB\Mongo::getData();

	$col = "STAT-".$_REQUEST['oid'];
	$res = $dataDB->$col->find([],['sort' => ['point' => -1]]);

	$rtnarray = array();
	foreach($res as $row) {
		$rtnarray[] = $row;
	}
	echo json_encode($rtnarray, JSON_PRETTY_PRINT);
}

function TestCC(){
	$dataDB = \dooub\DB\Mongo::getData();

	$choid = "597ee92361c1fc41ea6efa95";

	$res = $dataDB->channel->findOne(['_id' => new MongoDB\BSON\ObjectID($choid)]);

	$res1 = $dataDB->shop->findOne(['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])]);
	$shopname = $res1["info"]["name"]["ko"];
	echo $shopname;

	$dataDB->shopmusic->updateOne(
	['shop_id' => $_REQUEST['oid']],
	['$set' => ['shop_id' => $_REQUEST['oid'], 's_name' => $shopname, 'list_name' => 'LIST1', 'songs' => []]],
	['upsert' => true]);

	$i = 1;
	foreach($res["songs"] as $row) {
		//echo $row["title"].",";
		$dataDB->shopmusic->updateOne(
			['shop_id' => $_REQUEST['oid']],
			['$push' => ['songs' =>
				[
				'idx' => $i,
				'filenm' => $row["filenm"],
				'title' => $row["title"],
				'artist' =>  $row["artist"],
				'genre' =>  $row["genre"],
				'format' =>  $row["format"],
				's_id' => $row["s_id"]
				]
			]],
			['upsert' => true]
		);
		$i++;
	}

	$res = $dataDB->shopmusic->findOne(['shop_id' => $_REQUEST['oid']]);

	/*$rtnarray = array();
	foreach($res["songs"] as $row) {
		$rtnarray[] = $row;
	}*/
	echo "<pre>";
	echo json_encode($res, JSON_PRETTY_PRINT);
}

function DropShop(){
	$dataDB = \dooub\DB\Mongo::getData();
	$dataDB->shop->drop();

	echo "drop ok!";
}


?>
