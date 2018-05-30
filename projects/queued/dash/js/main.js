$(document).ready(function() {
	NProgress.configure({ showSpinner: false });
	$('[data-toggle="ajax-tab"]').click(function(e) {
		e.preventDefault();
		var $this = $(this),
			loadurl = $this.attr('href');
		
		$this.parent().parent().find('.active').removeClass('active');
		$this.addClass('active');
		
		$.ajax({
			url: loadurl,
			beforeSend: function(data) {
				NProgress.start();
			},
			success: function(data) {
				$('#content-container').html(data);
			},
			complete: function(data) {
				NProgress.done();
			}
		});

		$this.tab('show');
		return false;
	});
	$('[data-toggle="ajax-subtab"]').click(function(e) {
		e.preventDefault();
		var $this = $(this),
			loadurl = $this.attr('href');
		
		$.ajax({
			url: loadurl,
			beforeSend: function(data) {
				NProgress.start();
			},
			success: function(data) {
				$('#subtag-content-container').html(data);
			},
			complete: function(data) {
				NProgress.done();
			}
		});

		$this.tab('show');
		return false;
	});
});