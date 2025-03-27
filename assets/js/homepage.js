$(document).ready(function () {
  Fancybox.bind("[data-fancybox]");

  counterInner();

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

  const tabelForumPublic = $("#tabelForumPublic").DataTable({
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
      url: "/api/forum.php",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
        className: "w-100",
        render: (data, type, rows, meta) => {
          return (
            '<p class="mb-1">' +
            rows.isi +
            "</p>" +
            '<div class="d-flex justify-content-between">' +
            '<span class="text-muted small"><i class="bi bi-calendar-date-fill me-1"></i>' +
            tanggal(rows.tanggal, "d F Y H:i WIB") +
            " - " +
            rows.nama +
            "</span>" +
            "<div>" +
            '<a class="text-decoration-none btnDetailForumPublic" data-id="' +
            data +
            '" type="button"><i class="bi bi-chat-fill me-1"></i>' +
            rows.balasan +
            " Balasan</a>" +
            "</div></div>"
          );
        },
      },
    ],
  });

  tabelForumPublic.on("draw", function () {
    $(".btnDetailForumPublic").on("click", async function () {
      const id = $(this).data("id");
      const html = await fetchData({
        url: "/panel/detail-forum.php?id=" + id,
        dataType: "html",
      });
      $("#idIndukPublic").val(id);
      $("#jawaban").html(html);
      $("#modalDetailForumPublic").modal("show");

      $(".btnBalasDiskusi").on("click", async function () {
        const id = $(this).data("id");
        $("#idForumPublic").val(id);
        const data = await fetchData("/api/forum.php?id=" + id);
        if (!data) return;
        const code = "@" + data.nama + ": ";
        $("#pertanyaanAndaBalasan").val(code).focus();
        $("#collapse-balas").collapse("show");
      });
    });
  });

  $("#btnKirimBalasan").on("click", async function () {
    const induk = $("#idIndukPublic");
    const parent = $("#idForumPublic");
    const nama = $("#namaAndaBalasan");
    const isi = $("#pertanyaanAndaBalasan");

    if (!nama.val().trim()) {
      nama.addClass("is-invalid");
      return;
    }
    $(".is-invalid").removeClass("is-invalid");

    const set = await fetchData({
      url: "/api/forum.php",
      data: {
        parent_id: parent.val(),
        isi: isi.val(),
        nama: nama.val(),
      },
      method: "POST",
    });
    if (!set) return;
    toast("Balasan anda berhasil di tambahkan.", "success");
    isi.val("");
    $("#collapse-balas").collapse("hide");
    tabelForumPublic.ajax.reload(null, false);
    $("#jawaban").html(
      '<div class="d-flex align-items-center">' +
        '<strong role="status">Loading...</strong>' +
        '<div class="spinner-border spinner-border-sm ms-auto" aria-hidden="true"></div>' +
        "</div>"
    );
    const html = await fetchData({
      url: "/panel/detail-forum.php?id=" + induk.val(),
      dataType: "html",
    });
    $("#jawaban").html(html);

    $(".btnBalasDiskusi").on("click", async function () {
      const id = $(this).data("id");
      $("#idForumPublic").val(id);
      const data = await fetchData("/api/forum.php?id=" + id);
      if (!data) return;
      const code = "@" + data.nama + ": ";
      $("#pertanyaanAndaBalasan").val(code).focus();
      $("#collapse-balas").collapse("show");
    });
  });

  // $("#pertanyaanAnda").summernote({
  //   height: 200,
  //   placeholder: "Pertanyaan anda",
  //   dialogsInBody: true,
  //   toolbar: [
  //     ["style", ["bold", "italic", "underline"]],
  //     ["insert", ["link", "file"]],
  //     ["view", ["fullscreen", "help"]],
  //   ],
  //   callbacks: {
  //     onFileUpload: (file) => {
  //       for (let i = 0; i < file.length; i++) {
  //         uploadMedia(file[i], "#pertanyaanAnda");
  //       }
  //     },
  //     onMediaDelete: (file) => deleteMedia(file[0]),
  //   },
  // });

  // $("#pertanyaanAndaBalasan").summernote({
  //   height: 100,
  //   placeholder: "Pertanyaan anda",
  //   dialogsInBody: true,
  //   toolbar: [
  //     ["style", ["bold", "italic", "underline"]],
  //     ["insert", ["link", "file"]],
  //     ["view", ["fullscreen", "help"]],
  //   ],
  //   callbacks: {
  //     onFileUpload: (file) => {
  //       for (let i = 0; i < file.length; i++) {
  //         uploadMedia(file[i], "#pertanyaanAndaBalasan");
  //       }
  //     },
  //     onMediaDelete: (file) => deleteMedia(file[0]),
  //   },
  // });

  $("#btnKirimPertanyaan").on("click", async function () {
    const nama = $("#namaAnda");
    const isiElm = $("#pertanyaanAnda");

    if (!nama.val().trim() || !isiElm.val().trim()) {
      if (!nama.val().trim()) nama.addClass("is-invalid");
      else nama.removeClass("is-invalid");
      if (!isiElm.val().trim()) isiElm.addClass("is-invalid");
      else isiElm.removeClass("is-invalid");

      toast("Nama dan pertanyaan wajib diisi.", "error");
      return;
    }
    $(".is-invalid").removeClass("is-invalid");
    toggleButton($(this), "Menyimpan...");
    const set = await fetchData({
      url: "/api/forum.php",
      data: {
        nama: nama.val(),
        isi: isiElm.val(),
      },
      method: "POST",
    });

    if (!set) {
      toggleButton($(this), "Kirim");
      return;
    }
    toast(
      "Pertanyaan anda telah disimpan dalam daftar. Silahkan cek secara berkala jawaban pertanyaan anda.",
      "success"
    );
    nama.val("");
    isiElm.val("");
    toggleButton($(this), "Kirim");
    tabelForumPublic.ajax.reload(null, false);
  });

  $("#cariForum").on("keyup", function () {
    tabelForumPublic.search($(this).val()).draw();
  });
});
