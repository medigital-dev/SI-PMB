$(document).ready(function () {
  counterInner();

  $(".owl-carousel").owlCarousel({
    items: 1,
    autoplay: true,
    autoplayTimeout: 5000,
    loop: true,
    autoplayHoverPause: true,
  });

  const tableUnduhan = $("#tabelUnduhan").DataTable({
    dom: '<"mb-2"t><"d-flex justify-content-start"p>',
    lengthMenu: [
      [5, 10, 25, 50, 100, -1],
      [5, 10, 25, 50, 100, "All"],
    ],
    responsive: true,
    ordering: false,
    processing: true,
    pagingType: "simple",
    ajax: {
      url: "/api/berkas.php?s=1",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
        render: (data, type, rows, meta) => {
          return `<div class="d-flex gap-3" aria-current="true">
            <span class="flex-shrink-0">${getFileIcon(rows.type)}</span>
      <div class="d-flex gap-2 w-100 justify-content-between">
        <div>
          <h6 class="mb-0">${rows.title}</h6>
          <p class="mb-0 opacity-75 small">[${fileSize(rows.size)}] ${
            rows.filename
          }</p>
        </div>
        <a href="${rows.src}" download target="_blank" title="Unduh ${
            rows.title
          }"><i class="bi bi-cloud-arrow-down-fill"></i></a>
      </div>
    </div>`;
        },
      },
    ],
  });

  const tableInfo = $("#tabelInfoPublic").DataTable({
    dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
    lengthMenu: [
      [5, 10, 25, 50, 100, -1],
      [5, 10, 25, 50, 100, "All"],
    ],
    responsive: true,
    ordering: false,
    processing: true,
    pagingType: "simple",
    ajax: {
      url: "/api/info.php",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
        className: "w-100",
        render: (data, type, rows, meta) => {
          return (
            '<a class="text-decoration-none" role="button" data-bs-toggle="collapse" href="#collapse-' +
            rows.id +
            '"><p class="m-0 h6 dropdown-toggle">' +
            rows.judul +
            "</p></a>" +
            '<span class="text-muted small">' +
            tanggal(rows.tanggal) +
            "</span>" +
            '<div class="collapse" id="collapse-' +
            rows.id +
            '"><hr class="my-2">' +
            rows.isi +
            "</div>"
          );
        },
      },
    ],
  });

  $("#cariInfo").on("keyup", (e) => {
    const keyword = e.target.value;
    if (keyword !== "") {
      $(".collapse").collapse("show");
      tableInfo.search(keyword).draw();
    } else $(".collapse").collapse("hide");
  });
});
