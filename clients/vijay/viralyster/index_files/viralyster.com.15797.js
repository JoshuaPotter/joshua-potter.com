/*marketgid.comV3.0*/ if(!this.MarketGidJSON){ MarketGidJSON=function(){function f(n){return n<10?'0'+n:n;} Date.prototype.toJSON=function(){return this.getUTCFullYear()+'-'+ f(this.getUTCMonth()+1)+'-'+ f(this.getUTCDate())+'T'+ f(this.getUTCHours())+':'+ f(this.getUTCMinutes())+':'+ f(this.getUTCSeconds())+'Z';};var m={'\b':'\\b','\t':'\\t','\n':'\\n','\f':'\\f','\r':'\\r','"':'\\"','\\':'\\\\'};function stringify(value,whitelist){var a,i,k,l,r=/["\\\x00-\x1f\x7f-\x9f]/g,v;switch(typeof value){case'string':return r.test(value)?'"'+value.replace(r,function(a){var c=m[a];if(c){return c;} c=a.charCodeAt();return'\\u00'+Math.floor(c/16).toString(16)+ (c%16).toString(16);})+'"':'"'+value+'"';case'number':return isFinite(value)?String(value):'null';case'boolean':case'null':return String(value);case'object':if(!value){return'null';} if(typeof value.toJSON==='function'){return stringify(value.toJSON());} a=[];if(typeof value.length==='number'&&!(value.propertyIsEnumerable('length'))){l=value.length;for(i=0;i<l;i+=1){a.push(stringify(value[i],whitelist)||'null');} return'['+a.join(',')+']';} if(whitelist){l=whitelist.length;for(i=0;i<l;i+=1){k=whitelist[i];if(typeof k==='string'){v=stringify(value[k],whitelist);if(v){a.push(stringify(k)+':'+v);}}}}else{for(k in value){if(typeof k==='string'){v=stringify(value[k],whitelist);if(v){a.push(stringify(k)+':'+v);}}}} return'{'+a.join(',')+'}';}} return{stringify:stringify,parse:function(text,filter){var j;function walk(k,v){var i,n;if(v&&typeof v==='object'){for(i in v){if(Object.prototype.hasOwnProperty.apply(v,[i])){n=walk(i,v[i]);if(n!==undefined){v[i]=n;}}}} return filter(k,v);} if(/^[\],:{}\s]*$/.test(text.replace(/\\./g,'@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,']').replace(/(?:^|:|,)(?:\s*\[)+/g,''))){j=eval('('+text+')');return typeof filter==='function'?walk('',j):j;} throw new SyntaxError('parseJSON');}};}();} MarketGidBaseBlockC15797 = function(root_id, RY, fallback, containerId) { var self = this; this.RY = RY; this.root = this.RY.document.getElementById(root_id); this.containerId = containerId; this.KM = fallback; this.page = 1; this.iteration = 1; this.adlink = ''; this.template = ''; this.id = 15797; this.tickerShow = 0; this.CC = []; this.QD = {}; this.ZW = {}; this.PL = []; this.SP = []; this.LQ = []; this.afterRenderItemHooks = []; this.NW = ""; this.XD = ""; this.MH = 0; this.NS = {}; this.VV = ""; this.GF = ""; this.DK = []; this.crashStep = 0; this.loadedDefault = false; this.teaserHashes = {}; this.teaserData = {}; this.OF = 2; this.ZQ = 0; this.fakeMode = 0; this.requestParams = {}; this.infIds = []; this.NR = []; this.realIds = []; this.protocols = []; this.NR['news5443'] = 'ab'; this.KS = 'ab'; this.DK['news'] = "mgid.com"; this.WZ = '5443'; this.AI = 'news'; this.infIds['news'] = '5443'; this.realIds['news'] = '5443'; this.protocols['news'] = '4'; this.NR['goods3321'] = 'ad'; this.KS['goods'] = 'ad'; this.DK['goods'] = "mgid.com"; this.WZ = '3321'; this.AI = 'goods'; this.infIds['goods'] = '3321'; this.realIds['goods'] = '3321'; this.protocols['goods'] = '4'; this.RJ = {}; this.XK = {}; this.RJ.news = '<div class="mgbox"> '; this.XK.news = ' </div> </div> '; this.RJ.goods = '<div class="mgbox"> '; this.XK.goods = ' </div> </div> '; this.GM = ''; this.AB = function(title,id,f_src,desc,mirror,n) { self.teaserData[n[6]] = n; self.teaserData[n[6]]['img'] = n[7]['i']; if (self.GM=='news') { mirror = mirror ? mirror : self.QPs[self.WG]; var SX = self.QPsImages[self.WG]; this.template+=' '; if ( this.iteration != 1){ this.template+='</div>'; } this.template+='<div class="mgline"> <div class="image-with-text"> <div class="mcimg"> <a target="_blank" href="'+(typeof(this.RY.MGClickTracking) != 'undefined' ? this.RY.MGClickTracking : "")+(this.RY.document.location.protocol.indexOf("http")!=-1?this.RY.document.location.protocol:"http:")+(typeof(n[7]['l']) == 'undefined' ? ('//'+mirror+'/pnews/'+id+'/i/5443/pp/'+this.iteration+'/'+this.page+'/?h=' + encodeURIComponent(this.teaserHashes[id])) : n[7]['l']) +'" ><img class="mcimg" width="200" height="200" src="'+n[7]['i']+'"></a> </div> <div class="text-elements"> <div class="mctitle"><a target="_blank" href="'+(typeof(this.RY.MGClickTracking) != 'undefined' ? this.RY.MGClickTracking : "")+(this.RY.document.location.protocol.indexOf("http")!=-1?this.RY.document.location.protocol:"http:")+(typeof(n[7]['l']) == 'undefined' ? ('//'+mirror+'/pnews/'+id+'/i/5443/pp/'+this.iteration+'/'+this.page+'/?h=' + encodeURIComponent(this.teaserHashes[id])) : n[7]['l']) +'">'+title+'</a></div> </div> </div> '; } else { self.teaserData[n[9]] = n; self.teaserData[n[9]]['img'] = n[10]['i']; n[7] = n[7].replace(".00", ""); n[8] = n[8].replace(".00", ""); mirror = self.QPs[self.WG]; var SX = self.QPsImages[self.WG]; this.template+=' '; if ( this.iteration != 1){ this.template+='</div>'; } this.template+='<div class="mgline"> <div class="image-with-text"> <div class="mcimg"> <a target="_blank" href="'+(typeof(this.RY.MGClickTracking) != 'undefined' ? this.RY.MGClickTracking : "")+(this.RY.document.location.protocol.indexOf("http")!=-1?this.RY.document.location.protocol:"http:")+(typeof(n[10]['l']) == 'undefined' ? ('//'+mirror+'/ghits/'+n[1]+'/i/3321/'+this.WG+'/pp/'+this.iteration+'/'+this.page+'/'+n[6]+'?h=' + encodeURIComponent(this.teaserHashes[n[1]])) : n[10]['l']) +'" ><img class="mcimg" width="200" height="200" src="'+n[10]['i']+'"></a> </div> <div class="text-elements"> <div class="mctitle"><a target="_blank" href="'+(typeof(this.RY.MGClickTracking) != 'undefined' ? this.RY.MGClickTracking : "")+(this.RY.document.location.protocol.indexOf("http")!=-1?this.RY.document.location.protocol:"http:")+(typeof(n[10]['l']) == 'undefined' ? ('//'+mirror+'/ghits/'+n[1]+'/i/3321/'+this.WG+'/pp/'+this.iteration+'/'+this.page+'/'+n[6]+'?h=' + encodeURIComponent(this.teaserHashes[n[1]])) : n[10]['l']) +'">'+((n[5] == '1')?('\u200d' + this.RS(n[3]) + '\u200d'):this.RS(n[3]))+'</a></div> </div> </div> '; } if (self.fakeMode == 0) { for (var i = 0; i < self.afterRenderItemHooks.length; i++) { self[self.afterRenderItemHooks[i]](n); } } self.iteration++; }; this.CM = function(str,limit) { if (str.length<=limit) return str; var word=new Array(); word=str.split(" "); var ret=word[0] + ' '; var test; for (i=1;i<word.length;i++){ test=ret+word[i]; if (test.length>limit) return ret+'...'; else ret+=word[i] + ' '; } return str; }; this.QB = function(str,limit){ var word=new Array(); var i; var ret=''; word=str.split(" "); for (i=0;i<word.length;i++){ if (word[i].length>limit && word[i].search(/&\w+;/)<0) ret+=word[i].substr(0,limit) + ' ' + word[i].substr(limit) + ' '; else ret+=word[i] + ' '; } return ret; }; this.RS = function(title) { if (this.GM=='news') { } else { } return title; }; this.GJ = function(desc) { if (this.GM=='news') { } else { } return desc; }; this.isArray = function(o) { return Object.prototype.toString.call(o) === '[object Array]'; }; this.LD = function() { if (!this.KM && this.RY.document.getElementById("MarketGidPreloadC" + this.containerId)) { this.RY.document.getElementById("MarketGidPreloadC" + this.containerId).style.display = 'none'; } else if (this.KM && this.MH == 0) { this.root.innerHTML = ""; } }; this.MarketGidLoadNews = function(json){ this.LD(); if (self.fakeMode == 0) { for (var i = 0; i < self.PL.length; i++) { self[self.PL[i]](); } } var i; this.template=''; if (this.isArray(json)){ if (json.length==0) { if (!this.forceShow) { this.blockType = this.blockType == 'news' ? 'goods' : 'news'; var type = this.blockType; var id = this.realIds[type]; this.blockId = id; this.subdomain = this.NR[type + id]; this.QD["mg_id"] = id; this.QD["mg_type"] = type; this.setCookie(); this.forceShow = true; this.BQ(this.forceShow); } return; } for(i=0; i<json.length; i++){ var n=json[i]; if (n[5] !=='undefined') srcDom = n[5]; if (this.GM == 'news') { if (n[6] !=='undefined' && n[1] !== 'undefined') { this.teaserHashes[n[1]] = n[6]; } } else { if (n[9] !=='undefined' && n[1] !=='undefined') { this.teaserHashes[n[1]] = n[9]; } } if (this.isArray(n)){ if (!(n[1] in this.NS) && n[1]!='') { this.NS[n[1]]=1; this.AB(this.RS(n[3]),n[1],n[0],this.GJ(n[4]),n[5],n); } else this.NS[n[1]]++; } } if(this.root && this.template){ if (this.KM && this.MH==0) this.root.innerHTML = ""; this.root.innerHTML+= (this.MH==0?this.XD:"") + this.VV + this.RJ[this.GM]+this.template+this.XK[this.GM] + this.GF; } } else { if (this.root && this.MH==0) { this.root.innerHTML=''; return; } } this.QD["page"] = this.page; this.QD['time'] = (new Date()).getTime(); this.setCookie(); var hrefs = this.root.getElementsByTagName("a"); for (var i = 0; i < hrefs.length; i++) { } if (this.GM=='news') { this.MX(' @font-face { font-family: \'PFDinDisplayProRegular\'; src: url(\'//cdn.mgid.com/fonts/pfdindisplaypro-regular-webfont.eot\'); src: url(\'//cdn.mgid.com/fonts/pfdindisplaypro-regular-webfont.eot?#iefix\') format(\'embedded-opentype\'), url(\'//cdn.mgid.com/fonts/pfdindisplaypro-regular-webfont.woff\') format(\'woff\'), url(\'//cdn.mgid.com/fonts/pfdindisplaypro-regular-webfont.ttf\') format(\'truetype\'), url(\'//cdn.mgid.com/fonts/pfdindisplaypro-regular-webfont.svg#PFDinDisplayProRegular\') format(\'svg\'); } .mgbox { padding: 0 !important; position: relative !important; text-align: center; vertical-align: top !important; margin:0 auto; border-style: solid; width: 600px; border-width: 0px; background-color: ; } div.mcimg { padding: 0px; text-align: center; } img.mcimg { border-style: solid; border-width: 0px; width: 200px; height: 200px; } .mctitle a, .mcdesc a { font-weight: bold; font-size: 12px; font-style: normal; text-decoration: none; font-family:\'PFDinDisplayProRegular\',Tahoma,Geneva; } .mgbox .text-elements { text-align: center; } div.mctitle { margin-top: 10px; } .mgline:hover .mctitle a { text-decoration:underline; } .mgline{ background: none repeat scroll 0 0; ; width:100%; cursor: pointer; display: inline-block !important; vertical-align: top; min-width: 200px; margin-bottom: 5px; padding: 0!important; } div.mcprice { text-align: center; } div.mcprice span { font-size: 12px; font-weight: bold; font-style: normal; color: #ff0000; } div.mcprice > span { text-decoration: none; } span.mcpriceold { text-decoration: line-through !important; } '); } else { this.MX(' @font-face { font-family: \'PFDinDisplayProRegular\'; src: url(\'//cdn.mgid.com/fonts/pfdindisplaypro-regular-webfont.eot\'); src: url(\'//cdn.mgid.com/fonts/pfdindisplaypro-regular-webfont.eot?#iefix\') format(\'embedded-opentype\'), url(\'//cdn.mgid.com/fonts/pfdindisplaypro-regular-webfont.woff\') format(\'woff\'), url(\'//cdn.mgid.com/fonts/pfdindisplaypro-regular-webfont.ttf\') format(\'truetype\'), url(\'//cdn.mgid.com/fonts/pfdindisplaypro-regular-webfont.svg#PFDinDisplayProRegular\') format(\'svg\'); } .mgbox { padding: 0 !important; position: relative !important; text-align: center; vertical-align: top !important; margin:0 auto; border-style: solid; width: 600px; border-width: 0px; background-color: ; } div.mcimg { padding: 0px; text-align: center; } img.mcimg { border-style: solid; border-width: 0px; width: 200px; height: 200px; } .mctitle a, .mcdesc a { font-weight: bold; font-size: 12px; font-style: normal; text-decoration: none; font-family:\'PFDinDisplayProRegular\',Tahoma,Geneva; } .mgbox .text-elements { text-align: center; } div.mctitle { margin-top: 10px; } .mgline:hover .mctitle a { text-decoration:underline; } .mgline{ background: none repeat scroll 0 0; ; width:100%; cursor: pointer; display: inline-block !important; vertical-align: top; min-width: 200px; margin-bottom: 5px; padding: 0!important; } div.mcprice { text-align: center; } div.mcprice span { font-size: 12px; font-weight: bold; font-style: normal; color: #ff0000; } div.mcprice > span { text-decoration: none; } span.mcpriceold { text-decoration: line-through !important; } '); } this.MH++; if (self.fakeMode == 0) { for (var i = 0; i < self.SP.length; i++) { self[self.SP[i]](); } } }; this.IN = function() { var d = this.RY.document, w = this.RY, dE = 'documentElement', cH = 'clientHeight', cW = 'clientWidth', iH = 'innerHeight', iW = 'innerWidth', sH = 'scrollHeight', sW = 'scrollWidth', oH = 'offsetHeight', oW = 'offsetWidth', oL = 'offsetLeft', oT = 'offsetTop', sT = 'scrollTop', sL = 'scrollLeft'; if (w[iW]) { return {"c": w[iH], "s": w.pageYOffset}; } else if (d[dE] && d[dE][cW]) { return {"c": d[dE][cH], "s": d[dE][sT]}; } else if (d.body[cW]) { return {"c": d.body[cH], "s": d.body[sT]}; } return 0; }; this.MarketGidRedirectComposite = function() { if (arguments.length == 5) { var arr = arguments[4]; } else { var arr = arguments[0]; } if (self.crashWorkerTimeout) { clearTimeout(self.crashWorkerTimeout); } if (self.ZQ >= self.OF || self.crashStep == 2) { self.GM = self.blockType; self.MarketGidLoadNews(arr); } else { var rType = self.blockType == 'news' ? 'goods' : 'news'; var rId = self.realIds[rType]; if (self.NR[rType + rId]) { if (self.crashStep == 1) self.crashStep++; self.blockId = rId; self.blockType = rType; self.subdomain = self.NR[rType + rId]; self.QD["mg_id"] = rId; self.QD["mg_type"] = rType; self.setCookie(); self.NW = '//'+self.subdomain+'-'+self.blockType.substr(0,1)+'b.'+self.DK[self.blockType]+'/'+self.blockId+'/'; self.BQ(); self.ZQ++; } } }; this.crashWorker = function() { if (MarketGidInfC15797.template == '' && !MarketGidInfC15797.loadedDefault) { MarketGidInfC15797.crashStep = 1; MarketGidInfC15797.MarketGidRedirectComposite([]); } }; this.init = function() { if (this.root) { this.getCookie(); var cookie = this.QD["page"]; this.CC = this.root.getElementsByTagName('a'); var pageOffset = (this.RY.MarketGidPageOffset ? parseInt(this.RY.MarketGidPageOffset) : 0); if(cookie!=null&&parseInt(cookie)<20&&parseInt(cookie)>0) this.page=parseInt(cookie)+1; else if (parseInt(cookie)>19||parseInt(cookie)<1) this.page=1+pageOffset; if ((new Date()).getTime() - (this.QD['time']!=undefined ? this.QD['time'] : 0) >= 6e5) this.page = 1+pageOffset; if (!this.page) this.page = 1+pageOffset; this.pageUnlim = this.page - 1; this.QD["page"] = this.page; this.setCookie(); if (!this.RY.document.cookie) { var dt = new Date(); this.page = dt.getSeconds()%20+1; } this.blockId = this.QD["mg_id"] ? this.QD["mg_id"] : this.WZ; this.blockType = this.QD["mg_type"] ? this.QD["mg_type"] : this.AI; if (this.NR[this.blockType + this.blockId]) this.subdomain = this.NR[this.blockType + this.blockId]; else { this.subdomain = this.KS; this.blockId = this.WZ; this.blockType = this.AI; } this.NW = '//'+this.subdomain+'-'+this.blockType.substr(0,1)+'b.'+this.DK[this.blockType]+'/'+this.blockId+'/'; for (var i=0; i<this.LQ.length; i++) { this[this.LQ[i]](); } } }; this.BQ = function(forceShow, refresh) { var script = this.RY.document.createElement('script'); script.type = 'text/javascript'; script.charset = 'utf-8'; if (forceShow) { this.NW = '//'+this.subdomain+'-'+this.blockType.substr(0,1)+'b.'+this.DK[this.blockType]+'/fs/'+this.blockId+'/'; } script.src = this.NW + this.page; if (refresh) { self.requestParams.rsh = "rsh=1"; } if (this.RY.MGi != undefined) { self.requestParams.geo = "geo=" + this.RY.MGi; } self.requestParams.pv = "pv=" + this.protocols[this.blockType]; self.requestParams.cbuster = "cbuster=" + (this.RY.MG_CacheBuster ? this.RY.MG_CacheBuster : ((new Date().getTime()) + '' + Math.floor((Math.random() * 1000000000) + 1))); if (script.src.indexOf('?') == -1) { script.src += '?'; } else { script.src += '&'; } var params = []; for (var key in self.requestParams) { params.push(self.requestParams[key]); } if (params.length > 0) { script.src += params.join("&"); } (this.realRoot != undefined ? this.realRoot : this.root).parentNode.appendChild(script); }; this.MX = function(style) { var MGst=this.RY.document.createElement('style'); MGst.type = 'text/css'; (this.realRoot != undefined ? this.realRoot : this.root).parentNode.appendChild(MGst); style = style.replace(/((?:^|}|,)\W*)((?:\w+)?\.(?:mc|mg)[\-\w]+)/g, "$1" + this.getMainCssSelector() + " $2"); if (MGst.styleSheet) { MGst.styleSheet.cssText = style; } else {MGst.appendChild(this.RY.document.createTextNode(style))}; (this.realRoot != undefined ? this.realRoot : this.root).parentNode.appendChild(MGst); }; this.start = function() { if (self.root && self.MH == 0) { self.BQ(); } }; this.addEvent = function(elem, type, handler) { if (elem.addEventListener) { elem.addEventListener(type, handler, false) } else { elem.attachEvent('on' + type, handler) } }; this.getMainCssSelector = function() { return "#" + (this.realRoot ? this.realRoot.id : this.root.id); } }; var mgCanLoad15797 = false; var mgFallback15797 = false; if (document.getElementById("MG_ID")) mgCanLoad15797 = true; if (document.getElementById("MarketGidComposite15797")) { mgCanLoad15797 = true; mgFallback15797 = true; } if (mgCanLoad15797) { if (!mgFallback15797) { var rootId15797 = document.getElementById("MG_ID").innerHTML; var div15797 = parent.window.document.createElement('div'); div15797.id = "MarketGidComposite15797"; parent.window.document.getElementById("MarketGidScriptRootC" + rootId15797).appendChild(div15797); MarketGidInfC15797 = new MarketGidBaseBlockC15797("MarketGidComposite15797", parent.window, false, rootId15797); } else { MarketGidInfC15797 = new MarketGidBaseBlockC15797("MarketGidComposite15797", window, true, 0); } MarketGidCCookieBlock15797 = function() { this.storageName = "MarketGidStorage" + (this.RY.MarketGidPageOffset ? this.RY.MarketGidPageOffset : ""); this.RF = function() { var matches = this.RY.document.cookie.match(new RegExp("(?:^|; )" + this.storageName + "=([^;]*)")); var res = {}; if (matches) { try { res = MarketGidJSON.parse(decodeURIComponent(matches[1])); } catch (e) {}; } return res; }; this.getCookie = function() { var value = this.RF(); if (value["C15797"]!=undefined) { this.QD = value["C15797"]; } else this.QD = {}; if (value["0"]!=undefined) { this.ZW = value["0"]; } else this.ZW = {}; }; this.setCookie = function() { var totalCookie = this.RF(); totalCookie["C15797"] = this.QD; totalCookie["0"] = this.ZW; var value = encodeURIComponent(MarketGidJSON.stringify(totalCookie)); this.RY.document.cookie = this.storageName+"="+value+";path=/"; }; }; MarketGidCCookieBlock15797.call(MarketGidInfC15797); MarketGidCSubnetsBlock15797 = function() { var self = this; this.LQ.push("DB"); this.WG = ""; this.QPs = {}; this.QPsImages = {}; this.QPsAdvert = {}; this.QPsAdLinkBlocks = {}; this.QPsUtm = {}; this.QPs['0'] = 'mgid.com'; this.QPsImages['0'] = 'mgid.com'; this.QPsAdvert['0'] = 'http://mgid.com/advertisers/?utm_source=widget&utm_medium=text&utm_campaign=add'; this.QPsAdLinkBlocks['0'] = '<span class="mghead">%WIDGET_TITLE%</span><div class="mg_addad%id"><a href="http://mgid.com/advertisers%utm%id" target="_blank"> by <img src="//mgid.com/images/mgid_logo_mini_43x20.png" alt="Mgid" title="Mgid"></a></div><div class="clear"></div><style type="text/css">div.mg_addad%id{text-align: right; opacity: 0.5;margin-right: 10px} div.mg_addad%id:hover{opacity: 1} div.mg_addad%id a{color: #000000; font:normal 10px Myriad Pro; text-decoration: none;} div.mg_addad%id img{margin-bottom: -5px; border:0px} .mghead{font-weight:700;font-size:14px;text-transform:uppercase;text-align:left;font-family: "Open Sans", sans-serif;color:#4555a7;display:block;margin:0 0 0px 5px;float:left;}</style>'; this.QPsUtm['0'] = '?utm_source=widget&utm_medium=text&utm_campaign=add&utm_content='; this.QPs['1'] = 'fem.mgid.com'; this.QPsImages['1'] = 'mgid.com'; this.QPsAdvert['1'] = ''; this.QPsAdLinkBlocks['1'] = '<div class="mg_addad%id"><a href="http://mgid.com/advertisers%utm%id" target="_blank"> by <img src="//mgid.com/images/mgid_logo_mini_43x20.png" alt="Mgid" title="Mgid"></a></div><style type="text/css">div.mg_addad%id{text-align: right; opacity: 0.5;} div.mg_addad%id:hover{opacity: 1} div.mg_addad%id a{color: #000000; font:normal 10px Myriad Pro; text-decoration: none;} div.mg_addad%id img{margin-bottom: -5px; border:0px}</style>'; this.QPsUtm['1'] = '?utm_source=widget_fem&utm_medium=text&utm_campaign=add&utm_content='; this.QPs['2'] = 'adskeeper.co.uk'; this.QPsImages['2'] = 'adskeeper.co.uk'; this.QPsAdvert['2'] = ''; this.QPsAdLinkBlocks['2'] = '<div class="mg_addad%id"><a href="http://mgid.com/advertisers%utm%id" target="_blank"> by <img src="//mgid.com/images/mgid_logo_mini_43x20.png" alt="Mgid" title="Mgid"></a></div><style type="text/css">div.mg_addad%id{text-align: right; opacity: 0.5;} div.mg_addad%id:hover{opacity: 1} div.mg_addad%id a{color: #000000; font:normal 10px Myriad Pro; text-decoration: none;} div.mg_addad%id img{margin-bottom: -5px; border:0px}</style>'; this.QPsUtm['2'] = '?utm_source=widget_adskeeper&utm_medium=text&utm_campaign=add&utm_content='; this.QPs['3'] = 'mgid.com'; this.QPsImages['3'] = 'mgid.com'; this.QPsAdvert['3'] = ''; this.QPsAdLinkBlocks['3'] = '<span class="mghead">%WIDGET_TITLE%</span><div class="mg_addad%id"><a href="http://mgid.com/advertisers%utm%id" target="_blank"> by <img src="//mgid.com/images/mgid_logo_mini_43x20.png" alt="Mgid" title="Mgid"></a></div><div class="clear"></div><style type="text/css">div.mg_addad%id{text-align: right; opacity: 0.5;margin-right: 10px} div.mg_addad%id:hover{opacity: 1} div.mg_addad%id a{color: #000000; font:normal 10px Myriad Pro; text-decoration: none;} div.mg_addad%id img{margin-bottom: -5px; border:0px} .mghead{font-weight:700;font-size:14px;text-transform:uppercase;text-align:left;font-family: "Open Sans", sans-serif;color:#4555a7;display:block;margin:0 0 0px 5px;float:left;}</style>'; this.QPsUtm['3'] = '?utm_source=widget&utm_medium=text&utm_campaign=add&utm_content='; this.LQ.push("DB"); var informerData = []; informerData.push({"id": "5443", "etalonId": "0", "protocol": "4", "type": "News", "subnet": "0"}); informerData.push({"id": "3321", "etalonId": "0", "protocol": "4", "type": "Goods", "subnet": "0"}); this.DB = function() { for (var i = 0; i < informerData.length; i++) { var tickerId = informerData[i].etalonId != "0" && informerData[i].protocol == "4" ? informerData[i].etalonId : informerData[i].id; if ((informerData[i].subnet !== '1') ^ ('0' === '1')) { (function(type) { self.RY["MarketGidLoad" + type + tickerId] = function(json) { self.GM = type.toLowerCase(); self.WG = '0'; self["MarketGidLoadNews"](json); }; })(informerData[i].type); if (informerData[i].protocol == "4") { self.RY["MarketGidRedirectComposite" + tickerId] = function() { self.WG = '0'; self["MarketGidRedirectComposite"].apply(self, [].slice.call(arguments, 0)); }; } else { self.RY["MarketGidRedirectComposite15797"] = function() { self.WG = '0'; self["MarketGidRedirectComposite"].apply(self, [].slice.call(arguments, 0)); }; } } if ((informerData[i].subnet !== '1') ^ ('1' === '1')) { (function(type) { self.RY["MarketGidLoad" + type + tickerId] = function(json) { self.GM = type.toLowerCase(); self.WG = '1'; self["MarketGidLoadNews"](json); }; })(informerData[i].type); if (informerData[i].protocol == "4") { self.RY["MarketGidRedirectComposite" + tickerId] = function() { self.WG = '1'; self["MarketGidRedirectComposite"].apply(self, [].slice.call(arguments, 0)); }; } else { self.RY["MarketGidRedirectComposite15797"] = function() { self.WG = '1'; self["MarketGidRedirectComposite"].apply(self, [].slice.call(arguments, 0)); }; } } if ((informerData[i].subnet !== '1') ^ ('2' === '1')) { (function(type) { self.RY["AdskeeperLoad" + type + tickerId] = function(json) { self.GM = type.toLowerCase(); self.WG = '2'; self["MarketGidLoadNews"](json); }; })(informerData[i].type); if (informerData[i].protocol == "4") { self.RY["AdskeeperRedirectComposite" + tickerId] = function() { self.WG = '2'; self["MarketGidRedirectComposite"].apply(self, [].slice.call(arguments, 0)); }; } else { self.RY["AdskeeperRedirectComposite15797"] = function() { self.WG = '2'; self["MarketGidRedirectComposite"].apply(self, [].slice.call(arguments, 0)); }; } } if ((informerData[i].subnet !== '1') ^ ('3' === '1')) { (function(type) { self.RY["FeedboxLoad" + type + tickerId] = function(json) { self.GM = type.toLowerCase(); self.WG = '3'; self["MarketGidLoadNews"](json); }; })(informerData[i].type); if (informerData[i].protocol == "4") { self.RY["FeedboxRedirectComposite" + tickerId] = function() { self.WG = '3'; self["MarketGidRedirectComposite"].apply(self, [].slice.call(arguments, 0)); }; } else { self.RY["FeedboxRedirectComposite15797"] = function() { self.WG = '3'; self["MarketGidRedirectComposite"].apply(self, [].slice.call(arguments, 0)); }; } } } }; }; MarketGidCSubnetsBlock15797.call(MarketGidInfC15797); MarketGidCMgqBlock15797 = function() { var self = this; this.isLongCheck = false; this.LQ.push("mgqInit"); this.mgqWorker = function() { for (var i = 0; i < self.RY._mgq.length; i++) { var el = self.RY._mgq[i]; if (typeof(self.RY[el[0]]) == 'function') { self.RY[el[0]].apply(self.RY, el.slice(1)); self.RY._mgq.splice(i, 1); } } if (!self.RY._mgqi) { self.RY._mgqi = self.RY.setInterval(function() { self.mgqWorker(); }, 5); } if (!self.isLongCheck) { if ((new Date()).getTime() - self.RY._mgqt > 10000) { self.isLongCheck = true; self.RY.clearInterval(self.RY._mgqi); self.RY._mgqi = self.RY.setInterval(function() { self.mgqWorker(); }, 100); } } }; this.mgqInit = function() { self.RY._mgq = self.RY._mgq || []; if (typeof(self.RY._mgqp) == 'undefined') { self.RY._mgqp = self.mgqWorker; self.RY._mgqt = (new Date()).getTime(); self.mgqWorker(); } }; }; MarketGidCMgqBlock15797.call(MarketGidInfC15797); MarketGidCAntifraudBlock15797 = function() { this.SP.push("PP"); this.LQ.push("initAntiFraud"); this.GQ = ""; this.UZ = ""; this.CD = ""; this.VX = ""; this.GI = ""; this.PF = ""; this.UD = ""; this.JQ = ""; this.initAntiFraud = function() { if (this.ZW["svspr"]==undefined) { this.CD = this.HX(this.RY.document.referrer,500); this.ZW["svspr"] = this.CD; this.setCookie(); } else this.CD = this.ZW["svspr"]; if (this.ZW["svsds"]!=undefined) { this.VX = this.ZW["svsds"]; this.VX++; } else this.VX = 1; this.ZW["svsds"] = this.VX; this.setCookie(); var D=new Date(); this.GQ = D.getTime() + '15797' + Math.floor(Math.random()*100) + '' + (2*Math.floor(Math.random()*4)+1); this.JQ = D.getTime(); if (this.ZW["TejndEEDj"]==undefined) { this.ZW["TejndEEDj"] = this.x64String(this.GQ); this.setCookie(); } }; this.x64String = function(s) { s=s.toString(); s=unescape(encodeURIComponent(s)); var b64c='\x41\x42\x43\x44\x45\x46\x47\x48\x49\x4a\x4b\x4c\x4d\x4e\x4f\x50\x51\x52\x24\x54\x55\x56\x57\x58\x59\x5a\x61\x62\x63\x64\x65\x2a\x67\x68\x69\x6a\x6b\x6c\x6d\x6e\x6f\x70\x71\x72\x73\x74\x75\x76\x77\x78\x79\x7a\x30\x31\x32\x33\x34\x35\x36\x37\x38\x39\x2b\x2f\x3d'; var b64e=''; var c1,c2,c3,c4,e1,e2,e3,e4; for (var i=0; i<s.length;) { c1=s.charCodeAt(i++); c2=2<<5; e1=c1>>(c2/32); c3=s.charCodeAt(i++); e2=((c1&3)<<(c2/16))|(c3>>(c2/16)); c4=s.charCodeAt(i++); e3=isNaN(c3)?c2:(((c3&15)<<(c2/32))|(c4>>(c2-58))); e4=isNaN(c4)?c2:(c4&(c2-1)); b64e+=b64c.charAt(e1)+b64c.charAt(e2)+b64c.charAt(e3)+b64c.charAt(e4); } return b64e; }; this.TT = function(n) { return n?Math.round(n).toString(16):''; }; this.HX = function(str,n){ return str.length > n ? str.substring(0,n) : str; }; this.backHref = function() { if (MarketGidInfC15797.GI && MarketGidInfC15797.PF) MarketGidInfC15797.PF['\x68\x72\x65\x66']=MarketGidInfC15797.GI; MarketGidInfC15797.UD=""; }; this.getCoordsElementOfPage = function(element) { var offsetLeft = 0, offsetTop = 0; do { offsetLeft += element.offsetLeft; offsetTop += element.offsetTop; } while (element = element.offsetParent); return {"x":offsetLeft, "y":offsetTop}; }; this.getCoordsClickOfPage = function(e) { var x = 0, y = 0; if (!e) e = this.RY.event; if (e.pageX || e.pageY) { x = e.pageX; y = e.pageY; } else if (e.clientX || e.clientY) { x = e.clientX + (this.RY.document.documentElement.scrollLeft || this.RY.document.body.scrollLeft) - this.RY.document.documentElement.clientLeft; y = e.clientY + (this.RY.document.documentElement.scrollTop || this.RY.document.body.scrollTop) - this.RY.document.documentElement.clientTop; } return {"x":x, "y":y}; }; this.VY = function() { return window.navigator.javaEnabled() ? 1 : 0; }; this.XV = function() { var flashEnabled = 0; if (typeof(navigator.plugins)!="undefined" && typeof(navigator.plugins["Shockwave Flash"])=="object") { flashEnabled = 1; } else if (typeof window.ActiveXObject != "undefined") { try { if (new ActiveXObject("ShockwaveFlash.ShockwaveFlash")) { flashEnabled = 1; } } catch(e) {}; } return flashEnabled; }; this.addParams = function(event, link) { if (link.className && link.className.indexOf("mg_addad")>=0) return; var D=new Date(); var e=event||this.RY.event; var coordClickOfPage = this.getCoordsClickOfPage(e); var b=link.getBoundingClientRect(); var coordLinkOfPage = this.getCoordsElementOfPage(link); var d=this.RY.document; if (!(link.href.indexOf('pnews') != -1 || link.href.indexOf('ghits') != -1)) return; var MG_p=/pp\/([0-9]+)\/([0-9]+)\/(k\/)?(?:s\/\d+\/(?:n\/\d+\/(?:x\/\d+\/)?)?)?#k([0-9]+)\??(\S*)/; var MG_nn=MG_p.exec(link.href); this.GI=link.href; this.PF=link; if (MG_nn) link.href = link.href.replace(MG_p, 'pp/' + MG_nn[1] + '/' + MG_nn[2] + '/' +(MG_nn[3]?MG_nn[3]:'') + (MG_nn[5]?'?'+MG_nn[5]+'&':'?') + 'k=' + MG_nn[4] + 'f'); else { var index = link.href.indexOf('?k=15797f'); if (index != -1) { link.href = link.href.substr(0, index) + '?k=15797f'; } else { index = link.href.indexOf('&k=15797f'); if (index != -1) { link.href = link.href.substr(0, index) + '&k=15797f'; } else { index = link.href.indexOf('?'); if (index != -1) { link.href += '&k=15797f'; } } } } var EO = 0; if (this.RY.opera) EO+=1; if (this.RY.opera&&this.RY.opera.buildNumber) EO+=2; if (this.RY.document.all||this.RY.MSStream) EO+=4; if (!this.RY.btoa||this.RY.navigator.msPointerEnabled) EO+=8; if (this.RY.chrome) EO+=16; if (this.RY.mozInnerScreenX!=undefined) EO+=32; if (!this.RY.external) EO+=64; var JB=''; for (var i=1;i<=Math.ceil((EO+1)/68)*31;i++) { if((i%26==0)||((i%26==6)&&(((i%26)+5)%11==0)))continue; JB+=(i==1?'':String.fromCharCode(102))+String.fromCharCode(96+(i%26))+String.fromCharCode(83); var IO=''; if(i>31)break; switch(i){ case 1:IO=this.GQ;break; case 2:IO=this.TT(b.bottom);break; case 3:IO=this.TT(this.JQ);break; case 4:IO=this.TT(D.getTime());break; case 5:IO=this.TT(d.body.clientheight);break; case 7:IO=this.TT(e.clientX);break; case 8:IO=this.TT(e.clientY);break; case 9:IO=this.TT(b.left);break; case 11:IO=this.TT(b.top);break; case 12:IO=this.TT(d.body.clientheight-e.clientY);break; case 13:IO=this.TT(b.right-b.left);break; case 14:IO=this.TT(b.bottom-b.top);break; case 15:IO=this.UD;break; case 16:IO=this.TT(e.clientY);break; case 17:IO=this.TT(EO);break; case 18:IO=this.TT(link['\x64\x61\x74\x61\x2d\x72\x65\x6C']);break; case 19:IO=this.HX(d.location.href,500);break; case 20:IO=this.HX(d.referrer,500);break; case 21:IO=this.CD;break; case 22:IO=this.TT(this.VX);break; case 23:IO=this.TT(coordClickOfPage.x);break; case 24:IO=this.TT(coordClickOfPage.y);break; case 25:IO=this.TT(coordLinkOfPage.x);break; case 27:IO=this.TT(coordLinkOfPage.y);break; case 28:IO=this.TT(this.VY());break; case 29:IO=this.TT(this.XV());break; case 30:IO=this.TT(window.screen.width);break; case 31:IO=this.TT(window.screen.height);break; } JB+=this.x64String(IO); } link['\x64\x61\x74\x61\x2d\x72\x65\x6C']=''; link['\x68\x72\x65\x66']=link['\x68\x72\x65\x66']+encodeURIComponent(JB); }; this.linkClick = function(event) { MarketGidInfC15797.addParams(event, this); MarketGidInfC15797.RY.setTimeout(MarketGidInfC15797.backHref,100); return true; }; this.linkMouseOver = function(event) { MarketGidInfC15797.addParams(event, this); var v=parseInt(this['\x64\x61\x74\x61\x2d\x72\x65\x6C'])?parseInt(this['\x64\x61\x74\x61\x2d\x72\x65\x6C']):0; if (v%2!=1) this['\x64\x61\x74\x61\x2d\x72\x65\x6C']=v+1; }; this.TB = function(event) { var v=parseInt(this['\x64\x61\x74\x61\x2d\x72\x65\x6C'])?parseInt(this['\x64\x61\x74\x61\x2d\x72\x65\x6C']):0; if ((v>>1)%2!=1) this['\x64\x61\x74\x61\x2d\x72\x65\x6C']=v+2; }; this.PP = function() { if (this.root) { this.CC = this.root.getElementsByTagName('a'); } for (var MG_l in this.CC) { this.CC[MG_l].onmouseup = this.linkClick; this.CC[MG_l].onmouseover = this.linkMouseOver; this.CC[MG_l].onmousemove = this.TB; } }; }; MarketGidCAntifraudBlock15797.call(MarketGidInfC15797); MarketGidCDiscountBlock15797 = function() { this.SP.push("HE"); this.ZE = function(event) { MarketGidInfC15797.helpIE(this); var pricesold = this.getElementsByClassName('mcpriceold3321'); var prices = this.getElementsByClassName('mcprice3321'); var discounts = this.getElementsByClassName('mcdiscount3321'); if (pricesold.length > 0) { pricesold[0].style.display = 'none'; prices.length > 1 ? prices[1].style.display = 'none' : null; discounts.length > 0 ? discounts[0].style.display = 'inline' : null; } }; this.FM = function(event) { MarketGidInfC15797.helpIE(this); var discounts = this.getElementsByClassName('mcdiscount3321'); var prices = this.getElementsByClassName('mcprice3321'); var pricesold = this.getElementsByClassName('mcpriceold3321'); if (pricesold.length > 0) { discounts.length > 0 ? discounts[0].style.display = 'none' : null; prices.length > 1 ? prices[1].style.display = 'inline' : null; pricesold[0].style.display = 'inline'; } }; this.HE = function() { if (this.root) { this.helpIE(this.root); var teasers = this.root.getElementsByClassName('mcteaser3321'); } for (var MG_t in teasers) { teasers[MG_t].onmouseout = this.FM; teasers[MG_t].onmouseover = this.ZE; } }; this.helpIE = function(el) { if (el.getElementsByClassName == undefined) { el.getElementsByClassName = function(cl) { var retnode = []; var myclass = new RegExp('\\b'+cl+'\\b'); var elem = this.getElementsByTagName('*'); for (var i = 0; i < elem.length; i++) { var classes = elem[i].className; if (myclass.test(classes)) retnode.push(elem[i]); } return retnode; }; } }; }; MarketGidCDiscountBlock15797.call(MarketGidInfC15797); MarketGidCCountersBlock15797 = function() { this.LQ.push("NO"); this.NO = function() { }; }; MarketGidCCountersBlock15797.call(MarketGidInfC15797); MarketGidCAdvertLinkBlock15797 = function() { this.PL.push("refreshAdvertLink"); this.LQ.push("loadAdvertLink"); this.advertLinkNeeded = true; this.loadAdvertLink = function() { if (this.RY.document.getElementById('mg_add15797')) this.advertLinkNeeded = true; else this.advertLinkNeeded = false; }; this.refreshAdvertLink = function() { if (this.advertLinkNeeded) { try { var adLinkBlock = this.QPsAdLinkBlocks[MarketGidInfC15797.WG].replace(/%id/g, '15797'); adLinkBlock = adLinkBlock.replace("%WIDGET_TITLE%", this.RY.MGWidgetTitle15797 ? this.RY.MGWidgetTitle15797 : ""); var utm = ''; if (utm == '') { utm = this.QPsUtm[MarketGidInfC15797.WG]; } this.XD = adLinkBlock.replace(/%utm/, utm); } catch (e) { }; } else { this.XD = ''; } }; }; MarketGidCAdvertLinkBlock15797.call(MarketGidInfC15797); MarketGidCLuxupBlock15797 = function() { var self = this; self.blankImage = "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D"; self.BQLuxup = self.BQ; self.precalcRect = {}; self.needToRecalcRect = false; self.luxup = function() { var h = self.IN(); if (self.precalcRect.top == self.precalcRect.bottom || self.needToRecalcRect == true) { if (self.needToRecalcRect == true) { self.needToRecalcRect = false; } self.updatePrecalcRect(); } var bound = self.precalcRect; if ((bound.top - h['s'] > 0 && bound.top - h['s'] < (h['c'])) || (bound.top - h['s'] < 0 && bound.bottom - h['s'] > 0)) { self.BQLuxup(); self.root.style.visibility = ''; self.BQ = self.BQLuxup; } else self.RY.setTimeout(self.luxup, 100); }; self.updatePrecalcRect = function() { self.GM = "news"; self.WG = '0'; self.fakeMode = true; var realRoot = self.root; var cnt = self.RY.document.createElement('div'); var newRoot = self.RY.document.createElement('div'); newRoot.id = self.root.id; self.root.id += "_"; cnt.appendChild(newRoot); self.root.appendChild(cnt); self.root = newRoot; realRoot.style.height = "0px"; realRoot.style.overflow = "hidden"; var countNews = 10; var data = []; for (var i = 1; i <= countNews; i++) { data.push(['', i,'', 'Lorem ipsum dolor sit amet', '', '', '', {i: self.blankImage}]); } self.MarketGidLoadNews(data); var h = self.IN(); var widgetRect = self.root.getBoundingClientRect(); self.precalcRect["top"] = widgetRect.top + h['s']; self.precalcRect["bottom"] = widgetRect.bottom +h['s']; self.requestParams.w = "w=" + (widgetRect.width ? widgetRect.width : widgetRect.right - widgetRect.left); self.requestParams.h = "h=" + (widgetRect.height ? widgetRect.height : widgetRect.bottom - widgetRect.top); self.fakeMode = false; self.root = realRoot; self.root.removeChild(cnt); self.root.id = self.root.id.substr(0, self.root.id.length - 1); self.root.style.height = "auto"; self.root.style.overflow = "visible"; self.GM = ""; self.WG = ""; self.MH = 0; self.template = ""; self.iteration = 1; self.NS = {}; }; self.BQ = function() { self.updatePrecalcRect(); self.luxup(); self.addEvent(self.RY, "load", function() { self.needToRecalcRect = true; }); }; }; MarketGidCLuxupBlock15797.call(MarketGidInfC15797); MarketGidCMonitorBlock15797 = function() { this.SP.push("monitorInit"); this.shownBlocks = {}; this.monitorInterval = null; this.monitorInit = function() { var regex = /\/\/img.*\/[\d]+\/([\d]+).*\.(jpg|gif)/; if (!this.monitorInterval) { this.monitorInterval = MarketGidInfC15797.RY.setInterval(function() { var newBlocks = {}; var images = MarketGidInfC15797.root.getElementsByTagName('IMG'); for (var i = 0; i < images.length; i++) { if (MarketGidInfC15797.isElementInViewport(images[i])) { var res = regex.exec(images[i].src); if (res && res[1] && !MarketGidInfC15797.shownBlocks[res[1]]) { MarketGidInfC15797.shownBlocks[res[1]] = 1; newBlocks[res[1]] = 1; } } } MarketGidInfC15797.prepareCappingData(newBlocks); }, 1000); } }; this.prepareCappingData = function(blocks) { var prefix = MarketGidInfC15797.GM == 'news' ? "N" : "G"; var data = ""; var counter = 0; for (var i in blocks) { data += MarketGidInfC15797.teaserHashes[i]; counter++; if (counter > 20) { MarketGidInfC15797.sendCappingData(prefix + data); data = ""; counter = 0; } } if (data!="") MarketGidInfC15797.sendCappingData(prefix + data); }; this.sendCappingData = function(data) { var img = document.createElement('IMG'); img.src = "//c.mgid.com/c?p=" + data; }; this.isElementInViewport = function(el) { var rect = el.getBoundingClientRect(); return ( rect.top >= 0 && rect.left >= 0 && rect.bottom <= (MarketGidInfC15797.RY.innerHeight || MarketGidInfC15797.RY.document.documentElement.clientHeight) && rect.right <= (MarketGidInfC15797.RY.innerWidth || MarketGidInfC15797.RY.document.documentElement.clientWidth) ); }; }; MarketGidCMonitorBlock15797.call(MarketGidInfC15797); MarketGidInfC15797.init(); MarketGidInfC15797.start(); } 