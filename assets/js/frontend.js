(function ($) {

	var firstLoad = false;
	var oneFourthHeight = $(document).height() / 4;
	var popup = $(".awesome_popup_wrapper");

	$(document).ready(function () {
		$(window).scroll(function () {
			if ($(window).scrollTop() > oneFourthHeight) {
				if (!firstLoad) {
					popup.addClass("active_awesome_popup");
					$("body").css("overflow", "hidden");
				}
			}
		});
	});

	$(document).on("click", ".close_awesome_popup", function () {
		popup.css("display", "none");
		popup.removeClass("active_awesome_popup");
		$("body").css("overflow", "initial");
		window.scrollTo(0, oneFourthHeight);
		firstLoad = true;
	});

})(jQuery);
