$(function(){
	/*
	 * The purpose of this view is to bind events and make the actual calls to
	 * the server
	 */
	var ShortenerApp = Backbone.View.extend({
		_text: "nothing",
		el: $("#shortener-app"),
		
		
		
		events: {
			"click #btn-shorten": "shortenURL",
			"click #btn-copy": "copyURL"
		},
		
		initialize: function() {
		
		},
		
		render: function() {
		
		},
		
		/*
		 * This will run the shorten call from the server
		 * returns 
		 */
		shortenURL: function() {
			var _self = this;
			$('.url-shorten-status,.url-shorten-error').hide();
			$('.ui-shorten-form button[type=submit]').attr('disabled', 'disabled');
			
			var shorten_url = $('.zeromq').length > 0 ? '/api/v1/0mqshorten' : 'api/v1/shorten';
		
		
			$.ajax({
				url:  'api/v1/shorten',
				type: 'post',
				dataType: 'json',
				data: $('.ui-shorten-form').serialize(),
				success:function(r) {
					$('.ui-shorten-form button[type=submit]').removeAttr('disabled');
					
					if(r.status === 'error') {
						$('.url-shorten-error').show();
						$('.url-shorten-error').html('Whoa! ' + r.message);
					} else {
						$('.url-shorten-status').show();
						$('.ui-copy-link').attr('href',  r.friendly_url);
						$('.url-shorten-status span').html('Cool! Your URL has been shortened to ' + r.friendly_url);
						_self._text = r.friendly_url;
						$('#url').val('');
					}
				}
			}).fail(function(r, textStatus) {
				$('.url-shorten-error').show();
				$('.url-shorten-error').html('Whoa! ' + textStatus);
				
				// died, but let them try again just in case it was a blip
				$('.ui-shorten-form button[type=submit]').removeAttr('disabled');
				
			});
			return false;
		},
		
		/* 
		 * Simply displays a prompt so that the user can copy the link
		 * returns
		 */
		copyURL: function() {
			window.prompt ("Copy this to your clipboard:", this._text);
			return false;
		}

	});
	

	
	var objApp = new ShortenerApp;
});
