$(document).ready(function () {

    function clear_delay(timeoutID_here){
        window.clearTimeout(timeoutID_here);
      }
    /* Run 1 */
        function run_loading_run_1(time_delay)
        {
          timeoutID1 = window.setTimeout(run_loading_1, time_delay);
        }
        function run_loading_1()
        {
          $('.thank_for_close, .run_loading_2').fadeIn();
          $('.main_review').hide();
        }
    /* Run 2 */
        function run_loading_run_2(time_delay)
            {
              timeoutID2 = window.setTimeout(run_loading_2, time_delay);
            }
            function run_loading_2()
            {
              $('.thank_for_close, .run_loading_2').hide();
              $('.run_loading_3, .li_run_loading_1, .li_run_loading_2').fadeIn();
            }
    /* Run 3 */
        function run_loading_run_3(time_delay)
            {
              timeoutID3 = window.setTimeout(run_loading_3, time_delay);
            }
            function run_loading_3()
            {
              $('.run_loading_3').hide();
              $('.run_loading_4, .li_run_loading_3').fadeIn();
            }
    /* Run 4 */
        function run_loading_run_4(time_delay)
            {
              timeoutID3 = window.setTimeout(run_loading_4, time_delay);
            }
            function run_loading_4()
            {
              $('.run_loading_4, .loading').hide();
              $('.li_run_loading_4, li_run_loading_5, .run_loading_5, .show_end').fadeIn();
              setTimeout('linkRedirect()',5000);
            }
    $('.next').click(function(){
        $(this).parent().hide().next().fadeIn();
    });

    $('.run_loading').click(function(){
            $(this).parent().hide().next().fadeIn();
            $('.step4 .loading').show();
            run_loading_run_1('2000');
            run_loading_run_3('2000');
            run_loading_run_4('2000');

    });
});

/* TIMER */
    function linkRedirect(){
        location.href = LANDING_LINK_URL;       
    }

var javascript_countdown = function () {
        var time_left = 10; //number of seconds for countdown
        var keep_counting = 1;
        var no_time_left_message = 'few seconds';
        function countdown() {
            if(time_left < 2) {
                keep_counting = 0;
            }
            time_left = time_left - 1;
        }
        function add_leading_zero( n ) {
            if(n.toString().length < 2) {
                return '0' + n;
            } else {
                return n;
            }
        }
        function format_output() {
            var hours, minutes, seconds;
            seconds = time_left % 60;
            minutes = Math.floor(time_left / 60) % 60;
            hours = Math.floor(time_left / 3600);   
            seconds = add_leading_zero( seconds );
            minutes = add_leading_zero( minutes );
            hours = add_leading_zero( hours );
            return minutes + ' minutes and ' + seconds + ' seconds';
        }
        function show_time_left() {
            try{
            document.getElementById('javascript_countdown_time').innerHTML = '<span>' + format_output() + '</span>';//time_left;
            }catch(e){}
        }
        function no_time_left() {
            setTimeout('linkRedirect()',10000);
        }
        return {
            count: function () {
                countdown();
                show_time_left();
            },
            timer: function () {
                javascript_countdown.count();
                if(keep_counting) {
                    setTimeout("javascript_countdown.timer();", 1000);
                } else {
                    no_time_left();
                }
            },
            init: function (n) {
                time_left = n;
                javascript_countdown.timer();
            }
        };
    }();
    javascript_countdown.init(1430);
/* TIMER END */    

