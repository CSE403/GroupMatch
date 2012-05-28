/*
 * This script is responsible for the behavioral style of the various pages.
 * Each page's section is marked with a heading.
 */
 
 
 //returns true if n is a real positive integer, otherwise false
 function isPosInt(n) {
	return $.isNumeric(n) && n > 0 && n.split('.').length == 1;
 }
 
$(function() {
	/***************************************************************************
	 * Create poll scripting
	 **************************************************************************/
	
	// universal limit checkbox
	limitAllCheckbox = $('input[name="option_all_limit"]');
	limitAllNumberbox = $('input[name="option_all_limit_amount"]');
	if (limitAllCheckbox) {
		// enable/disable input
		limitAllCheckbox.click(function() {
			if ($(this).attr("checked")) {
				limitAllNumberbox.removeAttr("disabled");
				limitAllNumberbox.attr("required","required");
				limitAllNumberbox.focus();
			}else {
				limitAllNumberbox.attr("disabled", "disabled");
				limitAllNumberbox.removeAttr("required");
			}
		});
		
		// change all limits that are not uniquely set
		limitAllNumberbox.blur(function() {
			if (!$(this).attr("disabled") && limitAllCheckbox.attr("checked")) {
				optionLimits = $('input[name*="option_limit_amount"][disabled="disabled"]');
				optionLimits.attr("value", $(this).attr("value"));
			}
		});
		
	}
	
	// rate on scale radio
	answerType = $('input[name="answer_type"]');
	maxScale = $('input[name="scale_max"]');
	if (answerType) {
		answerType.change(function() {
			if ($(this).attr("value") == 4) {
				maxScale.removeAttr("disabled");
				maxScale.focus();
			}else {
				maxScale.attr("disabled", "disabled");
			}
		});
	}
	
	// option limit checkbox
	limitCheckboxSetup = function() {
		limitCheckboxes = $('input[name*="option_limit"]');
		if (limitCheckboxes != null) {
			limitCheckboxes.click(function() {
				var index = $(this).attr("name").split("_");
				index = index[index.length-1];
				if($(this).attr("checked")) {	
					if($.isNumeric(index) && index > 2) //make first two option boxes always required
						$(this).prev().attr("required","required");
					$(this).next().removeAttr("disabled")
							.attr("required","required").focus();
				} else {
					if(!$.isNumeric(index) && index > 2) //make first two option boxes required
						$(this).prev().removeAttr("required");
					$(this).next().attr("disabled", "disabled").removeAttr("required");
				}
			});
		}
	};
	limitCheckboxSetup();
	
	// add more options button
	addButton = $('button[name="add_more_options"]');
	if (addButton) {
		addButton.click(function(e) {
			e.preventDefault();
			count = $('input[name*="option_limit_amount"]').last().attr("name").split("_")[3];
			optionList = $('#option_list');
			for (var i = 0; i < 5; i++) {
				count++;
				optionList.append('<li>' + 
									  '<input name="option_' + count + '" type="text" placeholder="Option" />' + 
									  '<input name="option_limit_' + count + '" type="checkbox" />'+ 
									  '<input name="option_limit_amount_' + count + '" type="number" placeholder="10" min="1" disabled="disabled" />' +
								  '</li>')
				
			}
			limitCheckboxSetup();
			$('html, body').animate({scrollTop: $(document).height()}, 'slow');
		});
	}
	
	createPollForm = $("#create_poll");
	if(createPollForm) {
		createPollForm.submit(function() {
			var errors = false;
			
			//check universal limit
			if(limitAllCheckbox.attr('checked') && !isPosInt(limitAllNumberbox.val())) {
				limitAllNumberbox.val('');
				errors = true;
			}
			
			var ola = 'option_limit_amount_';
			var ol = 'option_limit_';
			//check individual limits
			$(':input[name*="' + ola + '"]').each(function() {
				var i = $(this).attr("name");
				i = i.substring(ola.length, i.length);
				
				if($(':input[name="' + ol + i + '"]').attr("checked") && !isPosInt($(this).val())) {
					$(this).val('');
					errors = true;
				}
			});
			if(errors)
				return false;
		});
	}
	
	/***************************************************************************
	 * Poll management scripting
	 **************************************************************************/
	
	deleteButtons = $('button[name="delete_poll"]');
	if (deleteButtons) {
		deleteButtons.click(function() {
			var li = $(this).closest('li')
			li.animate({
			    opacity: 0,
			    height: 'toggle',
			    padding: 'toggle',
			    margin: 'toggle'
			  }, 200, function() {
			    li.detach();
			    
			    // show empty list message
			    if (!$('#poll_list').children().is('li')) {
			    	$('#no_polls_message').animate({
					    opacity: 1,
					    height: 'toggle',
					    padding: 'toggle',
					    margin: 'toggle'
					  }, 100, function(){}
					 );
			    }
			    
			    //TODO make call to remove poll here
			  });
		});
	}
	
	/***************************************************************************
	 * Poll View Scripting
	 **************************************************************************/
	$(".inline").colorbox({inline:true, width:"50%"});
	
	/***************************************************************************
	 * Poll Participant Scripting
	 **************************************************************************/
	 
	 //ensures that all options are within the valid range before submissione
	 //if they are not all valid values on submit, they are turned into ''
	 var participate_form = $('form[name="participate_form"]');
	 var unique = $('#isUnique').val();
	 if(participate_form) {
		participate_form.submit(function() {
			var error = false;
			var ratings = $(':input[name*="option"]');
			if(unique == 1) { //if unique rating scale...
				var max = ratings.length;
				var values = [];
				ratings.each(function(index) {
					var v = $(this).val();
					if(!isPosInt(v) || v > max) {
						$(this).val('');
						error = true;
					}
					values[index] = v;
				});
				ratings.each(function(index) {
					var v = $(this).val();
					for(i = 0; i < values.length; i++) {
						if(i != index && v == values[i]) {
							error = true;
							$(this).val('');
						}
					}
				});
			} else { //if on scale from 1 - 5
				var max = 5;
				ratings.each(function(index) {
					var v = $(this).val();
					if(!isPosInt(v) || v > max) {
						$(this).val('');
						error = true;
					}
				});
			}
			if(error)
				return false;
		});
	 }
	 
});