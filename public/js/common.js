var toastCount = 0;
var $toastlast;

/*
** 폼
**
** <input type="text" numberonly="true" />  // 숫자만 입력 가능한 텍스트박스
** <input type="text" datetimeonly="true" /> // 숫자, 콜론(:), 하이픈(-)만 입력 가능한 텍스트박스
*/
$(function()
{
 $(document).on("keyup", "input:text[numberOnly]", function() {$(this).val( $(this).val().replace(/[^0-9:\-.]/gi,"") );});
 $(document).on("keyup", "input:text[datetimeOnly]", function() {$(this).val( $(this).val().replace(/[^0-9:\-]/gi,"") );});
 	$('#datas0').on('click', '.clickable-row', function(event) {
	  $(this).addClass('active').siblings().removeClass('active');
	});
});


function sortResults(obj, prop, asc) {
    var obj1 = obj.sort(function(a, b) {
        if (asc) {
            return (a[prop] > b[prop]) ? 1 : ((a[prop] < b[prop]) ? -1 : 0);
        } else {
            return (b[prop] > a[prop]) ? 1 : ((b[prop] < a[prop]) ? -1 : 0);
        }
    });
    return obj1;
}

function PopToast(tp, msg, title) {
	toastr.options = {
		closeButton: true,
		debug: false,
		positionClass: "toast-bottom-full-width",
		showDuration: "1000",
		hideDuration: "500",
		timeOut: "3000",
		extendedTimeOut: "1000",
		showEasing: "swing",
		hideEasing: "swing",
		showMethod: "slideDown",
		hideMethod: "fadeOut",
		onclick: null
	};

	var toastIndex = toastCount++;

	var $toast = toastr[tp](msg, title); //tp : success, info, warning,error

	$toastlast = $toast;
	 // Wire up an event handler to a button in the toast, if it exists
	if ($toast.find('#okBtn').length) {
		$toast.delegate('#okBtn', 'click', function() {
			alert('you clicked me. i was toast #' + toastIndex + '. goodbye!');
			$toast.remove();
		});
	}
	if ($toast.find('#delBtn').length) {
		$toast.delegate('#delBtn', 'click', function() {
			alert('Surprise! you clicked me. i was toast #' + toastIndex + '. You could perform an action here.');
		});
	}
}

function PopMsg(tp, msg, title) {
	toastr.options = {
		closeButton: true,
		debug: false,
		positionClass: "toast-bottom-full-width",
		timeOut: "0",
		extendedTimeOut: "100",
		showEasing: "swing",
		hideEasing: "swing",
		showMethod: "fadeIn",
		hideMethod: "fadeOut",
		onclick: null
	};

	var toastIndex = toastCount++;

	var $toast = toastr[tp](msg, title); //tp : success, info, warning,error

	$toastlast = $toast;
}


function AlertToast(tp, msg, title) {
	toastr.options = {
		closeButton: false,
		debug: false,
		positionClass: "toast-top-right",
		showDuration: "1000",
		hideDuration: "1000",
		timeOut: "5000",
		extendedTimeOut: "1000",
		showEasing: "swing",
		hideEasing: "swing",
		showMethod: "slideDown",
		hideMethod: "fadeOut",
		onclick: null
	};

	var toastIndex = toastCount++;

	var $toast = toastr[tp](msg, title); //tp : success, info, warning,error

	$toastlast = $toast;
}

function getLastToast() {
	return $toastlast;
}
$('#clearlasttoast').on("click",function() {
	toastr.clear(getLastToast());
});
$('#cleartoasts').on("click",function() {
	toastr.clear();
});


function getDateTime(ts) {
  var d = new Date();
	if (typeof ts != undefined)
	{
		d = new Date(ts);
	}
  var s =
    leadingZeros(d.getFullYear(), 4) + '-' +
    leadingZeros(d.getMonth() + 1, 2) + '-' +
    leadingZeros(d.getDate(), 2) + ' ' +

    leadingZeros(d.getHours(), 2) + ':' +
    leadingZeros(d.getMinutes(), 2) + ':' +
    leadingZeros(d.getSeconds(), 2);

  return s;
}

function leadingZeros(n, digits) {
  var zero = '';
  n = n.toString();

  if (n.length < digits) {
    for (i = 0; i < digits - n.length; i++)
      zero += '0';
  }
  return zero + n;
}

function getData(k) {
	var rtn = "";
	if (k != typeof undefined){
		rtn = k;
	}else{
		rtn = "";
	}

	return rtn;
}

function getDateTime2(ts) {
	var d = new Date(1500947470049);
	var s = d.toLocaleDateString();
  return s;
}