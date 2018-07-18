jQuery(document).ready(function(){
	"use strict";

	var $globalHeader = $('#header.global-header.fixed');
	var $mainContent = $('#main-content.main-content');
	var $output = $('#output');
/*
	$globalHeader.addClass('compact');
	$mainContent.css({'padding-top': 100});

	// Keep the header compacted
	$(window).on('scroll', function () {
		$globalHeader.addClass('compact');

		$mainContent.css({'padding-top': 100});

	});
*/
	function validateInputs(curInput){
		var emptyFields = false;

		curInput.previousElementSibling.style.color = "" === curInput.value.trim() ? 'red' : 'inherit';

		var inputs = $(curInput.form).find('input:not([type="submit"]):not([name="email"]):required');

		for(var i = 0; i < inputs.length; i++){
			if("" === inputs[i].value.trim() ){
				emptyFields = true;
				break;
			}
		}

		if( ! emptyFields &&  validPWD() ){
			$(curInput.form).find('input[type="submit"]').removeClass('disabled');
			$(curInput.form).find('input[type="submit"]')[0].disabled = false;
		}else{
			$(curInput.form).find('input[type="submit"]').addClass('disabled');
			$(curInput.form).find('input[type="submit"]')[0].disabled = true;
		}
	}

	function validPWD(){
		var confPwd = $('input[name="confpwd"]')[0];
		var pwd = $('input[name="pwd"]')[0];

		if(pwd.value.trim() === confPwd.value.trim() ){
			pwd.previousElementSibling.firstElementChild.classList.add('hidden');

			confPwd.previousElementSibling.firstElementChild.classList.add('hidden');
			confPwd.previousElementSibling.lastElementChild.classList.remove('hidden');

			return true;
		}

		pwd.previousElementSibling.firstElementChild.classList.add('hidden');

		confPwd.previousElementSibling.firstElementChild.classList.remove('hidden');
		confPwd.previousElementSibling.lastElementChild.classList.add('hidden');

		return false;
	}

	// Subsciption Form Input Validation
	$('input:not([type="submit"]):not([name="email"]):required').on('input', function(){validateInputs($(this)[0]);});

	$('input[name="pwd"]').on('input', validPWD);
	$('input[name="confpwd"]').on('input', validPWD);


	// Dashboard Functions
	$('.new-project').on('click', function(){
		var data = {'action' : 'newProject'};
		jQuery.get('dashboard.php', data, function(response){
			$output.empty();
			$output.append(response);
			$('#output .panel-body')[0].style.padding = 0;
		});
	});
	// Admin Functions
	$('.view-applicants').on('click', function(){
		var data = {'action' : 'viewApplicants'};
		jQuery.get('dashboard.php', data, function(response){
			$output.empty();
			$output.append(response);

		});
	});
	$('.new-official').on('click', function(){
		var data = {'action' : 'newOfficial'};
		jQuery.get('dashboard.php', data, function(response){
			$output.empty();
			$output.append(response);

		});
	});
	$('.view-officials').on('click', function(){
		var data = {'action' : 'viewOfficials'};
		jQuery.get('dashboard.php', data, function(response){
			$output.empty();
			$output.append(response);

		});
	});
	$('.app-settings').on('click', function(){
		var data = {'action' : 'viewAppSettings'};
		jQuery.get('dashboard.php', data, function(response){
			$output.empty();
			$output.append(response);

		});
	});
});
