$(document).ready(function()
{

var page = "http://www.fontainebleau.com"
page = encodeURIComponent(page);

 $(".visitbutton").on("click", function()
    {
              $.ajax({
                   url:"http://i.samesurf.com/g/random/" + page,
                   dataType: 'jsonp',
                   success: function(data) {
                   var link = "http://i.samesurf.com/i/" + data.link;
                   window.open(link);
                   }
              });

    });
});