var constants = {
  'navLinkActiveColor'  : '#149B60',
  'progBarColor'        : '#149B60',
  'scrollSpeed'         : 750
};

$(function() {
  // If it's a POST request, scroll to the contact form
  if ( $('#form-submitted').length ) { 
    scrollToId('#contact');
  }

  // If the window is scrolled to the top: color the "home" nav element.
    // This is usually taken care of on scroll events
  if ($(window).scrollTop() === 0) {
    $('[data-id="home"]').css('color', constants.navLinkActiveColor);
  } 

  setAllLineHeights();
  bindEventHandlers();
});

function setAllLineHeights() {
  setLineHeight('work');
  setLineHeight('education');
  setLineHeight('projects');
}

function bindEventHandlers() {
  bindProgbarAppearEvent();
  bindPageSectionAppearEvent();
  bindCollapseBtnEvent();

  // Make sure the lines that goes through the .collapse-btn elements
    // looks good during window rezising
  $(window).resize(function() {
    setAllLineHeights();
  });

  // .scroll-links are navbar elements.
    // When clicked => scroll to corresponding page section
  $('.scroll-link').click(function(event) {
    event.preventDefault();
    $(this).blur(); // remove bootstraps default :focus effect
    var sectionID = $(this).attr('data-id');
    scrollToId('#' + sectionID);
  });

  // Navigation toggle for mobile devices
  $('#nav-toggle').click(function(event) {
    event.preventDefault();
    $('#main-nav').toggleClass('open');
  });

  $('#languageBtn').click(function(event) {
    changeLanguage($(this).html());
  });
}

function changeLanguage(lang) {
  if (lang == 'Norsk') {
    window.location.assign('?lang=' + 'no');
  } else {
    window.location.assign('?lang=' + 'en');
  }
}

function isCurrentSection(section) {
  var offset = 100;
  var position = section.offset().top - offset;
  var windowPosition = $(window).scrollTop();

  return  windowPosition > position;
}

function bindPageSectionAppearEvent() {
  var sections = $('.page-section').toArray().reverse();

  var id, navLink, previousNavLink;

  $('.page-section').appear(); // Initialize appear plugin on .page-section elements

  $(document.body).on('appear', '.page-section', function(event, $elements) {
    id = $(this).attr('id');
    navLink = $('[data-id="' + id + '"');

    if ( navLink !== previousNavLink && isCurrentSection($(this)) ) {
      resetNavLinkColors();
      navLink.css('color', constants.navLinkActiveColor);
      previousNavLink = navLink;
    }
  });
}

function resetNavLinkColors() {
  // Remove all colors that are set by this script only (not in css)
  $('.navbar-nav li a').css('color', '');
}

function bindProgbarAppearEvent() {
  var el, id;
  var progBarValues = {
    'backend'         : {
          val     : 0.6,
          initiated : false
      },
    'frontend'      : {
          val     : 0.5,
          initiated : false
      }
  };

  $('.progbar').appear(); // Initialize appear plugin on .progbar elements

  $(document.body).on('appear', '.progbar', function(event, $elements) {
    el = $(this);
    id = el.parent().attr('id');

    if ( !progBarValues[id].initiated ) {
      progBarValues[id].initiated = true;

      // Initiate circleProgress plugin animation
      el.circleProgress({
        value     : progBarValues[id].val,
        fill      : { color     : constants.progBarColor },
        animation : { duration  : 2000 }

      }).on('circle-animation-progress', function(event, progress, stepVal) {
        $(this).find('strong').html(parseInt(100 * stepVal) + '<i>%</i>');
      });
    }
  });
}

function scrollToId(id) {
  var offset = 50;
  var targetOffset = $(id).offset().top - offset;
  var mainNav = $('#main-nav');

  $('html, body').animate({scrollTop:targetOffset}, constants.scrollSpeed);

  // Close navigation menu on mobile devices
  if (mainNav.hasClass('open')) {
    mainNav.css('height', '1px').removeClass('in').addClass('collapse');
    mainNav.removeClass('open');
  }
}

function bindCollapseBtnEvent() {
  $('.collapse-btn').click(function(event) {
    event.preventDefault();

    var collapseDiv = $(this).parent().next().children('.collapse');

    if ( (collapseDiv.length) ) { // If not in the middle of animation
      var parentId = $(this).parents('.page-section').attr('id');
      var span = $(this).children('span');

      collapseDiv.collapse('toggle');

      span.toggleClass('glyphicon-plus');
      span.toggleClass('glyphicon-minus');

      // Continually reset the height of the vertical line that goes 
        // through the .collapse-btn elements during the collapse animation
      var interval = setInterval(function() {
        setLineHeight(parentId);
      }, 30);
      setTimeout(function() {
        clearInterval(interval);
      }, 350);
    }
  });
}

function setLineHeight(divId) {
  // Sets the height of the vertical line that goes through 
    // the .collapse-btn elements

  var firstBtn = $('#' + divId + ' .row:nth-of-type(1) .collapse-btn');
  var lastBtn = $('#' + divId + ' .row:last-of-type .collapse-btn');

  var top = firstBtn.offset().top;
  var bottom = lastBtn.offset().top;

  var height = bottom - top;

  // To avoid endless <style> tags:
  $('#' + divId + 'custom').remove();

  // Add style tag to document
  $('<style id="' + divId + 'custom">' + '#' + divId + ' .row:nth-child(2) .collapse-btn:after{height: ' + 
    height + 'px}</style>').appendTo('head');
}