/*

	1. Fixed header
	2. Main slideshow
	3. Site search
	4. Owl Carousel
	5. Video popup
	6. Counter
	7. Contact form
	8. Back to top
  
*/


jQuery(function ($) {
   "use strict";

   $(window).on('load', function () {
      checkScreenSize();

       $(".phone").keydown(function (e) {
           // Allow: backspace, delete, tab, escape, enter and .
           if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
               // Allow: Ctrl/cmd+A
               (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
               // Allow: Ctrl/cmd+C
               (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
               // Allow: Ctrl/cmd+X
               (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
               // Allow: home, end, left, right
               (e.keyCode >= 35 && e.keyCode <= 39)) {
               // let it happen, don't do anything
               return;
           }
           // Ensure that it is a number and stop the keypress
           if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
               e.preventDefault();
           }
       });



       $("#newsletter-form").submit(function(event) {
           event.preventDefault();

           var $form        = $(this),
               $msg         = $form.find('.msg'),
               $submitBtn	 = $form.find('button[type=submit]');

           // Prevent double submission by disabling the submit button
           $submitBtn.html($submitBtn.data('sending')).attr('disabled', 'disabled');

           // Hide previous messages
           $msg.fadeOut(0);


           var dataString = 'state='+ state + '&lga='+ lga + '&farmer='+ farmer + '&agent='+ agent +'&project=' + project;


           // var fd=new FormData();
           // fd.append('state', state);
           // fd.append('lga', lga);
           // fd.append('farmer', farmer);
           // fd.append('agent', agent);

           if (state==""){
               $(".error-fld").html("Please select state").fadeIn(1200).delay(3000).fadeOut(1000);
           }else if (lga==""){
               $(".error-fld").html("Please select L.G.A").fadeIn(1200).delay(3000).fadeOut(1000);
           }else{
               var lgh=state+","+lga;
               // console.log(lgh);
               // console.log(farmer);
               // console.log(agent);

               $.ajax({
                   type: "POST",
                   url: "api/saveassign.php",
                   data: dataString,
                   cache: false,
                   beforeSend:function(){
                       btn.attr('disabled',true);
                   },
                   success: function(data) {
                       $(".loader-box").fadeOut(500);
                       if (data=='00000'){
                           alert("Agent Already Assigned");
                       }
                       else if (data=='01'){
                           $('#search').multiselect('refresh');
                           $('#search_to').multiselect('refresh');
                           $('#search').multiselect('destroy');
                           $('#search_to').multiselect('destroy');
                           $('#search').data('multiselect', null);
                           $('#search_to').data('multiselect', null);
                           $("#search").html('');
                           $("#search_to").html('');
                           alert("Farmer Assigned To Agents");
                           $('#lga_field').val(0);
                           $('#agent').val('');
                       }
                       else{
                           alert(data);
                       }
                       btn.attr('disabled',false);

                   },error: function (res,f,b){
                       $(".loader-box").fadeOut(500);
                       $("#mapper").html(" ");
                       alert(res+f+b);
                   }
               });
           }

           //mapmultipolygonmarker.php?loc=Niger,NG.NI.AA
       });

   });


   /* ----------------------------------------------------------- */
   /*  Mobile Menu
   /* ----------------------------------------------------------- */

   function checkScreenSize() {
      var newWindowWidth = $(window).width();
      if (newWindowWidth < 991) {
         $(".nav.navbar-nav li a").on("click", function () {
            $(this).parent("li").find(".dropdown-menu").slideToggle();
            $(this).find("i").toggleClass("fa-angle-down fa-angle-up");
         });
      } else {
         $(".nav.navbar-nav li a").on("click", function () {
            console.log('do nothing');
         });
      }
   }

   

   /* ----------------------------------------------------------- */
   /*  Main slideshow
   /* ----------------------------------------------------------- */

   $('#main-slide').carousel({
      pause: true,
      interval: 100000,
   });




   /* ----------------------------------------------------------- */
   /*  Site search
   /* ----------------------------------------------------------- */

   $('.nav-search').on('click', function () {
      $('.search-block').fadeIn(350);
      $('.nav-search').addClass('hide');
   });

   $('.search-close').on('click', function () {
      $('.search-block').fadeOut(350);
      $('.nav-search').removeClass('hide');
   });



   /* ----------------------------------------------------------- */
   /*  Owl Carousel
   /* ----------------------------------------------------------- */

   //Testimonial slide

   $("#testimonial-slide").owlCarousel({

      loop: false,
      autoplay: false,
      autoplayHoverPause: true,
      nav: true,
      margin: 0,
      dots: false,
      mouseDrag: true,
      touchDrag: true,
      slideSpeed: 500,
      navText: ["<i class='icon icon-left-arrow2'></i>", "<i class='icon icon-right-arrow2'></i>"],
      items: 1,
      responsive: {
         0: {
            items: 1
         },


         600: {
            items: 1
         }
      }

   });



   //Partners slide

   $("#partners-carousel").owlCarousel({

      loop: true,
      autoplay: false,
      autoplayHoverPause: true,
      nav: true,
      margin: -50,
      dots: false,
      mouseDrag: true,
      touchDrag: true,
      slideSpeed: 500,
      navText: ["<i class='icon icon-left-arrow2'></i>", "<i class='icon icon-right-arrow2'></i>"],
      items: 5,
      responsive: {
         0: {
            items: 2
         },
         600: {
            items: 3
         },
         1000: {
            items: 5,
         }
      }

   });
   //testimonial slide

   $(".testimonial-carousel").owlCarousel({

      loop: true,
      autoplay: false,
      autoplayHoverPause: true,
      nav: true,
      dots: false,
      mouseDrag: true,
      touchDrag: true,
      slideSpeed: 500,
      navText: ["<i class='icon icon-chevron-left'></i>", "<i class='icon icon-chevron-right'></i>"],
      items: 1,
      responsive: {
         0: {
            items: 1
         },
         600: {
            items: 1
         },
         1000: {
            items: 1,
         }
      }

   });
   //testimonial slide

   $(".testimonial-slide").owlCarousel({

      loop: true,
      autoplay: false,
      autoplayHoverPause: true,
      nav: true,
      dots: false,
      margin: 30,
      mouseDrag: true,
      touchDrag: true,
      smartSpeed: 900,
      nav: false,
      dots: true,
      navText: ["<i class='icon icon-left-arrow2'></i>", "<i class='icon icon-right-arrow2'></i>"],
      items: 3,
      responsive: {
         0: {
            items: 1
         },
         600: {
            items: 1
         },
         1000: {
            items: 3,
         }
      }

   });
   //testimonial slide

   $(".testimonial-classic-slider").owlCarousel({

      loop: true,
      autoplay: false,
      autoplayHoverPause: true,
      nav: true,
      dots: false,
      margin: 30,
      mouseDrag: true,
      touchDrag: true,
      smartSpeed: 900,
      nav: false,
      dots: false,
      navText: ["<i class='icon icon-left-arrow2'></i>", "<i class='icon icon-right-arrow2'></i>"],
      items: 3,
      responsive: {
         0: {
            items: 1
         },
         600: {
            items: 2
         },
         1000: {
            items: 3,
         }
      }

   });


   //Page slide

   $(".page-slider").owlCarousel({

      loop: true,
      animateOut: 'fadeOut',
      autoplay: false,
      autoplayHoverPause: true,
      nav: true,
      margin: 0,
      dots: false,
      mouseDrag: true,
      touchDrag: true,
      slideSpeed: 500,
      navText: ["<i class='icon icon-left-arrow2'></i>", "<i class='icon icon-right-arrow2'></i>"],
      items: 1,
      responsive: {
         0: {
            items: 1
         },
         600: {
            items: 1
         }
      }

   });

   //Page slide
   $(".featured-cases-slide").owlCarousel({

      loop: false,
      animateOut: 'fadeOut',
      autoplay: false,
      autoplayHoverPause: true,
      nav: true,
      margin: 0,
      dots: false,
      mouseDrag: true,
      touchDrag: true,
      slideSpeed: 500,
      navText: ["<i class='icon icon-left-arrow2'></i>", "<i class='icon icon-right-arrow2'></i>"],
      items: 1,
      responsive: {
         0: {
            items: 1
         },
         600: {
            items: 1
         }
      }

   });


   //Team slide

   $("#team-slide").owlCarousel({

      loop: false,
      animateOut: 'fadeOut',
      nav: true,
      navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
      margin: 20,
      dots: false,
      mouseDrag: true,
      touchDrag: true,
      slideSpeed: 800,
      items: 4,
      responsive: {
         0: {
            items: 1
         },
         480: {
            items: 2
         },
         1000: {
            items: 4,
            loop: false
         }
      }

   });


   /* ----------------------------------------------------------- */
   /*  Counter
   /* ----------------------------------------------------------- */

   $('.counterUp').counterUp({
      delay: 10,
      time: 1000
   });



   /* ----------------------------------------------------------- */
   /*  Contact form
   /* ----------------------------------------------------------- */

   $('#contact-form').submit(function () {

      var $form = $(this),
         $error = $form.find('.error-container'),
         action = $form.attr('action');

      $error.slideUp(750, function () {
         $error.hide();

         var $name = $form.find('.form-control-name'),
            $email = $form.find('.form-control-email'),
            $subject = $form.find('.form-control-subject'),
            $message = $form.find('.form-control-message');

         $.post(action, {
               name: $name.val(),
               email: $email.val(),
               subject: $subject.val(),
               message: $message.val()
            },
            function (data) {
               $error.html(data);
               $error.slideDown('slow');

               if (data.match('success') != null) {
                  $name.val('');
                  $email.val('');
                  $subject.val('');
                  $message.val('');
               }
            }
         );

      });

      return false;

   });

   /* ----------------------------------------------------------- */
   /*  Back to top
   /* ----------------------------------------------------------- */

   $(window).scroll(function () {
      if ($(this).scrollTop() > 50) {
         $('#back-to-top').fadeIn();
      } else {
         $('#back-to-top').fadeOut();
      }
   });
   // scroll body to 0px on click
   $('#back-to-top').click(function () {
      $('#back-to-top').tooltip('hide');
      $('body,html').animate({
         scrollTop: 0
      }, 800);
      return false;
   });

   $('#back-to-top').tooltip('hide');


    //Modal
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })

    var rcode = randomString(4).toUpperCase();
    $('#refcode').html(rcode);
    $('#rcode').val(rcode)



});

function randomString(length) {
    return Math.round((Math.pow(36, length + 1) - Math.random() * Math.pow(36, length))).toString(36).slice(1);
}
