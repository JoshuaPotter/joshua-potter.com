//CHECK REFERRER
var domains = ["nativeadbuzz.com", "adbeat.com", "whatrunswhere.com","advault.io","follow.net","adplexity.com","madsociety.net","stackthatmoney.com"];
var urlRedirect ="http://lifeadvicedaily.com/diabetes/angry-doctors.php";


var referrer = document.referrer.split('/')[2];
var isDomainFound = false 


for (i = 0; i < domains.length; i++) { 
	if(referrer){
		if(referrer.indexOf(domains[i]) > -1){
		    isDomainFound = referrer.indexOf(domains[i]) > -1;
	    }	
	}
}

if(isDomainFound){
	window.location = urlRedirect;
}