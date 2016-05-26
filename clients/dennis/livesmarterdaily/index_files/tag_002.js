





var myRand=parseInt(Math.random()*99999999);

var pUrl = "http://swtl.sitescoutadserver.com/disp?pid=3898EC50D5&rw=1&rand=" + myRand;

var strCreative=''
 + '<IFRAME SRC="'
 + pUrl
 + '" WIDTH="305" HEIGHT="700" MARGINWIDTH=0 MARGINHEIGHT=0 HSPACE=0 VSPACE=0 FRAMEBORDER=0 SCROLLING=no BORDERCOLOR="#000000">\n'
 + '</IFRAME>\n'
 + '\n'
;
document.write(strCreative);