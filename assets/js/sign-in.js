$(document).ready(async function () {
  const admin = await fetchData("../api/auth.php");
  if (admin.length == 0)
    $("#registrasiElm").html(
      '<div class="alert alert-primary">Administrator tidak ditemukan. Silahkan <a href="registrasi.php">registrasi</a> terlebih dahulu.</div>'
    );
  else $("#registrasiElm").html("");

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
      url: "../api/auth.php?type=login",
      data: {
        username: username.val(),
        password: password.val(),
        remember: remember.prop("checked"),
      },
      method: "POST",
    });
    if (!res) {
      toggleButton($(this), "Login");
      return;
    }
    toggleButton($(this), "Mengalihkan...", true);
    toast(
      "Login berhasil, mengalihkan ke halaman panel...",
      "success",
      "",
      3000
    );
    setTimeout(() => {
      window.open("../panel/manage.php", "_self");
    }, 3000);
  });
});
