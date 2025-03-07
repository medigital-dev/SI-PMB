$(document).ready(function () {
  let $header = $(".sticky-top");
  let isDragging = false;

  function hideHeader() {
    $header.addClass("hide-header");
  }

  function showHeader() {
    $header.removeClass("hide-header");
  }

  // Deteksi scroll
  $(window).on("scroll", function () {
    isDragging = true;

    // Jika scroll ke paling atas, munculkan header
    if ($(window).scrollTop() === 0) {
      showHeader();
    } else {
      hideHeader();
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
    if ($(e.target).closest("#mainHeader").length) {
      return; // Jika klik di dalam header, tidak ada efek
    }

    if (!isDragging) {
      showHeader(); // Jika klik/tap di luar header, tampilkan header
    }
  });

  // Sembunyikan header saat halaman dimuat pertama kali
  hideHeader();
});
