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

/* Notice */
function SelectNotiList(){
	$dataDB = \dooub\DB\Mongo::getData();
	$query = "";
	if($_REQUEST['srch'] != null && $_REQUEST['srch'] != ""){
		$res = $dataDB->notice->find(['$or' => [['noticeTitle' => ['$regex' => $_REQUEST['srch']]], ['noticeContents' => ['$regex' => $_REQUEST['srch']]]]]);
	} else if($_REQUEST['notitype'] != null && $_REQUEST['notitype'] != "") {
        $res = $dataDB->notice->find(['noticeType' =>  $_REQUEST['notitype']]);
    } else{
		$res = $dataDB->notice->find([]);
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

	//$dataDB->sample->insertOne($lastnow);
	//echo json_encode($rtnarray);
	echo json_encode($rtnarray, JSON_PRETTY_PRINT);
}

function SelectNotiOne(){
	$dataDB = \dooub\DB\Mongo::getData();
	$res = $dataDB->notice->findOne(['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])]);

	echo json_encode($res, JSON_PRETTY_PRINT);
}

function UpdateNotice(){
	$dataDB = \dooub\DB\Mongo::getData();
	 //5963862361c1fc0a054310a2
	$res = $dataDB->notice->updateOne(
		['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])],
		['$set' => ['noticeTitle' => $_REQUEST['noticeTitle'], 'noticeContents' => $_REQUEST['noticeContents'] ]]
	);

	echo "ok";
}

function InsertNotice(){
	$dataDB = \dooub\DB\Mongo::getData();
	$res = $dataDB->notice->insertOne(
		["noticeWriter" => $_REQUEST['noticeWriter'], "noticeTitle" => $_REQUEST['noticeTitle'],
        "noticeContents" => $_REQUEST['noticeContents'], "noticeType" => $_REQUEST['noticeType'],
        "created" => \dooub\Data\SharedValue::getCreatedArray(), "enabled" => true
		]
	);

	echo "ok";
}

function DeleteNotice(){
	$dataDB = \dooub\DB\Mongo::getData();
	$res = $dataDB->notice->deleteOne(['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])]);

	echo "ok";
}

/* FAQ */
function SelectFaqList(){
	$dataDB = \dooub\DB\Mongo::getData();
	$query = "";
	if($_REQUEST['srch'] != null && $_REQUEST['srch'] != ""){
		$res = $dataDB->faq->find(['$or' => [['faqTitle' => ['$regex' => $_REQUEST['srch']]], ['faqContents' => ['$regex' => $_REQUEST['srch']]]]]);
	}else{
		$res = $dataDB->faq->find([]);
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

	//$dataDB->sample->insertOne($lastnow);
	//echo json_encode($rtnarray);
	echo json_encode($rtnarray, JSON_PRETTY_PRINT);
}

function SelectFaqOne(){
	$dataDB = \dooub\DB\Mongo::getData();
	$res = $dataDB->faq->findOne(['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])]);

	echo json_encode($res, JSON_PRETTY_PRINT);
}

function UpdateFaq(){
	$dataDB = \dooub\DB\Mongo::getData();
	 //5963862361c1fc0a054310a2
	$res = $dataDB->faq->updateOne(
		['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])],
		['$set' => ['faqTitle' => $_REQUEST['faqTitle'], 'faqContents' => $_REQUEST['faqContents'] ]]
	);

	echo "ok";
}

function InsertFaq(){
	$dataDB = \dooub\DB\Mongo::getData();
	$res = $dataDB->faq->insertOne(
		["faqWriter" => $_REQUEST['faqWriter'], "faqTitle" => $_REQUEST['faqTitle'],
        "faqContents" => $_REQUEST['faqContents'],
        "created" => \dooub\Data\SharedValue::getCreatedArray(), "enabled" => true
		]
	);

	echo "ok";
}

function DeleteFaq(){
	$dataDB = \dooub\DB\Mongo::getData();
	$res = $dataDB->faq->deleteOne(['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])]);

	echo "ok";

}

/* hotplace */

function SelectHotList(){
	$dataDB = \dooub\DB\Mongo::getData();
	$query = "";
	if($_REQUEST['srch'] != null && $_REQUEST['srch'] != ""){
		$res = $dataDB->hotplace->find(['$or' => [['info.name' => ['$regex' => $_REQUEST['srch']]], ['info.address' => ['$regex' => $_REQUEST['srch']]] ]]);
	}else{
		$res = $dataDB->hotplace->find([]);
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

	//$dataDB->sample->insertOne($lastnow);
	//echo json_encode($rtnarray);
	echo json_encode($rtnarray, JSON_PRETTY_PRINT);
}

function SelectHotOne(){
	$dataDB = \dooub\DB\Mongo::getData();
	$res = $dataDB->hotplace->findOne(['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])]);

	echo json_encode($res, JSON_PRETTY_PRINT);
}

function UpdateHot(){
	$dataDB = \dooub\DB\Mongo::getData();
	$bl_x = (double)$_REQUEST['bl_x']; //BOTTOM-LEFT
	$bl_y = (double)$_REQUEST['bl_y'];
	$tr_x = (double)$_REQUEST['tr_x']; //TOP-RIGHT
	$tr_y = (double)$_REQUEST['tr_y'];
	$geo_x = (double)$_REQUEST['geo_x']; //TOP-RIGHT
	$geo_y = (double)$_REQUEST['geo_y'];
	//$geo_x = $tr_x-(($bl_x - $tr_x) / 2);	// bl, tr 중간값
	//$geo_y = $tr_y+(($bl_y - $tr_y) / 2);
	$res = $dataDB->hotplace->updateOne(
		['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])],
		['$set' => [
            'info.name.ko' => $_REQUEST['hotName'],
            'info.address' => $_REQUEST['hotAddr'],
            "info.location.bl" => [$bl_x, $bl_y],
            "info.location.tr" => [$tr_x, $tr_y],
			"info.location.geo" => [$geo_x, $geo_y],
            'info.thumb' => $_REQUEST['thumb']
        ]]

	);

	echo "ok";
}

function InsertHot(){
	$dataDB = \dooub\DB\Mongo::getData();
	$bl_x = (double)$_REQUEST['bl_x']; //BOTTOM-LEFT
	$bl_y = (double)$_REQUEST['bl_y'];
	$tr_x = (double)$_REQUEST['tr_x']; //TOP-RIGHT
	$tr_y = (double)$_REQUEST['tr_y'];
	$geo_x = (double)$_REQUEST['geo_x']; //TOP-RIGHT
	$geo_y = (double)$_REQUEST['geo_y'];
	//$geo_x = $tr_x-(($bl_x - $tr_x) / 2);	// bl, tr 중간값
	//$geo_y = $tr_y+(($bl_y - $tr_y) / 2);

	$res = $dataDB->hotplace->insertOne(["created" => \dooub\Data\SharedValue::getCreatedArray(), "enabled" => true,
           "info" => [
                "writer" => $_REQUEST['hotWriter']
                , "name" => ['ko' => $_REQUEST['hotName']]
                , "address" => $_REQUEST['hotAddr']
                , "thumb" => $_REQUEST['thumb']
                , "location" => [
                    "bl" => [$bl_x, $bl_y],
                    "tr" => [$tr_x, $tr_y],
					"geo" => [$geo_x, $geo_y]
                ]
				, "count" => 0
            ]
		]
	);

	echo "ok";
}

function DeleteHot(){
	$dataDB = \dooub\DB\Mongo::getData();
	$res = $dataDB->hotplace->deleteOne(['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])]);

	echo "ok";

}

/* appversion */

function SelectAppList(){
	$dataDB = \dooub\DB\Mongo::getData();
	$query = "";
	if($_REQUEST['srch'] != null && $_REQUEST['srch'] != ""){
		$res = $dataDB->appversion->find(['$or' => [['appOS' => ['$regex' => $_REQUEST['srch']]], ['appVer' => ['$regex' => $_REQUEST['srch']]], ['description' => ['$regex' => $_REQUEST['srch']]] ]]);
	}else{
		$res = $dataDB->appversion->find([]);
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

	//$dataDB->sample->insertOne($lastnow);
	//echo json_encode($rtnarray);
	echo json_encode($rtnarray, JSON_PRETTY_PRINT);
}

function SelectAppOne(){
	$dataDB = \dooub\DB\Mongo::getData();
	$res = $dataDB->appversion->findOne(['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])]);

	echo json_encode($res, JSON_PRETTY_PRINT);
}

function UpdateApp(){
	$dataDB = \dooub\DB\Mongo::getData();
	 //5963862361c1fc0a054310a2
	$res = $dataDB->appversion->updateOne(
		['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])],
		['$set' => ['appOS' => $_REQUEST['appOS'], 'appVer' => $_REQUEST['appVer'], 'description' => $_REQUEST['description'] ]]
	);

	echo "ok";
}

function InsertApp(){
	$dataDB = \dooub\DB\Mongo::getData();
	$res = $dataDB->appversion->insertOne(
		["appWriter" => $_REQUEST['appWriter'], "appOS" => $_REQUEST['appOS'], "appVer" => $_REQUEST['appVer'],
        "appReg" => $_REQUEST['appReg'] ,"description" => $_REQUEST['description'],
        "created" => \dooub\Data\SharedValue::getCreatedArray(), "enabled" => true
		]
	);

	echo "ok";
}

function DeleteApp(){
	$dataDB = \dooub\DB\Mongo::getData();
	$res = $dataDB->appversion->deleteOne(['_id' => new MongoDB\BSON\ObjectID($_REQUEST['oid'])]);

	echo "ok";

}

?>
