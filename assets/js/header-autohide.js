$(document).ready(function () {
  let $header = $(".sticky-top");
  let isDragging = false;

  function hideHeader() {
    $header.addClass("hide-header");
  }

  function showHeader() {
    $header.removeClass("hide-header");
  }

  // Saat halaman dimuat, cek posisi scroll
  if ($(window).scrollTop() === 0) {
    showHeader(); // Munculkan jika di atas
  } else {
    hideHeader(); // Jika tidak di atas, sembunyikan
  }

  // Deteksi scroll
  $(window).on("scroll", function () {
    isDragging = true;

    if ($(window).scrollTop() === 0) {
      showHeader(); // Jika di paling atas, tampilkan header
    } else {
      hideHeader(); // Jika tidak di atas, sembunyikan
    }

    clearTimeout($.data(this, "scrollTimer"));
    $.data(
      this,
      "scrollTimer",
      setTimeout(function () {
        isDragging = false;
      }, 200)
    ); // Deteksi berhenti drag dalam 200ms
  });

  // Tap/klik di luar header hanya menampilkan header
  $(document).on("click touchstart", function (e) {
    if ($(e.target).closest(".sticky-top").length) {
      return; // Jika klik di dalam header, tidak ada efek
    }

    if (!isDragging) {
      showHeader(); // Jika klik/tap di luar header, tampilkan header
    }
  });
});
