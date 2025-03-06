$(document).ready(function () {
  Fancybox.bind("[data-fancybox]");

  $("#showPass").on("change", function () {
    if ($(this).is(":checked")) $(".password").attr("type", "text");
    else $(".password").attr("type", "password");
  });
});
