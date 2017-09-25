$(document).ready(() => {
    	$("#active").click((event) => {
	    $('.thread.closed').addClass('hidden');
		$('.thread.active').removeClass('hidden');
	    event.preventDefault();
		return false;
	});
	
	$("#closed").click((event) => {
	    $('.thread.active').addClass('hidden');
		$('.thread.closed').removeClass('hidden');
	    event.preventDefault();
		return false;
	});
	
	$("#need_replies").click((event) => {
	    $('.thread').addClass('hidden');
		$('.thread.need_replies').removeClass('hidden');
	    event.preventDefault();
		return false;
	});
	
	$("#total").click((event) => {
		$('.thread').removeClass('hidden');
	    event.preventDefault();
		return false;
	});
});