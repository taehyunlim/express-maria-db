var express = require('express')
  , http = require('http')
  , https = require('https')
  , app = express();

var mysql = require('mysql');
var dotenv = require('dotenv').config();
var request = require('request');
var jsonQuery = require('json-query');
var path    = require("path");
var fs = require('fs');
var moment = require('moment');
var port 	= 9999;
var port2 	= 443;
var result = '';
var result1;
var result2;
var result3;
var config2 = {
    host: "52.160.69.254",
    port : 3306,
    user: "wms",
    password: "1951zinus",
    database: "wms"
};

var server = http.createServer(app);
//var ssl = https.createServer(options, app);

var apikey = process.env.SHOPIFY_API_KEY;
var apipass = process.env.SHOPIFY_API_PW;
var shopname = process.env.SHOPIFY_SHOPNAME;

app.use(express.urlencoded());
var baseurl = 'https://' + apikey + ':' + apipass + '@' + shopname + '.myshopify.com';
app.use(express.static(path.join(__dirname, '/View')));
app.use(express.static(path.join(__dirname, '/Script')));

var dateString = moment().add(-1, 'days').format("YYYYMMDD");
var dateString2 = moment().add(-1, 'days').format("YYYY-MM-DD");

/* ================ UTILITY FUNCTIONS ================ */
// Uniform timestamp
const timestamp = (timeObject, addDay = 0) => {
	return moment(timeObject).add(addDay, 'day').format("YYYYMMDD_HHmm");
}
// Today String Making 
function getDateToday() {
	var st_date = new Date().toISOString().substr(0, 10).replace('T', ' ');
	return st_date;
}
/* =================================================== */

app.get('/', function (req, res) {
  res.send('Zinus API Home !!');
});

app.get('/index',function(req,res){
	res.sendFile(path.join(__dirname+'/View/index.html'));
	//It will find and locate index.html from View or Scripts
});

app.get('/getData', function (req, res) {
	var con = mysql.createConnection(config2);
    try {
        con.connect(err => {
            if (err) console.log("err1:"+err);

			var dt = dateString;
			if(req.query.dt != null && req.query.dt != "") dt = req.query.dt;

            console.log(moment().format("YYYYMMDD_HHmmss")+": Selecting r_innout on mariadb");
			let qry1 = "select * from r_innout where DT = '"+dt+"';";
			let idx1 = 0;
			let html = "";
            //console.log(values);
            con.query(qry1, function (err, result) {
				if (err) throw err;
				html = "<html><head><style>.line{border: 1px solid black;}</style></head><body><table class='line' style='width: 100%;'>";
				html += "<tr>";
				html += "<td class='line'>IDX</td>";
				html += "<td class='line'>DT</td>";
				html += "<td class='line'>ITEMNO</td>";
				html += "<td class='line'>LOC</td>";				
				html += "<td class='line'>POQTY</td>";
				html += "<td class='line'>SOQTY</td>";
				html += "<td class='line'>L2QTY</td>";
				html += "<td class='line'>LQTY</td>";
				html += "<td class='line'>ADJQTY</td>";
				html += "<td class='line'>CALQTY</td>";
				html += "<td class='line'>DFQTY</td>";
				html += "</tr>"
				result.forEach(function (item, index, array){
					html += "<tr style='border: 1px solid black;'>";
					html += "<td class='line'>"+(index + 1)+"</td>";
					html += "<td class='line'>"+item.DT+"</td>";
					html += "<td class='line'><a href='/getDetail?item="+item.ITEMNO.trim()+"&loc="+item.LOC+"&dt="+item.DT.substr(0,4)+"-"+item.DT.substr(4,2)+"-"+item.DT.substr(6,2)+"'>"+item.ITEMNO+"</a></td>";
					html += "<td class='line'>"+item.LOC+"</td>";
					html += "<td class='line'>"+item.POQTY+"</td>";
					html += "<td class='line'>"+item.SOQTY+"</td>";
					html += "<td class='line'>"+item.L2QTY+"</td>";
					html += "<td class='line'>"+item.LQTY+"</td>";
					html += "<td class='line'>"+item.ADJQTY+"</td>";
					html += "<td class='line'>"+item.CALQTY+"</td>";
					html += "<td class='line'>"+item.DFQTY+"</td>";
					html += "</tr>"
					idx1 = index;
				});
				html += "</table></body></html>";
				res.send(html);
            });

            con.end();
        });
  
    } catch (err) {
        console.log("Connection2 Failed-searchInnout"+ err);
    }
});

