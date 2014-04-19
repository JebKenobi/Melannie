/*---------------------------------
	Mvb row full height
----------------------------------*/
;(function($, window, undefined ) {
	'use strict';
	
	var rowFullHeightPositions = new Array();
	var prevWindowScrollTop = 0;
	var currentRow = '';
	var adminBar = 0;
	var autoScroll = false;
	
	var getRowFullHeightPositions = function() {
		rowFullHeightPositions = {};
		
		if ($('#wpadminbar').length > 0 ) {
			adminBar = parseInt($('body').css('padding-top'));
		}
		
		$('.mvb_container > section.row-wrapper').each(function(i, val) {
			var $this = $(this);
			var id = $this.attr('id');
			var offset = $this.offset();
			
			rowFullHeightPositions[id] = {
				top: Math.round(offset.top), 
				bottom: ($this.next().length > 0) ? Math.round($this.next().offset().top) : Math.round(offset.top + $this.height()),
				first: (i === 0) ? true : false,
				last: (i === $('section.row-wrapper').length-1) ? true : false
			};
		});
	}
	
	var setActiveRowFullHeight = function(fullHeightNav, e) {
		var windowScrollTop = $(window).scrollTop();
		var activeRowFullHigth = null;
		var activeRowFullHigthNav = null;
		
		if (adminBar > 0) {
			if (windowScrollTop >= 0 && windowScrollTop <= adminBar) {
				windowScrollTop = adminBar;
			}
		}
		
		var windowScrollTopNav = Math.ceil(windowScrollTop * 1.05);
		
		$.each(rowFullHeightPositions, function(i, val) {
			if ((val.top <= windowScrollTopNav) && (val.bottom > windowScrollTopNav)) {
				activeRowFullHigthNav = i;
				return false;
			}
		});
		
		if (activeRowFullHigthNav != null) {
			if (window.mvb_row_navigation != undefined && true === mvb_row_navigation) {
				fullHeightNav.find('a').removeClass('active');
				$('#a-'+activeRowFullHigthNav).addClass('active');
			}
		}
		
		$.each(rowFullHeightPositions, function(i, val) {
			if ((val.top <= windowScrollTop) && (val.bottom > windowScrollTop)) {
				activeRowFullHigth = i;
				return false;
			}
		});
		
		if (activeRowFullHigth != null) {
			currentRow = activeRowFullHigth;
		}
		
		if (window.mvb_scroll_navigation != undefined && true === mvb_scroll_navigation) { console.log(autoScroll);
			if (e != undefined && false === autoScroll) {
				e.preventDefault();
				if (prevWindowScrollTop < windowScrollTop) { // down
					if (windowScrollTop > rowFullHeightPositions[currentRow].top 
							&& windowScrollTop - rowFullHeightPositions[currentRow].top > 50 
							&& windowScrollTop - rowFullHeightPositions[currentRow].top < 100) {
						autoScroll = true;
						if (false === rowFullHeightPositions[currentRow].last) {
							$('html, body').stop().animate({scrollTop: rowFullHeightPositions[currentRow].bottom}, 800, function() {
								var animateScrollTop = $(window).scrollTop();
								autoScroll = false;
								if (animateScrollTop === rowFullHeightPositions[currentRow].bottom) {
									return false;
								}
							});
						} else {
							autoScroll = false;
						}
					}
				} else { // up
					if (windowScrollTop < rowFullHeightPositions[currentRow].bottom
							&& rowFullHeightPositions[currentRow].bottom - windowScrollTop > 50 
							&& rowFullHeightPositions[currentRow].bottom - windowScrollTop < 100) {
						autoScroll = true;
						if (false === rowFullHeightPositions[currentRow].last) {
							$('html, body').stop().animate({scrollTop: rowFullHeightPositions[currentRow].top}, 800, function() {
								var animateScrollTop = $(window).scrollTop();
								autoScroll = false;
								if (animateScrollTop === rowFullHeightPositions[currentRow].top) {
									return false;
								}
							});
						} else {
							autoScroll = false;
						}
					}
				}
			}
		}
		
		prevWindowScrollTop = windowScrollTop;
	}
	
	var setRowFullHeight = function() {
		var windowHeight = $(window).height();
		
		if (windowHeight != undefined) {
			
			$('section.mvb-row-fullheight').each(function() {
				var $this = $(this);
				
				$this.css({height: 'auto'});
				
				var height = ($this.height() > windowHeight) ? $this.height() : windowHeight;
				
				$this.css({
					height: height,
					'min-height': windowHeight
				});
				
			});
		}
	};
	
	var addFullHeightNav = function() {
		var $fullHeightNav = $('<ul class="fullheight_nav"></ul>');
		
		$('.mvb_container > section.row-wrapper').each(function() {
			var $this = $(this);
			var id = 'rfh-'+Math.random().toString(36).substring(7);
			$this.attr('id', id);
			
			$fullHeightNav.append('<li><a id="a-'+id+'" href="#'+id+'">&nbsp;</a></li>');
		});
		
		getRowFullHeightPositions();
		
		if (window.mvb_row_navigation != undefined && true === mvb_row_navigation) {
			$('body').append($fullHeightNav);
			$fullHeightNav.css('margin-top', Math.round($fullHeightNav.height() / 2) * -1);
			
			$fullHeightNav.find('a').click(function() {
				var $this = $(this);
				var target_id = $(this).attr('href').replace('#', '');
				autoScroll = true;

				if (target_id != '') {
					var target_top = Math.round($('#'+target_id).offset().top);
					
					$('html, body').animate({scrollTop: target_top}, 800, function() {
						var animateScrollTop = $(window).scrollTop();
						if (target_top === animateScrollTop) {
							autoScroll = false;
						}
					});
				}

				return false;
			});
			
			setActiveRowFullHeight($fullHeightNav);
		}
		
		$(window).on("scroll", function(e) {
			setActiveRowFullHeight($fullHeightNav, e);
		});
	}
	
	$(document).ready(function(){
		var row_fullheight = $('.mvb_container .row-wrapper:first').hasClass('mvb-row-fullheight');
		
		if (row_fullheight) {
			$('.mvb_container .mvb-row-fullheight').addClass('mvb-row-fullheight-va');
			$('#header > .header-wrap:not(.header-hide)').addClass('header-hide');
		}

		setRowFullHeight();
		addFullHeightNav();
		$(window).on("load resize", setRowFullHeight);
	});
})(jQuery, window);
