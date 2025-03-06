$(document).ready(function () {
  $("#btnSignIn").on("click", async function (e) {
    e.preventDefault();
    const username = $("#username");
    const password = $("#password");
    const remember = $("#remember");
    if (!username.val().trim() || !password.val().trim()) {
      if (!username.val().trim()) username.addClass("is-invalid");
      else username.removeClass("is-invalid");
      if (!password.val().trim()) password.addClass("is-invalid");
      else password.removeClass("is-invalid");
      toast("Username dan Password harus diisi.", "error", "", 0);
      return;
    }

    $(".is-invalid").removeClass("is-invalid");
    toggleButton($(this), "Login...");

    const res = await fetchData({
      url: "/api/auth.php?type=login",
      data: {
        username: username.val(),
        password: password.val(),
        remember: remember.prop("checked"),
      },
      method: "POST",
    }).catch((err) => {
      toast(err.responseJSON.message, "error");
      toggleButton($(this), "Login");
      return false;
    });
    if (!res) return;
    toggleButton($(this), "Mengalihkan...", true);
    toast(
      "Login berhasil, mengalihkan ke halaman panel...",
      "success",
      "",
      3000
    );
    setTimeout(() => {
      window.open("/panel/manage.php");
    }, 3000);
  });
});
