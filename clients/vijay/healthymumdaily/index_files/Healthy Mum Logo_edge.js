/**
 * Adobe Edge: symbol definitions
 */
(function($, Edge, compId){
//images folder
var im='http://8724a928eab751f0ed7a-4d0f36b81c60b941b0b97f37a3358e0c.r52.cf2.rackcdn.com/templates/HealthyMum/animations/HealthyMumLogoAnimation/images/';

var fonts = {};
var opts = {
    'gAudioPreloadPreference': 'auto',

    'gVideoPreloadPreference': 'auto'
};
var resources = [
];
var symbols = {
"stage": {
    version: "4.0.0",
    minimumCompatibleVersion: "4.0.0",
    build: "4.0.0.359",
    baseState: "Base State",
    scaleToFit: "none",
    centerStage: "none",
    initialState: "Base State",
    gpuAccelerate: false,
    resizeInstances: false,
    content: {
            dom: [
            {
                id: 'cosita',
                type: 'image',
                rect: ['121px', '50px','169px','23px','auto', 'auto'],
                fill: ["rgba(0,0,0,0)",im+"cosita.png",'0px','0px']
            },
            {
                id: 'mascara_2',
                type: 'image',
                rect: ['121px', '50px','169px','23px','auto', 'auto'],
                fill: ["rgba(0,0,0,0)",im+"mascara%202.png",'0px','0px']
            },
            {
                id: 'daily',
                type: 'image',
                rect: ['82px', '48px','59px','32px','auto', 'auto'],
                fill: ["rgba(0,0,0,0)",im+"daily.png",'0px','0px']
            },
            {
                id: 'mum',
                type: 'image',
                rect: ['206px', '13px','87px','48px','auto', 'auto'],
                fill: ["rgba(0,0,0,0)",im+"mum.png",'0px','0px']
            },
            {
                id: 'Rectangle',
                type: 'rect',
                rect: ['82px', '13px','117px','37px','auto', 'auto'],
                fill: ["rgba(255,255,255,1.00)"],
                stroke: [0,"rgba(0,0,0,0.00)","none"]
            },
            {
                id: 'healthy',
                type: 'image',
                rect: ['82px', '13px','125px','48px','auto', 'auto'],
                fill: ["rgba(0,0,0,0)",im+"healthy.png",'0px','0px']
            },
            {
                id: 'mascara_1',
                type: 'image',
                rect: ['0', '0','85px','91px','auto', 'auto'],
                fill: ["rgba(0,0,0,0)",im+"mascara%201.png",'0px','0px']
            },
            {
                id: 'bolita',
                type: 'image',
                rect: ['37px', '2px','27px','27px','auto', 'auto'],
                fill: ["rgba(0,0,0,0)",im+"bolita.png",'0px','0px']
            },
            {
                id: 'hojita',
                type: 'image',
                rect: ['0', '0','85px','91px','auto', 'auto'],
                fill: ["rgba(0,0,0,0)",im+"hojita.png",'0px','0px']
            }],
            symbolInstances: [

            ]
        },
    states: {
        "Base State": {
            "${_mum}": [
                ["style", "left", '112px'],
                ["style", "top", '13px']
            ],
            "${_Rectangle}": [
                ["style", "height", '37px'],
                ["style", "left", '82px'],
                ["style", "width", '117px']
            ],
            "${_bolita}": [
                ["style", "left", '37px'],
                ["style", "top", '29px']
            ],
            "${_cosita}": [
                ["style", "left", '121px'],
                ["style", "top", '50px']
            ],
            "${_Stage}": [
                ["color", "background-color", 'rgba(255,255,255,1)'],
                ["style", "width", '294px'],
                ["style", "height", '91px'],
                ["style", "overflow", 'hidden']
            ],
            "${_mascara_2}": [
                ["style", "left", '121px'],
                ["style", "top", '50px']
            ],
            "${_healthy}": [
                ["style", "top", '13px'],
                ["style", "left", '-61px']
            ],
            "${_daily}": [
                ["style", "left", '82px'],
                ["style", "top", '21px']
            ]
        }
    },
    timelines: {
        "Default Timeline": {
            fromState: "Base State",
            toState: "",
            duration: 4250,
            autoPlay: true,
            timeline: [
                { id: "eid6", tween: [ "style", "${_healthy}", "left", '82px', { fromValue: '-61px'}], position: 1250, duration: 1250, easing: "easeOutQuint" },
                { id: "eid4", tween: [ "style", "${_bolita}", "top", '2px', { fromValue: '29px'}], position: 500, duration: 750, easing: "easeOutBack" },
                { id: "eid14", tween: [ "style", "${_mascara_2}", "left", '294px', { fromValue: '121px'}], position: 3250, duration: 1000, easing: "easeOutQuint" },
                { id: "eid8", tween: [ "style", "${_mum}", "left", '206px', { fromValue: '112px'}], position: 2000, duration: 1000, easing: "easeOutQuint" },
                { id: "eid11", tween: [ "style", "${_daily}", "top", '48px', { fromValue: '21px'}], position: 2750, duration: 750, easing: "easeOutQuint" }            ]
        }
    }
}
};


Edge.registerCompositionDefn(compId, symbols, fonts, resources, opts);

/**
 * Adobe Edge DOM Ready Event Handler
 */
$(window).ready(function() {
     Edge.launchComposition(compId);
});
})(jQuery, AdobeEdge, "EDGE-54819652");
