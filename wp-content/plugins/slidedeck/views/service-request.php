<style>
	@import url(https://fonts.googleapis.com/css?family=Roboto:400,300,600,400italic);

	.sd-service-container {
		max-width: 400px;
		width: 100%;
		margin: 0 auto;
		position: relative;
	}
	.sd-service-loading {
		text-align: center;
		display: none;
	}
	.sd-service-message {
		background-color: #4CAF50;
		padding: 10px;
		color: #fff;
		display:none;
	}
	#sd-service-contact input[type="text"],
	#sd-service-contact input[type="email"],
	#sd-service-contact input[type="tel"],
	#sd-service-contact input[type="url"],
	#sd-service-contact textarea,
	#sd-service-contact button[type="submit"] {
		font: 400 12px/16px "Roboto", Helvetica, Arial, sans-serif;
	}

	#sd-service-contact {
		background: #F9F9F9;
		padding: 25px;
		margin: 35px 0;
		box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
	}

	#sd-service-contact h3 {
		display: block;
		font-size: 30px;
		font-weight: 300;
		margin-bottom: 10px;
	}

	#sd-service-contact h4 {
		margin: 5px 0 15px;
		display: block;
		font-size: 13px;
		font-weight: 400;
	}

	#sd-service-contact fieldset {
		border: medium none !important;
		margin: 0 0 10px;
		min-width: 100%;
		padding: 0;
		width: 100%;
	}

	#sd-service-contact input[type="text"],
	#sd-service-contact input[type="email"],
	#sd-service-contact input[type="tel"],
	#sd-service-contact input[type="url"],
	#sd-service-contact select,
	#sd-service-contact textarea {
		width: 100%;
		border: 1px solid #ccc;
		background: #FFF;
		margin: 0 0 5px;
		padding: 10px;
	}

	#sd-service-contact input[type="text"]:hover,
	#sd-service-contact input[type="email"]:hover,
	#sd-service-contact input[type="tel"]:hover,
	#sd-service-contact input[type="url"]:hover,
	#sd-service-contact select,
	#sd-service-contact textarea:hover {
		-webkit-transition: border-color 0.3s ease-in-out;
		-moz-transition: border-color 0.3s ease-in-out;
		transition: border-color 0.3s ease-in-out;
		border: 1px solid #aaa;
	}

	#sd-service-contact textarea {
		height: 100px;
		max-width: 100%;
		resize: none;
	}

	#sd-service-contact button[type="submit"] {
		cursor: pointer;
		width: 100%;
		border: none;
		background: #4CAF50;
		color: #FFF;
		margin: 0 0 5px;
		padding: 10px;
		font-size: 15px;
	}

	#sd-service-contact button[type="submit"]:hover {
		background: #43A047;
		-webkit-transition: background 0.3s ease-in-out;
		-moz-transition: background 0.3s ease-in-out;
		transition: background-color 0.3s ease-in-out;
	}

	#sd-service-contact button[type="submit"]:active {
		box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.5);
	}

	.copyright {
		text-align: center;
	}

	#sd-service-contact input:focus,
	#sd-service-contact textarea:focus {
		outline: 0;
		border: 1px solid #aaa;
	}

	::-webkit-input-placeholder {
		color: #888;
	}

	:-moz-placeholder {
		color: #888;
	}

	::-moz-placeholder {
		color: #888;
	}

	:-ms-input-placeholder {
		color: #888;
	}
</style>
<div class="sd-service-container">

	<form id="sd-service-contact" action="" method="post">
		<div class="sd-service-message">
			<?php
			//echo $output;
			?>
		</div>
		<?php
		//}
		?>
		<h3>Custom Slider Request</h3>
		<h4>Contact us to design custom slider as per your needs</h4>
		<fieldset>
			<input name="email" id="email" placeholder="Your Email Address" type="email" tabindex="1" required>
		</fieldset>
		<!-- <fieldset>
			<select name='type' id="type" tabindex="2" required>
				 <option value="Installation and Configuration">Installation and Configuration</option>
				<option value="Customization">Customization</option>
			</select>
		</fieldset>
		<fieldset>
			<select name="module" id="module" tabindex="3" required>
				<option value="SlideDeck">SlideDeck</option>
			</select>
		</fieldset>
		-->
		<fieldset>
			<textarea name="detailed-description" id="detailed_description" placeholder="Description about required customization" tabindex="4" required></textarea>
		</fieldset>
		<fieldset>
			<button name="sd-service-submit" type="submit" id="sd-service-submit">Submit</button>
		</fieldset>
		<div class="sd-service-loading">
			<img src="<?php echo SLIDEDECK_URL .'images/loading-service.gif' ?>" alt="" />
		</div>
	</form>
</div>
<script>
    jQuery(document).ready(function() {
    jQuery('#sd-service-submit').click(function(e){
        e.preventDefault();
        jQuery('.sd-service-message').hide();
        var err_message = '';
        var flag = 0;
        var email = jQuery('#email').val();
        var description = jQuery('#detailed_description').val();
        if( email == '' || !isValidEmailAddress(email) ){
            err_message = 'Please enter valid email address';
            flag = 1;
        }else if( description == '' ){
            err_message = "Please enter some description";
            flag = 1;
        }

        if( !flag ){
            var form = jQuery('#sd-service-contact');
            jQuery('.sd-service-loading').show();
            jQuery.ajax({
                url: ajaxurl,
                data: form.serialize()+'&action=slidedeck_service_request',
                type: 'POST',
                success:function(data){
                    jQuery('.sd-service-message').html(data);
                    jQuery('.sd-service-message').show();
                    document.getElementById('sd-service-contact').reset();
                    jQuery('.sd-service-loading').hide();
                }
            });
        }else{
            jQuery('.sd-service-message').html(err_message);
            jQuery('.sd-service-message').show();
        }
    });
    });
    function isValidEmailAddress(emailAddress) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    };
</script>