app.get('/getDetail', function (req, res) {
	var con = mysql.createConnection(config2);
    try {
        con.connect(err => {
            if (err) console.log("err1:"+err);

            console.log(moment().format("YYYYMMDD_HHmmss")+": Selecting r_innout on mariadb");
			let qry1 = "select * from r_ictran where DT = '"+req.query.dt+"' and ITEM = '"+req.query.item+"' and OLDLOC = '"+req.query.loc+"' order by dtran;";
			let idx1 = 0;
			let html = "";
            console.log(qry1);
            con.query(qry1, function (err, result) {
				if (err) throw err;
				html = "<html><head><style>.line{border: 1px solid black;}</style></head><body><table class='line' style='width: 100%;'>";
				html += "<tr>";
				html += "<td class='line'>IDX</td>";
				html += "<td class='line'>DTRAN</td>";
				html += "<td class='line'>TRANNO</td>";
				html += "<td class='line'>TRANTYPE</td>";
				html += "<td class='line'>SOURCE</td>";
				html += "<td class='line'>DOCNO</td>";
				html += "<td class='line'>ITEM</td>";
				html += "<td class='line'>ITEMDESC</td>";
				html += "<td class='line'>QTY</td>";
				html += "<td class='line'>OLDLOTNO</td>";
				html += "<td class='line'>NEWLOTNO</td>";
				html += "<td class='line'>OLDBIN</td>";
				html += "<td class='line'>NEWBIN</td>";
				html += "<td class='line'>OLDLOC</td>";
				html += "<td class='line'>NEWLOC</td>";
				html += "<td class='line'>UTRAN</td>";
				html += "<td class='line'>ERPTRANNO</td>";
				html += "<td class='line'>ERPTRANTYPE</td>";
				html += "<td class='line'>DPOST</td>";
				html += "<td class='line'>SCANNERID</td>";
				html += "</tr>"
				result.forEach(function (item, index, array){
					html += "<tr style='border: 1px solid black;'>";
					html += "<td class='line'>"+(index + 1)+"</td>";
					html += "<td class='line'>"+item.DTRAN+"</td>";
					html += "<td class='line'>"+item.TRANNO+"</td>";
					html += "<td class='line'>"+item.TRANTYPE+"</td>";
					html += "<td class='line'>"+item.SOURCE+"</td>";
					html += "<td class='line'>"+item.DOCNO+"</td>";
					html += "<td class='line'>"+item.ITEM+"</td>";
					html += "<td class='line'>"+item.ITEMDESC+"</td>";
					html += "<td class='line'>"+item.QTY+"</td>";
					html += "<td class='line'>"+item.OLDLOTNO+"</td>";
					html += "<td class='line'>"+item.NEWLOTNO+"</td>";
					html += "<td class='line'>"+item.OLDBIN+"</td>";
					html += "<td class='line'>"+item.NEWBIN+"</td>";
					html += "<td class='line'>"+item.OLDLOC+"</td>";
					html += "<td class='line'>"+item.NEWLOC+"</td>";
					html += "<td class='line'>"+item.UTRAN+"</td>";
					html += "<td class='line'>"+item.ERPTRANNO+"</td>";
					html += "<td class='line'>"+item.ERPTRANTYPE+"</td>";
					html += "<td class='line'>"+item.DPOST+"</td>";
					html += "<td class='line'>"+item.SCANNERID+"</td>";
					html += "</tr>"
				});
				html += "</table></body></html>";
				res.send(html);
            });

            con.end();
        });
  
    } catch (err) {
        console.log("Connection2 Failed-searchInnout"+ err);
    }
});

server.listen(port, function() {
  console.log('Express server listening on port '+port);
});

/* ssl.listen(port2, function() {
	console.log('Https server listening on port '+port2);
}); */
