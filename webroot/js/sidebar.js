$(document).ready(function(){
  "use strict";

$('.sidebar-toggle').on('click', function(){
    $('.app').toggleClass('collapsed');
  });

const treeviewMenu = $('.app-menu');

$("[data-toggle='submenu']").click(function(event) {
		event.preventDefault();
		if(!$(this).parent().hasClass('is-expanded')) {
			treeviewMenu.find("[data-toggle='submenu']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});

$("[data-toggle='submenu.'].is-expanded").parent().toggleClass('is-expanded');

});
