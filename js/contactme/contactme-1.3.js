/**
 *
 * ContactMe
 * https://www.21tools.it
 *
 */

var lang='Eng';

var qbtn = false;

(function($) {
	// More then one form allowed
	$('.contactMe').each(function(index) {

		var $form        = $(this),
		    $msg         = $form.find('.msg'),
		    $submitBtn	 = $form.find('button[type=submit]');

		// Handle Form Submit
		$form.submit(function(e) {
			// prevent form submit
			e.preventDefault();

			// Prevent double submission by disabling the submit button
			$submitBtn.html($submitBtn.data('sending')).attr('disabled', 'disabled');

			// Hide previous messages
			$msg.fadeOut(0);

			// Validate the Form Data
			var validate = validateForm($form);
			if (!validate.success)
			{
				if (validate.errors.length > 0)
				{
					showMessage($msg, errorsArrayToHtml(validate.errors), 'error');
			    	// Re-enable submit button
			    	$submitBtn.html($submitBtn.data('text')).removeAttr('disabled');
			    	return null;
			    }
			}
			else {
                submitAjaxForm($form);
			}

				});

		$submitBtn.attr('data-text', $submitBtn.html());
	});

	var count = 0;


	// convert all select dropdowns into "Select2" dropdowns
	if(typeof($.fn.select2) != 'undefined') {
		$('.contactMe select').each(function(index) {
			var placeholder = $(this).attr('placeholder');
			$(this).select2({
				minimumResultsForSearch:-1,
				placeholder:placeholder,
				allowClear:true
			});
		});
	}


}(jQuery));

/* Functions */

/* Validate a form */
function validateForm($form)
{
	var $msg = $form.find('.msg'),
		errors = [],
		success = true;

	// Loop through fields
	$form.find('.field').each(function(index) {
		var err = validateField(jQuery(this));
		if(err != null) { errors.push(err); }
	});

	// Check if there're errors
	if (errors.length > 0) {
		success = false;
	}

	return {success:success, errors:errors};
}

/* Validate a single field */
function validateField($field)
{
	var type = $field.prop('type'),
	    displayName = $field.data('displayname'),
	    value  = $field.val(),
	    msg = null;

	// Check if is required
	if($field.prop('required') && $field.val() === '') {
		msg = paramsIntoString(lang.required_field, [displayName]);
		return msg;
	}
	else if($field.val() === '') {
		return null;
	}

	// Check the type
	switch(type) {
		case 'email':
			var atIndex = value.indexOf("@"),
			    dotIndex = value.lastIndexOf(".");

			if (atIndex < 1 || dotIndex < 1 || dotIndex < atIndex || dotIndex >= value.length ) {
				msg = paramsIntoString(lang.email_invalid, [displayName]);
				return msg;
			}
			break;
		case 'number':
		case 'tel':
			if (!jQuery.isNumeric(value)) {
				msg = paramsIntoString(lang.number_invalid, [displayName]);
				return msg;
			}
			break;

	}

	return null;
}

/* Replace params into string */
function paramsIntoString(string, params)
{
	var i;
	for (i = 0; i < params.length; i++) {
		string = string.replace("{{" + (i+1) + "}}", params[i]);
	}
	return string;
}

/* Create html from errors array */
function errorsArrayToHtml(errors)
{
	var resultHtml = "";

	for (var i = 0; i < errors.length; i++) {
		resultHtml += errors[i] + "<br />";
	}

	return resultHtml;
}

/* Show Form Messages */
function showMessage($msg, html, type)
{
	$msg.html(html).removeClass('error success').addClass(type).fadeIn(400);
}

/* Reset a Form */
function resetForm($form, time)
{
	var time_anim = time > 0 ? 400 : 0;

	$form[0].reset();
	if(typeof(jQuery.fn.select2) != 'undefined') {
		$form.find('select').select2('val', {});
	}
	$form.find('.form-row.file input').trigger('change');
	if(typeof(grecaptcha) != 'undefined' && $form.find('.re-captcha').length > 0) {
		grecaptcha.reset($form.find('.re-captcha').data('grecaptcha'));
	}
	setTimeout(function() {
		$form.find('.msg').fadeOut(time_anim).html('').removeClass('error success');
	}, time);
}


function checkquote()
{
    qbtn = true
}


/* Submit the Form */
function submitAjaxForm($form)
{
	var $msg 		 = $form.find('.msg'),
	    $submitBtn	 = $form.find('button[type=submit]'),
	    submitBtnTxt = $submitBtn.data('text'),
	    action 		 = $form.prop('action'),
		formData;

		var rcode = $('#rcode').val();

	// Prevent double submission by disabling the submit button
	$submitBtn.html($submitBtn.data('sending')).attr('disabled', 'disabled');

	formData = new FormData($form[0]);
	// Send informations
	jQuery.ajax({
		url: './scripts/quote.php',
		type: 'POST',
		data: formData,
		processData: false,
		contentType: false,
		success: function(data)
        {

			if(data!=="success") {
				// Show errors

                swal(
                    'OOps',
                    errorsArrayToHtml(data),
                    'error'
                );

				//showMessage($msg, errorsArrayToHtml(data), 'error');
	            // Re-enable submit button
				$submitBtn.html(submitBtnTxt).removeAttr('disabled');
				return null;
			}
			else {
				// Show success message
                if(qbtn)
                {
                    swal({
                        title: 'Thank you',
                        type:'success',
                        html:'Your quote request has been received. <br>You will be contacted shortly.<br>'

                    })
                }
                else
                {
                    swal({
                        title: 'Thank you',
                        type:'success',
                        html:'Your subscription request has been received. <br>Pay into any of our bank accounts.<br>' +
                        '<span class="text-danger font-weight-bold">WEMA BANK: 0122846391 </span> Beaver Home Maintenance Coy <br>'+
                        '<span class="text-danger font-weight-bold">FIDELITY BANK: 6600018554 </span> Beaver Home Maintenance Coy<br>'+
                        'Use this reference code: <span class="text-danger font-weight-bold">'+rcode+'</span> when making payments<br>'+
                        'You will be contacted within 24Hrs, after payment confirmation'

                    });
                }

				//showMessage($msg, "Your subscription request has been received. We will contact you shortly ", 'success');
				resetForm($form, 6000);
				// Re-enable submit button
				$submitBtn.html(submitBtnTxt).removeAttr('disabled');
			}

        },
        error: function(data)
        {
        	// Something went wrong
			//showMessage($msg, lang.something_wrong, 'error');

			console.log(data);

			// Re-enable submit button
			$submitBtn.html(submitBtnTxt).removeAttr('disabled');
        }
	});
}
