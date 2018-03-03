(function($) {

  //Tour Dates
  var $shareButtons = $('.share-show');

  $shareButtons.click( function(e){
        e.preventDefault();
        var url = $(this).parent().parent().find(".tickets-widget a").attr("href");

        $(this).hasClass("facebook") && shareOnFacebook(url),
        $(this).hasClass("twitter") && shareOnTwitter(url),
        $(this).hasClass("email") && shareOnEmail(url)
  });

  function shareOnFacebook(e) {
      "this" == e && (e = window.location.href);
      var t = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(e);
      popUpWindow(t, "Share on Facebook", "464", "210", "no", "center")
  }

  function shareOnTwitter(e) {
      "this" == e && (e = window.location.href);
      var t = "https://twitter.com/home?status=" + encodeURIComponent(e);
      popUpWindow(t, "Share on Twitter", "464", "210", "no", "center")
  }

  function shareOnEmail(e) {
      "this" == e && (e = window.location.href);
      var t = "mailto:?body=" + encodeURIComponent(e);
      popUpWindow(t, "Share By Email", "464", "210", "no", "center")
  }

  function popUpWindow(e, t, n, o, a, i) {
      "center" == i ? (LeftPosition = screen.width ? (screen.width - n) / 2 : 100,
      TopPosition = screen.height ? (screen.height - o) / 2 : 100) : ("center" != i && "random" != i || null == i) && (LeftPosition = 0,
      TopPosition = 20),
      settings = "width=" + n + ",height=" + o + ",top=" + TopPosition + ",left=" + LeftPosition + ",scrollbars=" + a + ",location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no",
      win = window.open(e, t, settings)
  }

})(jQuery);
