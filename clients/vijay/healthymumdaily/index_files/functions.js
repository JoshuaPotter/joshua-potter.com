// JavaScript Document

function cd (val, format, cdinput) {
	if(!format)
		format = '%m:%s';
	var myInp = 0;
	var cdinparr = new Array(cdinput, 'cd', 'theTime');
	if(document.getElementById) {
		var i=0;
		while(i<cdinparr.length && !(cdinput && (myInp = document.getElementById(cdinput))))
			cdinput = cdinparr[++i];
	}
	if(myInp) {
		var m = Math.floor(val / 60);
		var s = Math.round(val % 60);
		var out = format.replace(/%m/, m).replace(/%s/, s);
		if(myInp.nodeType == 1){
		  if(myInp.tagName.toLowerCase()=="input")
				myInp.value = out;  
		  else
		  {
		  	myInp.innerHTML = out;
		  	myInp.textContent = out;
		  }
		}
		if(val > 0) {
			val = val - 1;
			window.setTimeout("cd(" + val + ", '" + format + "', '" + cdinput + "')", 1000);
		}
	}
}

function runde(x, n) {
  if (n < 1 || n > 14) return false;
  var e = Math.pow(10, n);
  var k = (Math.round(x * e) / e).toString();
  if (k.indexOf('.') == -1) k += '.';
  k += e.toString().substring(1);
  return k.substring(0, k.indexOf('.') + n+1);
}

var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
  if(popUpWin)
  {
    if(!popUpWin.closed) popUpWin.close();
  }
  popUpWin = open(URLStr, 'popUpWin', 'toolbar=yes,location=yes,directories=yes,status=yes,menub ar=yes,scrollbar=yes,resizable=yes,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
  popUpWin.focus();
}

function forceWinSize(f, idName) {
	if(f == 1 && document.getElementById) {
		var main;
		if(idName && idName != '')
			main = document.getElementById(idName);
		else
			main = document.getElementById('overlay_main');
		
		w = parseInt(main.offsetWidth);
		h = parseInt(main.offsetHeight);
		
		self.moveTo((screen.availwidth-w)/2,(screen.availheight-h)/2);
		
		self.resizeTo(w + 50,h + 200);
		
	}
}

//fs = FullSize  ... popUp = open in popup
function prepareLinks(fs,popUp) {
	
	if(fs == 1) {
		if(document.forms['form1']) {
			if(document.getElementById && document.getElementById('submitbt')) {
				if(popUp && popUp == 1) {
					document.forms['form1'].target = "popUpWin";
					document.getElementById('submitbt').onclick = function() {
						popUpWindow('',0,0,screen.width,screen.height);
					}
				}
				else {
					document.getElementById('submitbt').onclick = function() {
						self.moveTo(0,0);
						self.resizeTo(screen.width,screen.height);
					}
				}
			}
		}
		else {
			for(var i = 0; i < document.links.length; ++i) {
				if(popUp && popUp == 1) {
			  	document.links[i].target = "popUpWin";
			  	document.links[i].onclick = function() {
			  		popUpWindow('',0,0,screen.width,screen.height);
			  	}
					
				}
				
				else {
					document.links[i].onclick = function() {
						self.moveTo(0,0);
						self.resizeTo(screen.width,screen.height);
					}
				}
			}
		}
	}
	else if(popUp && popUp == 1) {
		var s = getSize();
		if(document.forms['form1']) {
			if(document.getElementById && document.getElementById('submitbt')) {
				document.forms['form1'].target = "popUpWin";
				document.getElementById('submitbt').onclick = function() {
					popUpWindow('',screen.width-s[0],0,s[0],s[1]);
				}
			}
		}
		else {
			for(var i = 0; i < document.links.length; ++i) {
		  	document.links[i].target = "popUpWin";
		  	document.links[i].onclick = function() {
		  		popUpWindow('',screen.width-s[0],0,s[0],s[1]);
		  	}
		  }
		}
	}
}


function getSize() {
	var myWidth = 0, myHeight = 0;
	
	if( typeof( window.innerWidth ) == 'number' ) {
	//Non-IE
		myWidth = window.innerWidth;
		myHeight = window.innerHeight;
	} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
	//IE 6+ in 'standards compliant mode'
		myWidth = document.documentElement.clientWidth;
		myHeight = document.documentElement.clientHeight;
	} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
	//IE 4 compatible
		myWidth = document.body.clientWidth;
		myHeight = document.body.clientHeight;
	}
	return [ myWidth, myHeight ];
}

function resizeIF(ifram, headPic) {
	var myIframe = document.getElementById(ifram);
	var pic = document.getElementById(headPic);
	if(parent.frames.length && document.documentElement && document.documentElement.scrollHeight) {
		myIframe.style.height = (document.documentElement.scrollHeight - pic.offsetHeight) + 'px';
	}
	else {
		myIframe.style.height = "100%";
	}
	
}

/* redirect function */
var safeuri = null;
function goTo2()
{
	goTo(safeuri);
}

function goTo(uri)
{
	safeuri = uri;
	if(!document.all)
	{
		location.href = uri;
		return;
	}
	if(!document.body)try{document.write('<body><pre></pre></body>')}catch(e){};
	var a = document.createElement('a');
	a.href = uri;
	if(document.body)
	{
		document.body.appendChild(a);
		a.click();
		return;
	}
	else
	{
		window.setTimeout('goTo2()', 12);
	}
}

function setCookie(c_name,value,exdays)
{
  var exdate=new Date();
  exdate.setDate(exdate.getDate() + exdays);
  var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
  document.cookie=c_name + "=" + c_value;
}
  
function getCookie(c_name)
{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
	  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
	  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
	  x=x.replace(/^\s+|\s+$/g,"");
	  if (x==c_name)
    	return unescape(y);
  }
}
var GeneralFunctionsLoaded = true;