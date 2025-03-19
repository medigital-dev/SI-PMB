$(document).ready(function () {
  $("#showPass").on("change", function () {
    if ($(this).is(":checked")) $(".password").attr("type", "text");
    else $(".password").attr("type", "password");
  });
});
