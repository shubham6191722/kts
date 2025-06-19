/*************************************

All custom js files contents are below
**************************************
* 00. Loader
* 01. Company Brand Carousel
* 02. Client Story testimonial
* 03. Bootstrap wysihtml5 editor
* 04 Grid Slider
* 05 Grid Slider 2
* 06. Tab Js
* 07. Add field Script
* 08 Add Field
* 09 Background Image
* 10 City Select
* 11 Styles
**************************************/

(function($){
"use strict";


	$(window).on('load', function() {
		$('.stock-facts li span').counterUp({
			delay: 100,
			time: 800
		});
	});

	/*--- Company Brands --*/
	$("#company-brands").owlCarousel({
		items:5,
		itemsDesktop:[1199,4],
		itemsDesktopSmall:[979,3],
		itemsTablet:[768,3],
		itemsMobile:[480,2],
		pagination: false,
		navigation:false,
		navigationText:["",""],
		autoPlay:true
	});
	
	/*--- Client Story testimonial --*/
	$("#client-testimonial-slider").owlCarousel({
		items:3,
		itemsDesktop:[1199,3],
		itemsDesktopSmall:[979,2],
		itemsTablet:[768,1],
		pagination: false,
		navigation:false,
		navigationText:["",""],
		autoPlay:true
	});
	
	/*---Bootstrap wysihtml5 editor --*/	
	$('.textarea').wysihtml5();
	
	/*------ Grid Slider ----*/
	$('.grid-slide').slick({
	  slidesToShow:3,
	  arrows:false,
	  autoplay:true,
	  infinite: true,
	  responsive: [
		{
		  breakpoint: 768,
		  settings: {
			arrows:false,
			centerMode: true,
			slidesToShow:2
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			arrows: false,
			centerPadding: '0px',
			slidesToShow: 1
		  }
		}
	  ]
	});
	
	/*------ Grid Slider ----*/
	$('.grid-slide-2').slick({
	  slidesToShow:2,
	  arrows:false,
	  autoplay:true,
	  infinite: true,
	  responsive: [
		{
		  breakpoint: 768,
		  settings: {
			arrows:false,
			centerMode: true,
			slidesToShow:1
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			arrows: false,
			centerPadding: '0px',
			slidesToShow: 1
		  }
		}
	  ]
	});
	
	/*---Tab Js --*/
	$("#simple-design-tab a").on('click', function(e){
		e.preventDefault();
		$(this).tab('show');
	});
	
	/*-----Add field Script------*/
	$('.extra-field-box').each(function() {
    var $wrapp = $('.multi-box', this);
    $(".add-field", $(this)).on('click', function() {
        $('.dublicat-box:first-child', $wrapp).clone(true).appendTo($wrapp).find('input').val('').focus();
    });
    $('.dublicat-box .remove-field', $wrapp).on('click', function() {
        if ($('.dublicat-box', $wrapp).length > 1)
            $(this).parent('.dublicat-box').remove();
		});
	});
	
	//   Background image ------------------
		var a = $(".bg");
		a.each(function (a) {
			if ($(this).attr("data-bg")) $(this).css("background-image", "url(" + $(this).data("bg") + ")");
		});
		
		$('.slideshow-container').slick({
        slidesToShow: 1,
        autoplay: true,
        autoplaySpeed:2000,
        arrows: false,
        fade: true,
        cssEase: 'ease-in',
        infinite: true,
        speed:2000
    });
	
	// City Select
	$('#choose-city').select2();
	
	// Category Select
	$('#choose-category').select2();
	
	// Category Select
	$('#choose-category2').select2();
	
	// Category Select
	$('#r-category').select2({
		placeholder: "Choose Region...",
		allowClear: true
	});
	
	// Category Select
	$('#s-category').select2({
		placeholder: "Choose Category...",
		// allowClear: true
	});
	
	// Levels
	$('#levels').select2();
	
	// Types
	$('#types').select2();

	$('.select2').select2({
		placeholder: "Please Select...",
	});
	
	// --------- Job List --------
	var options = {
		url: "./assets/js/resources/joblist.json",

		getValue: "name",

		list: {
			match: {
				enabled: true
			}
		}
	};
	
	// --------- Companies --------
	var options = {
		url: "./assets/js/resources/companies.json",

		getValue: "name",

		list: {
			match: {
				enabled: true
			}
		}
	};

	$("#companies").easyAutocomplete(options);
	
	// --------- Location --------
	var options = {
		url: "./assets/js/resources/location.json",

		getValue: "name",

		list: {
			match: {
				enabled: true
			}
		}
	};

	$("#location").easyAutocomplete(options);
		
	// Styles ------------------
    function csselem() {
        $(".slideshow-container .slideshow-item").css({
            height: $(".slideshow-container").outerHeight(true)
        });
        $(".slider-container .slider-item").css({
            height: $(".slider-container").outerHeight(true)
        });
    }
    csselem();	
			
	})(jQuery);


	function show_toastr(type, title_msg, title_sub_msg) {
        toastr.options.closeButton = true;
        toastr.options.progressBar = true;
        toastr.options.timeOut = '5000';

        if (type == 'success') {
            toastr.success(title_sub_msg, title_msg);
        } else if (type == 'info') {
            toastr.info(title_sub_msg, title_msg);
        } else if (type == 'warning') {
            toastr.warning(title_sub_msg, title_msg);
        } else if (type == 'error') {
            toastr.error(title_sub_msg, title_msg);
        }
    }


	var tech = getUrlParameter('login_action');
	if(tech == "candidate"){
		$('#login_client').removeClass('active');
		$("#client").removeClass('in active');

		$('#login_candidate').addClass('active');
		$("#candidate").addClass('in active');
	}

	if(tech == "client"){
		$('#login_candidate').removeClass('active');
		$("#candidate").removeClass('in active');
		
		$('#login_client').addClass('active');
		$("#client").addClass('in active');
	}

	function getUrlParameter(sParam) {
		var sPageURL = window.location.search.substring(1),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			}
		}
		return false;
	};

	$(".modal-close").click(function(){
		var modal_id = $(this).attr('data-id');
		$('#'+modal_id).modal('toggle');
	});
	$(".open-model").click(function(){
		var modal_id = $(this).attr('data-id');
		$('#'+modal_id).modal('toggle');
	});

	$('body').on('click', '#register_btn', function() {
		setTimeout(function () {
			$('#r_categoryid').select2({
				placeholder: "Please Select...",
				dropdownParent: $('#register'),
			});
			$('#r_c_s_categoryid').select2({
				placeholder: "Please Select...",
				dropdownParent: $('#register'),
			});
			$('#c_loction').select2({
				placeholder: "Please Select...",
				dropdownParent: $('#register'),
			});
			$('#r_workbasepreference').select2({
				placeholder: "Please Select...",
				dropdownParent: $('#register'),
			});
			$('#r_noticeperiod').select2({
				placeholder: "Please Select...",
				dropdownParent: $('#register'),
			});
		}, 200);
		
	});

	$('body').on('click', '#register_btn_1', function() {
		setTimeout(function () {
			$('#r_categoryid').select2({
				placeholder: "Please Select...",
				dropdownParent: $('#register'),
			});
			$('#r_c_s_categoryid').select2({
				placeholder: "Please Select...",
				dropdownParent: $('#register'),
			});
			$('#c_loction').select2({
				placeholder: "Please Select...",
				dropdownParent: $('#register'),
			});
			$('#r_workbasepreference').select2({
				placeholder: "Please Select...",
				dropdownParent: $('#register'),
			});
			$('#r_noticeperiod').select2({
				placeholder: "Please Select...",
				dropdownParent: $('#register'),
			});
		}, 200);
		
	});

	var window_width = $(window).width();

	$('#job_detail_sub_2 ul li a').on('click', function (e) {
		var classname = $(this).attr('data-class');

		var header_hight = $('#job_detail_sub_2').height();
		header_hight = parseInt(header_hight) + 30;
		
		var from_top = jQuery('#'+classname).offset().top;
		from_top = parseInt(from_top) - header_hight;
		  
		if (!$('#job_detail_sub_2').hasClass('fixed')) {
			from_top = parseInt(from_top);
		} else {

		}

		var body = $("html, body");
		setTimeout(function() {
			body.animate({
					scrollTop: from_top
			}, 500);
		}, 500);
	});

	var isscroll = 0;
	if ($("#job_detail_sub_2").length > 0) {
		var hieghtThreshold = $("#job_detail_sub_2").offset().top;
		isscroll = 1;
	}
	if (isscroll == 1) {
		$(window).scroll(function () {
			var scroll = $(window).scrollTop();
			if (scroll >= hieghtThreshold) {
				$('#job_detail_sub_2').addClass('fixed');
				$('#job_detail').addClass('add-fixed');
			} else {
				$('#job_detail_sub_2').removeClass('fixed');
				$('#job_detail').removeClass('add-fixed');
			}
		});
	}