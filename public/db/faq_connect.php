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


function SelectFaqList(){
	$dataDB = \dooub\DB\Mongo::getData();
	$query = "";
	if($_REQUEST['srch'] != null && $_REQUEST['srch'] != ""){
		$res = $dataDB->faq->find(['info.name.ko' => ['$regex' => $_REQUEST['srch']]]);
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

function SelectOne(){
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

?>
