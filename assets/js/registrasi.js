$(document).ready(function () {
  $("#btnRegistrasi").on("click", async function (e) {
    e.preventDefault();
    const username = $("#username");
    const password = $("#password");
    const password2 = $("#password2");
    const name = $("#name");

    if (
      !username.val().trim() ||
      !password.val().trim() ||
      !password2.val().trim() ||
      !name.val().trim()
    ) {
      if (!username.val().trim()) username.addClass("is-invalid");
      else username.removeClass("is-invalid");

      if (!password.val().trim()) password.addClass("is-invalid");
      else password.removeClass("is-invalid");

      if (!password2.val().trim()) password2.addClass("is-invalid");
      else password2.removeClass("is-invalid");

      if (!name.val().trim()) name.addClass("is-invalid");
      else name.removeClass("is-invalid");

      toast("Lengkapi form terlebih dahulu", "error");
      return;
    }

    if (password.val() !== password2.val()) {
      $(".password").addClass("is-invalid");
      toast("Password tidak sama.", "error");
      return;
    }

    toggleButton($(this), "Melakukan registrasi...");
    const user = await fetchData({
      url: "/api/auth.php?type=registrasi",
      data: {
        username: username.val(),
        password: password.val(),
        name: name.val(),
      },
      method: "POST",
    });
    if (!user) {
      toggleButton($(this), "Registrasi");
      return;
    }
    toast({
      title: "Registrasi Sukses.",
      icon: "success",
      message:
        "Username: <strong>" +
        username.val() +
        "</strong> berhasil diregistrasi.",
      delay: 3000,
    });
    toggleButton($(this), "Mengarahkan ke Login...", true);
    setTimeout(() => {
      window.location.href = "/auth/login.php";
    }, 3000);
  });
});
