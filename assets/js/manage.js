$(document).ready(function () {
  Fancybox.bind("[data-fancybox]");

  $("#isi").summernote({
    dialogsInBody: true,
    height: 200,
    toolbar: [
      ["misc", ["undo", "redo"]],
      ["style", ["bold", "italic", "underline", "clear"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["insert", ["link", "table", "file"]],
      ["view", ["fullscreen", "codeview", "help"]],
    ],
    callbacks: {
      onFileUpload: (file) => {
        for (let i = 0; i < file.length; i++) {
          uploadMedia(file[i]);
        }
      },
      onMediaDelete: (file) => deleteMedia(file[0]),
    },
  });

  const tabelTautan = $("#tabelTautan").DataTable({
    dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
    lengthMenu: [
      [5, 10, 25, 50, 100, -1],
      [5, 10, 25, 50, 100, "All"],
    ],
    responsive: {
      details: {
        renderer: DataTable.Responsive.renderer.listHiddenNodes(),
      },
    },
    ordering: false,
    processing: true,
    pagingType: "simple",
    ajax: {
      url: "../api/tautan.php",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
        className: "w-100",
        render: (data, type, rows, meta) => {
          const aktif = rows.aktif == 1 ? "checked" : "";
          const label = rows.aktif == 1 ? "Aktif" : "Non Aktif";
          const onMenu = rows.on_menu == 1 ? "checked" : "";
          const onMenuLabel = rows.on_menu == 1 ? "Aktif" : "Non Aktif";
          return (
            '<h6 class="mb-1">' +
            rows.title +
            "</h6>" +
            '<a href="' +
            rows.url +
            '" class="mb-1 small text-decoration-none" target="_blank">' +
            rows.url +
            "</a>" +
            '<div class="form-check form-switch">' +
            '<input class="form-check-input btnAktifTautan" data-id="' +
            data +
            '" type="checkbox" role="switch" id="' +
            data +
            '" ' +
            aktif +
            ">" +
            '<label class="form-check-label small text-muted" for="' +
            data +
            '">' +
            label +
            " pada Link Homepage</label>" +
            "</div>" +
            '<div class="form-check form-switch">' +
            '<input class="form-check-input btnOnMenuTautan" data-id="' +
            data +
            '" type="checkbox" role="switch" id="' +
            data +
            '" ' +
            onMenu +
            ">" +
            '<label class="form-check-label small text-muted" for="' +
            data +
            '">' +
            onMenuLabel +
            " pada Header Homepage</label>" +
            "</div>"
          );
        },
      },
      {
        data: "id",
        className: "text-center",
        width: "70px",
        render: (data, type, rows, meta) => {
          return (
            '<div class="btn-group btn-group-sm">' +
            '<button type="button" class="btn btn-danger btnHapusTautan" data-id="' +
            data +
            '" title="Hapus Tautan"><i class="bi bi-trash-fill"></i></button>' +
            "</div>"
          );
        },
      },
    ],
  });

  const tabelInformasi = $("#tabelInformasi").DataTable({
    dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
    lengthMenu: [
      [5, 10, 25, 50, 100, -1],
      [5, 10, 25, 50, 100, "All"],
    ],
    responsive: {
      details: {
        renderer: DataTable.Responsive.renderer.listHiddenNodes(),
      },
    },
    ordering: false,
    processing: true,
    pagingType: "simple",
    ajax: {
      url: "../api/info.php",
      dataSrc: "",
    },
    columns: [
      {
        data: "judul",
        render: (data, type, rows, meta) => {
          return (
            '<a class="text-decoration-none" role="button" data-bs-toggle="collapse" href="#collapse-' +
            rows.id +
            '"><h6 class="m-0">' +
            data +
            "</h6></a>" +
            '<span class="text-muted small">' +
            rows.tanggal +
            "</span>" +
            '<div class="collapse" id="collapse-' +
            rows.id +
            '"><hr class="my-2">' +
            rows.isi +
            "</div>"
          );
        },
      },
      {
        data: "id",
        className: "text-center",
        width: "70px",
        render: (data, type, rows, meta) => {
          return (
            '<div class="btn-group btn-group-sm">' +
            '<button type="button" class="btn btn-primary btnEditInfo" data-id="' +
            data +
            '"><i class="bi bi-pencil-square"></i></button>' +
            '<button type="button" class="btn btn-danger btnHapusInfo" data-id="' +
            data +
            '"><i class="bi bi-trash-fill"></i></button>' +
            "</div>"
          );
        },
      },
    ],
  });

  tabelInformasi.on("draw", () => {
    reloadWidget();

    $(".btnEditInfo").on("click", function () {
      const id = $(this).data("id");
      fetchData("../api/info.php?id=" + id)
        .then((e) => {
          $("#idInformasi").val(e.id);
          $("#judul").val(e.judul);
          $("#isi").summernote("code", e.isi);
          $("#modalTambahInformasi").modal("show");
        })
        .catch((err) => toast(err.responseJSON.message, "error"));
    });

    $(".btnHapusInfo").on("click", async function () {
      const id = $(this).data("id");
      const btn = $(this);
      const data = await fetchData("../api/info.php?id=" + id);
      if (!data) return;
      const action = await toast({
        title: "Hapus informasi?",
        message:
          "Informasi: <strong>" +
          data.judul +
          "</strong> akan dihapus permanen. Yakin?",
        icon: "question",
        position: "middle-center",
      });
      if (action) {
        const res = await fetchData({
          url: "../api/info.php?id=" + id,
          method: "DELETE",
          button: btn,
        });
        if (!res) return;
        toast({
          message:
            "Informasi: <strong>" + data.judul + "</strong> berhasil dihapus.",
          delay: 5000,
          icon: "success",
        });
        tabelInformasi.ajax.reload(null, false);
      }
    });
  });

  const tabelBerkas = $("#tabelBerkas").DataTable({
    dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
    lengthMenu: [
      [5, 10, 25, 50, 100, -1],
      [5, 10, 25, 50, 100, "All"],
    ],
    responsive: {
      details: {
        renderer: DataTable.Responsive.renderer.listHiddenNodes(),
      },
    },
    ordering: false,
    processing: true,
    pagingType: "simple",
    ajax: {
      url: "../api/berkas.php",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
        className: "w-100",
        render: (data, type, rows, meta) => {
          const checked = rows.status == "1" ? "checked" : "";
          const label =
            rows.status == "1" ? "Ditampilkan" : "Tidak ditampilkan";

          return (
            '<div class="d-flex justify-content-start">' +
            '<div class="px-2 d-flex" style="width: 75px; height: 75px;"><a title="Preview" href="' +
            rows.src +
            '" data-fancybox class="mx-auto fs-1">' +
            getFileIcon(rows.type) +
            "</a></div>" +
            '<div class="w-100"><div class="d-flex justify-content-between"><h6 class="m-0">' +
            rows.title +
            '</h6><span class="text-muted small">' +
            timeAgo(rows.tanggal) +
            '</span></div><p class="m-0 small text-muted">[' +
            fileSize(parseInt(rows.size)) +
            "] " +
            rows.filename +
            "</p>" +
            '<div class="form-check form-switch">' +
            '<input class="form-check-input btnSwitchBerkas" data-id="' +
            data +
            '" type="checkbox" role="switch" id="' +
            data +
            '" ' +
            checked +
            ">" +
            '<label class="form-check-label small text-muted" for="' +
            data +
            '">' +
            label +
            " pada unduhan</label>" +
            "</div>" +
            "</div>" +
            "</div>"
          );
        },
      },
      {
        data: "id",
        width: "70px",
        className: "text-center",
        render: (data, type, rows, meta) => {
          return (
            '<div class="btn-group btn-group-sm">' +
            '<a href="' +
            rows.src +
            '" class="btn btn-primary" download title="Unduh berkas"><i class="bi bi-download"></i></a>' +
            '<button type="button" class="btn btn-danger btnHapusBerkas" data-id="' +
            rows.id +
            '" title="Hapus berkas"><i class="bi bi-trash-fill"></i></button>' +
            "</div>"
          );
        },
      },
    ],
  });

  tabelBerkas.on("draw", () => {
    reloadWidget();

    $(".btnHapusBerkas").on("click", async function () {
      const id = $(this).data("id");
      const btn = $(this);
      const data = await fetchData("../api/berkas.php?id=" + id);
      if (!data) return;
      const action = await toast({
        title: "Hapus berkas?",
        message: "Berkas: " + data.title + " akan dihapus permanen. Yakin?",
        icon: "question",
      });
      if (action) {
        const result = await fetchData({
          url: "../api/berkas.php?id=" + id,
          method: "DELETE",
          button: btn,
        });
        if (!result) return;
        toast({
          message: "Berkas: " + data.title + " berhasil dihapus permanen?",
          icon: "success",
          delay: 5000,
        });
      }
      tabelBerkas.ajax.reload(null, false);
    });

    $(".btnSwitchBerkas").on("click", async function () {
      const id = $(this).data("id");
      const state = $(this).is(":checked") ? 1 : 0;
      const data = await fetchData("../api/berkas.php?id=" + id);
      if (!data) return;

      const res = await fetchData({
        url: "../api/berkas.php?id=" + id,
        data: {
          title: data.title,
          status: state,
        },
        method: "POST",
      });
      if (!res) {
        $(this).prop("checked", !state);
        return;
      }
      toast({
        message:
          "Data berkas: <strong>" + data.title + "</strong> berhasil diubah.",
        icon: "success",
        delay: 5000,
      });
      tabelBerkas.ajax.reload(null, false);
    });
  });

  $("#btnReloadTabelInformasi").on("click", () =>
    tabelInformasi.ajax.reload(null, false)
  );
  $("#btnReloadTabelBerkas").on("click", () =>
    tabelBerkas.ajax.reload(null, false)
  );
  $("#btnReloadTabelBanner").on("click", () =>
    tabelBanner.ajax.reload(null, false)
  );
  $("#btnReloadTabelEvent").on("click", () =>
    tabelEvent.ajax.reload(null, false)
  );
  $("#btnReloadTabelTautan").on("click", () =>
    tabelTautan.ajax.reload(null, false)
  );

  $("#btnSaveInfo").on("click", async function () {
    const btnElm = $(this);
    const judulElm = $("#judul");
    const isiElm = $("#isi");
    const id = $("#idInformasi");

    if (judulElm.val() == "" || isiElm.val() == "") {
      if (judulElm.val() == "") judulElm.addClass("is-invalid");
      else judulElm.removeClass("is-invalid");
      if (isiElm.val() == "") isiElm.addClass("is-invalid");
      else isiElm.removeClass("is-invalid");
      toast("Lengkapi form.", "info");
      return;
    }

    $(".is-invalid").removeClass("is-invalid");
    let data = new FormData();
    data.append("judul", judulElm.val());
    data.append("isi", isiElm.val());
    const res = await fetchData({
      url: "../api/info.php?id=" + id.val(),
      data: {
        judul: judulElm.val(),
        isi: isiElm.val(),
      },
      method: "POST",
      button: btnElm,
    });
    if (!res) return;
    toast({
      message:
        "Informasi dengan judul: <strong>" +
        judulElm.val() +
        "</strong> berhasil disimpan.",
      icon: "success",
      delay: 5000,
    });
    tabelInformasi.ajax.reload(null, false);
    $("#modalTambahInformasi").modal("hide");
  });

  $("#modalTambahInformasi").on("hide.bs.modal", function () {
    $("#judul,#idInformasi").val("");
    $("#isi").summernote("code", "");
  });

  $("#searchTabelInformasi").on("keyup", (e) => {
    const keyword = e.target.value;
    if (keyword !== "") {
      $(".collapse").collapse("show");
      tabelInformasi.search(keyword).draw();
    } else $(".collapse").collapse("hide");
  });
  $("#searchTabelBerkas").on("keyup", (e) =>
    tabelBerkas.columns(0).search(e.target.value).draw()
  );
  $("#searchTabelBanner").on("keyup", (e) =>
    tabelBanner.columns(0).search(e.target.value).draw()
  );
  $("#searchTabelEvent").on("keyup", (e) =>
    tabelEvent.columns(0).search(e.target.value).draw()
  );
  $("#searchTabelTautan").on("keyup", (e) =>
    tabelTautan.columns(0).search(e.target.value).draw()
  );

  $("#btnSaveBerkas").on("click", async function () {
    const btnElm = $(this);
    const fileElm = $("#fileBerkas");
    const titleElm = $("#titleFile");

    if (fileElm.val() == "" || titleElm.val() == "") {
      if (fileElm.val() == "") fileElm.addClass("is-invalid");
      else fileElm.removeClass("is-invalid");
      if (titleElm.val() == "") titleElm.addClass("is-invalid");
      else titleElm.removeClass("is-invalid");
      toast("Lengkapi form terlebih dahulu", "error");
      return;
    }
    $("is-invalid").removeClass("is-invalid");

    const file = fileElm.prop("files");
    let data = new FormData();
    data.append("title", titleElm.val());
    data.append("file", file[0]);
    const res = await fetchData({
      url: "../api/berkas.php",
      data: data,
      method: "POST",
      button: btnElm,
    });
    if (!res) return;
    fileElm.val("");
    titleElm.val("");
    $("#modalTambahBerkas").modal("hide");
    tabelBerkas.ajax.reload(null, false);
  });

  const tabelBanner = $("#tabelBanner").DataTable({
    dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
    lengthMenu: [
      [5, 10, 25, 50, 100, -1],
      [5, 10, 25, 50, 100, "All"],
    ],
    responsive: {
      details: {
        renderer: DataTable.Responsive.renderer.listHiddenNodes(),
      },
    },
    ordering: false,
    processing: true,
    pagingType: "simple",
    ajax: {
      url: "../api/banner.php",
      dataSrc: "",
    },
    deferRender: true,
    columns: [
      {
        data: "id",
        className: "w-100",
        render: (data, type, rows, meta) => {
          return (
            '<div class="d-flex justify-content-start">' +
            '<div class="px-2 d-flex" style="width: 150px; height: 50px;"><a title="Preview" href="#" data-fancybox class="mx-auto placeholder-image" data-id="' +
            rows.berkas_id +
            '">' +
            '<img src="#" class="img-thumbnail" style="object-fit: cover; height: 100%;">' +
            "</a></div>" +
            '<div><h6 class="m-0">' +
            rows.title +
            '</h6><p class="m-0 small text-muted">' +
            rows.description +
            "</p></div>" +
            "</div>"
          );
        },
      },
      {
        data: "id",
        className: "text-center",
        width: "70px",
        render: (data, type, rows, meta) => {
          return (
            '<div class="btn-group btn-group-sm">' +
            '<button type="button" class="btn btn-danger btnHapusBanner" data-id="' +
            data +
            '" title="Hapus Banner"><i class="bi bi-trash-fill"></i></button>' +
            "</div>"
          );
        },
      },
    ],
    drawCallback: async function (settings) {
      const placeholders = $(".placeholder-image");
      placeholders.each(async function () {
        const id = $(this).data("id");
        const imgData = await fetchData("../api/berkas.php?id=" + id);
        if (imgData) {
          $(this)
            .attr("href", imgData.src)
            .find("img")
            .attr("src", imgData.src);
        }
      });
    },
  });

  tabelBanner.on("draw", () => {
    reloadWidget();

    $(".btnHapusBanner").on("click", async function () {
      const id = $(this).data("id");
      const data = await fetchData("../api/banner.php?id=" + id);
      if (!data) return;
      const action = await toast({
        title: "Hapus Banner?",
        message: "Data banner: " + data.title + " akan dihapus permanen.",
        icon: "question",
      });
      if (action) {
        const res = await fetchData({
          url: "../api/banner.php?id=" + id,
          method: "DELETE",
        });
        if (!res) return;
        toast({
          message:
            "Data banner: <strong>" +
            data.title +
            "</strong> berhasil dihapus.",
          icon: "success",
          delay: 5000,
        });
        tabelBanner.ajax.reload(null, false);
      }
    });
  });

  $("#fileBanner").on("change", function () {
    const file = $(this).prop("files")[0];
    const inputElm = $(this);
    const previewElm = $("#previewBanner");

    inputElm.next(".invalid-feedback").remove();
    inputElm.removeClass("is-invalid");

    if (!file) return;

    const img = new Image();
    img.onload = function () {
      const width = img.width;
      const height = img.height;
      const aspectRatio = width / height;
      const tolerance = 0.5;
      const targetRatio = 3;

      if (Math.abs(aspectRatio - targetRatio) > tolerance) {
        inputElm
          .addClass("is-invalid")
          .after(
            '<div class="invalid-feedback">Aspek rasio pada gambar yang diupload harus 3:1.</div>'
          );
        previewElm.attr("src", "").parent("a").attr("href", "").hide();
        $("#btnSaveBanner").prop("disabled", true);
      } else {
        previewElm
          .attr("src", img.src)
          .parent("a")
          .attr("href", img.src)
          .show();
        $("#btnSaveBanner").prop("disabled", false);
      }
    };
    img.src = URL.createObjectURL(file);
  });

  $("#btnSaveBanner").on("click", async function () {
    const btnElm = $(this);
    const fileElm = $("#fileBanner");
    const titleElm = $("#titleFileBanner");
    const description = $("#bannerDescription");

    if (
      !fileElm.val().trim() ||
      !titleElm.val().trim() ||
      fileElm.hasClass("is-invalid")
    ) {
      if (!fileElm.val().trim()) fileElm.addClass("is-invalid");
      else fileElm.removeClass("is-invalid");
      if (!titleElm.val().trim()) titleElm.addClass("is-invalid");
      else titleElm.removeClass("is-invalid");
      toast("Form isian belum valid.", "error");
      return;
    }
    $(".is-invalid").removeClass("is-invalid");

    const file = fileElm.prop("files")[0];
    let image = new FormData();
    image.append("file", file);
    image.append("title", titleElm.val());

    const sendImage = await fetchData({
      url: "../api/berkas.php",
      data: image,
      method: "POST",
      button: btnElm,
    });
    if (!sendImage) return;
    const setData = await fetchData({
      url: "../api/banner.php",
      data: {
        title: titleElm.val(),
        description: description.val(),
        berkas_id: sendImage.data.id,
      },
      method: "POST",
    });
    if (!setData) return;

    fileElm.val("");
    titleElm.val("");
    $("#modalTambahBanner").modal("hide");
    toast({
      message: "Data banner berhasil ditambahkan.",
      icon: "success",
      delay: 5000,
    });
    tabelBanner.ajax.reload(null, false);
  });

  const tabelEvent = $("#tabelEvent").DataTable({
    dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
    lengthMenu: [
      [5, 10, 25, 50, 100, -1],
      [5, 10, 25, 50, 100, "All"],
    ],
    responsive: {
      details: {
        renderer: DataTable.Responsive.renderer.listHiddenNodes(),
      },
    },
    ordering: false,
    processing: true,
    pagingType: "simple",
    ajax: {
      url: "../api/event.php",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
        className: "w-75",
        render: (data, type, rows, meta) => {
          const checked = rows.status == 1 ? "checked" : "";
          const label = rows.status == 1 ? "Ditampilkan" : "Tidak ditampilkan";
          return (
            '<h6 class="mb-1">' +
            rows.name +
            "</h6>" +
            '<div class="form-check form-switch">' +
            '<input class="form-check-input btnSwitchEvent" data-id="' +
            data +
            '" type="checkbox" role="switch" id="' +
            data +
            '" ' +
            checked +
            ">" +
            '<label class="form-check-label small text-muted" for="' +
            data +
            '">' +
            label +
            " pada counter</label>" +
            "</div>"
          );
        },
      },
      {
        data: "tanggal",
        width: "120px",
        className: "text-center",
        render: (data, type, rows, meta) => {
          return tanggal(data, "D F Y<br>H:i:s WIB");
        },
      },
      {
        width: "70px",
        data: "id",
        className: "text-center",
        render: (data, type, rows, meta) => {
          return (
            '<div class="btn-group btn-group-sm">' +
            '<button type="button" class="btn btn-danger btnHapusEvent" data-id="' +
            data +
            '" title="Hapus Event"><i class="bi bi-trash-fill"></i></button>' +
            "</div>"
          );
        },
      },
    ],
  });

  tabelEvent.on("draw", function () {
    reloadWidget();

    $(".btnHapusEvent").on("click", async function () {
      const id = $(this).data("id");
      const data = await fetchData("../api/event.php?id=" + id);
      if (!data) return;
      const conf = await toast({
        title: "Hapus Event?",
        message:
          "Data event: <strong>" +
          data.name +
          "</strong> akan dihapus permanen, anda yakin?",
        icon: "question",
      });
      if (!conf) return;
      const res = await fetchData({
        url: "../api/event.php?id=" + id,
        method: "DELETE",
      });
      if (!res) return;
      toast(
        "Data event: <strong>" +
          data.name +
          "</strong> berhasil dihapus permanen.",
        "success",
        null,
        5000
      );
      tabelEvent.ajax.reload(null, false);
    });

    $(".btnSwitchEvent").on("change", async function () {
      const id = $(this).data("id");
      const state = $(this).is(":checked") ? 1 : 0;
      const data = await fetchData("../api/event.php?id=" + id);
      if (!data) return;
      const res = await fetchData({
        url: "../api/event.php?id=" + id,
        data: {
          name: data.name,
          tanggal: data.tanggal,
          status: state,
        },
        method: "POST",
      });
      if (!res) {
        $(this).prop("checked", !state);
        return;
      }
      toast({
        message:
          "Status event: <strong>" + data.name + "</strong> berhasil diubah.",
        icon: "success",
        delay: 5000,
      });
      tabelEvent.ajax.reload(null, false);
    });
  });

  $("#btnSaveEvent").on("click", async function () {
    const btn = $(this);
    const nameElm = $("#namaEvent");
    const tanggalElm = $("#tanggalEvent");
    if (!nameElm.val().trim() || !tanggalElm.val().trim()) {
      if (!nameElm.val().trim()) nameElm.addClass("is-invalid");
      else nameElm.removeClass("is-invalid");
      if (!tanggalElm.val().trim()) tanggalElm.addClass("is-invalid");
      else tanggalElm.removeClass("is-invalid");
      toast("Lengkapi form terlebih dahulu.");
      return;
    }

    const res = await fetchData({
      url: "../api/event.php",
      data: {
        name: nameElm.val(),
        tanggal: tanggalElm.val(),
        status: 1,
      },
      method: "POST",
      button: btn,
    });
    if (!res) return;

    nameElm.val("");
    tanggalElm.val("");
    $("#modalTambahEvent").modal("hide");
    toast({
      message:
        "Data event: <strong>" + nameElm.val() + "</strong> berhasil disimpan.",
      icon: "success",
      delay: 5000,
    });
    tabelEvent.ajax.reload(null, false);
  });

  tabelTautan.on("draw", function () {
    $(".btnAktifTautan").on("click", async function () {
      const aktif = $(this).is(":checked");
      const id = $(this).data("id");
      const res = await fetchData({
        url: "../api/tautan.php?id=" + id,
        data: {
          aktif: aktif ? 1 : 0,
        },
        method: "POST",
      });
      if (!res) return;
      toast(res.message, "success");
      tabelTautan.ajax.reload(null, false);
    });

    $(".btnOnMenuTautan").on("click", async function () {
      const aktif = $(this).is(":checked");
      const id = $(this).data("id");
      const res = await fetchData({
        url: "../api/tautan.php?id=" + id,
        data: {
          on_menu: aktif ? 1 : 0,
        },
        method: "POST",
      });
      if (!res) return;
      toast(res.message, "success");
      tabelTautan.ajax.reload(null, false);
    });

    $(".btnHapusTautan").on("click", async function () {
      const id = $(this).data("id");
      const data = await fetchData("../api/tautan.php?id=" + id);
      if (!data) return;
      const conf = await toast({
        title: "Hapus tautan?",
        message:
          "Tautan: <strong>" +
          data.title +
          "</strong> akan dihapus permanen, yakin?",
        icon: "question",
        position: "middle-center",
      });
      if (conf) {
        const res = await fetchData({
          url: "../api/tautan.php?id=" + id,
          method: "DELETE",
        });
        if (!res) return;
        toast(res.message, "success");
        tabelTautan.ajax.reload(null, false);
      }
    });
  });

  $("#btnSimpanTautan").on("click", async function () {
    const title = $("#titleTautan");
    const url = $("#urlTautan");
    const btn = $(this);

    if (!title.val().trim() || !url.val().trim()) {
      if (!title.val().trim()) title.addClass("is-invalid");
      else title.removeClass("is-invalid");
      if (!url.val().trim()) url.addClass("is-invalid");
      else url.removeClass("is-invalid");
      toast("Lengkapi form.", "error");
      return;
    }
    $(".is-invalid").removeClass("is-invalid");

    const res = await fetchData({
      url: "../api/tautan.php",
      data: {
        title: title.val(),
        url: url.val().trim().toLowerCase(),
      },
      method: "POST",
      button: btn,
    });
    if (!res) return;
    toast(res.message, "success", "", 5000);
    title.val("");
    url.val("");
    $("#modalTambahTautan").modal("hide");
    tabelTautan.ajax.reload(null, false);
  });

  $("#balasForum").summernote({
    dialogsInBody: true,
    height: 200,
    toolbar: [
      ["misc", ["undo", "redo"]],
      ["style", ["bold", "italic", "underline", "clear"]],
      ["color", ["color"]],
      ["insert", ["link", "file"]],
      ["view", ["fullscreen", "help"]],
    ],
    callbacks: {
      onFileUpload: (file) => {
        for (let i = 0; i < file.length; i++) {
          uploadMedia(file[i]);
        }
      },
      onMediaDelete: (file) => deleteMedia(file[0]),
    },
  });

  const tabelForum = $("#tabelForum").DataTable({
    dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
    lengthMenu: [
      [5, 10, 25, 50, 100, -1],
      [5, 10, 25, 50, 100, "All"],
    ],
    responsive: {
      details: {
        renderer: DataTable.Responsive.renderer.listHiddenNodes(),
      },
    },
    ordering: false,
    processing: true,
    pagingType: "simple",
    ajax: {
      url: "../api/forum.php",
      dataSrc: "",
    },
    rowCallback: (row, data) => {
      if (data.dibaca == 1) $(row).addClass("table-active");
    },
    columns: [
      {
        data: "id",
        className: "w-100",
        render: (data, type, rows, meta) => {
          return (
            '<a class="text-decoration-none btnBacaForum" data-dibaca="' +
            rows.dibaca +
            '" data-id="' +
            data +
            '" role="button" data-bs-toggle="collapse" href="#collapse-' +
            rows.id +
            '"><h6 class="m-0 dropdown-toggle ' +
            (rows.dibaca == 1 ? "fw-light" : "fw-bold") +
            '">' +
            rows.nama +
            "</h6></a>" +
            '<span class="text-muted small">' +
            tanggal(rows.tanggal, "d F Y H:i WIB") +
            " (" +
            rows.balasan +
            " Balasan)" +
            "</span>" +
            '<div class="collapse collapse-forum" data-dibaca="' +
            rows.dibaca +
            '" data-id="' +
            data +
            '" id="collapse-' +
            rows.id +
            '"><hr class="my-2"><p class="m-0">' +
            rows.isi +
            "</p>" +
            "</div>"
          );
        },
      },
      {
        data: "id",
        className: "text-center",
        width: "70px",
        render: (data, type, rows, meta) => {
          return (
            '<div class="btn-group btn-group-sm">' +
            '<button type="button" class="btn btn-primary btnBalasForum" data-parent="' +
            rows.parent +
            '" data-id="' +
            data +
            '"><i class="bi bi-reply-fill"></i></button>' +
            '<button type="button" class="btn btn-primary btnDetailForum" data-parent="' +
            rows.parent +
            '" data-id="' +
            data +
            '"><i class="bi bi-chat-left-dots-fill"></i></button>' +
            '<button type="button" class="btn btn-danger btnHapusForum" data-id="' +
            data +
            '"><i class="bi bi-trash-fill"></i></button>' +
            "</div>"
          );
        },
      },
    ],
  });

  tabelForum.on("draw", function () {
    $(".collapse-forum").on("show.bs.collapse", async function () {
      const dibaca = $(this).data("dibaca");
      if (dibaca == 0) {
        const id = $(this).data("id");
        await fetchData({
          url: "../api/forum.php?id=" + id,
          data: {
            dibaca: 1,
          },
          method: "POST",
        });
      }
    });

    $(".btnBalasForum").on("click", async function () {
      const id = $(this).data("id");
      const parent = $(this).data("parent");
      const data = await fetchData("../api/forum.php?id=" + id);

      if (!data) return;
      $("#parentForum").val(parent ? parent : id);
      $("#isiForum").html(data.isi);
      $("#namaForum").text(data.nama);
      $("#tanggalForum").text(tanggal(data.tanggal, "d F Y H:i WIB"));
      $("#balasForum").summernote(
        "code",
        "<p><b>@" + data.nama + "</b>:&nbsp;</p>"
      );
      $("#modalBalasForum").modal("show");
    });

    $(".btnHapusForum").on("click", async function () {
      const id = $(this).data("id");
      const data = await fetchData("../api/forum.php?id=" + id);
      if (!data) return;
      const conf = await toast({
        title: "Hapus forum?",
        message:
          "Forum diskusi dari: <strong>" +
          data.nama +
          "</strong> akan dihapus permanen. yakin?",
        icon: "question",
        position: "middle-center",
      });
      if (conf) {
        const deleted = await fetchData({
          url: "../api/forum.php?id=" + id,
          method: "DELETE",
        });
        if (!deleted) return;
        toast(deleted.message, "success");
        tabelForum.ajax.reload(null, false);
      }
    });

    $(".btnDetailForum").on("click", async function () {
      const id = $(this).data("id");
      const parent = $(this).data("parent");
      const html = await fetchData({
        url: "../panel/detail-forum.php?id=" + (parent ? parent : id),
        dataType: "html",
      });
      if (!html) return;
      $("#modalDetailForum .modal-body #jawaban").html(html);
      $("#modalDetailForum").modal("show");

      $(".btnBalasDiskusi").on("click", async function () {
        const id = $(this).data("id");
        $("#idForumPublic").val(id);
        const data = await fetchData("../api/forum.php?id=" + id);
        if (!data) return;
        const code = "<p><b>@" + data.nama + "</b>:&nbsp;</p>";
        $("#pertanyaanAndaBalasan").summernote("code", code);
        $("#collapse-balas").collapse("show");
      });
    });
  });

  $("#btnBalasForumAdmin").on("click", async function () {
    const parent = $("#parentForum");
    const isi = $("#balasForum");
    const nama = $("#namaAdmin");
    const btn = $(this);

    if (isi.summernote("code") == "") {
      toast("Lengkapi form terlebih dahulu.", "info");
      return;
    }

    const resp = await fetchData({
      url: "../api/forum.php",
      data: {
        parent_id: parent.val(),
        nama: nama.val(),
        isi: isi.summernote("code"),
      },
      method: "POST",
      button: btn,
    });

    if (!resp) return;
    toast(resp.message, "success", "", 5000);
    $("#modalBalasForum").modal("hide");
    tabelForum.ajax.reload(null, false);
  });

  $("#btnReloadTabelForum").on("click", () =>
    tabelForum.ajax.reload(null, false)
  );

  $("#searchTabelForum").on("keyup", (e) => {
    const keyword = e.target.value;
    if (keyword !== "") {
      $(".collapse").collapse("show");
      tabelForum.search(keyword).draw();
    } else $(".collapse").collapse("hide");
  });

  $("#btnKirimBalasan").on("click", async function () {
    const parent = $("#idForumPublic");
    const nama = $("#namaAndaBalasan");
    const isi = $("#pertanyaanAndaBalasan");
    const btn = $(this);

    if (!nama.val().trim()) {
      nama.addClass("is-invalid");
      return;
    }
    $(".is-invalid").removeClass("is-invalid");

    const set = await fetchData({
      url: "../api/forum.php",
      data: {
        parent_id: parent.val(),
        isi: isi.summernote("code"),
        nama: nama.val(),
        aktif: 1,
        dibaca: 1,
      },
      method: "POST",
      button: btn,
    });
    if (!set) return;
    toast("Balasan anda berhasil di tambahkan.", "success");
    isi.summernote("code", "");
    $("#collapse-balas").collapse("hide");
    tabelForum.ajax.reload(null, false);
    $("#jawaban").html(
      '<div class="d-flex align-items-center">' +
        '<strong role="status">Loading...</strong>' +
        '<div class="spinner-border spinner-border-sm ms-auto" aria-hidden="true"></div>' +
        "</div>"
    );
    const html = await fetchData({
      url: "../panel/detail-forum.php?id=" + parent.val(),
      dataType: "html",
    });
    $("#jawaban").html(html);

    $(".btnBalasDiskusi").on("click", async function () {
      const id = $(this).data("id");
      $("#idForumPublic").val(id);
      const data = await fetchData("../api/forum.php?id=" + id);
      if (!data) return;
      const code = "<p><b>@" + data.nama + "</b>:&nbsp;</p>";
      $("#pertanyaanAndaBalasan").summernote("code", code);
      $("#collapse-balas").collapse("show");
    });
  });

  $("#fileDark").on("change", function () {
    file = this.files[0];
    if (file) {
      let reader = new FileReader();
      reader.onload = function (event) {
        $("#previewDark")
          .html("")
          .append(
            '<img src="' + event.target.result + '" class="img-fluid h-100">'
          );
      };
      reader.readAsDataURL(file);
    }
  });

  $("#fileLight").on("change", function () {
    file = this.files[0];
    if (file) {
      let reader = new FileReader();
      reader.onload = function (event) {
        $("#previewLight")
          .html("")
          .append(
            '<img src="' + event.target.result + '" class="img-fluid h-100">'
          );
      };
      reader.readAsDataURL(file);
    }
  });

  $("#fileDefault").on("change", function () {
    file = this.files[0];
    if (file) {
      let reader = new FileReader();
      reader.onload = function (event) {
        $("#previewDefault")
          .html("")
          .append(
            '<img src="' + event.target.result + '" class="img-fluid h-100">'
          );
      };
      reader.readAsDataURL(file);
    }
  });

  $("#fileFavicon").on("change", function () {
    file = this.files[0];
    if (file) {
      let reader = new FileReader();
      reader.onload = function (event) {
        $("#previewFavicon")
          .html("")
          .append(
            '<img src="' + event.target.result + '" class="img-fluid h-100">'
          );
      };
      reader.readAsDataURL(file);
    }
  });

  $("#btnSimpanLogoDark").on("click", async function () {
    const btn = $(this);
    const file = $("#fileDark");
    const idDark = $("#idDark");
    if (file.prop("files").length == 0) {
      toast("File input wajib dipilih.", "error");
      file.addClass("is-invalid");
      return;
    }
    $(".is-invalid").removeClass("is-invalid");
    let set = new FormData();
    set.append("file", file.prop("files")[0]);
    set.append("type", "dark");
    const resp = await fetchData({
      url:
        "../api/logo.php" + (idDark.val() !== "" ? "?id=" + idDark.val() : ""),
      data: set,
      method: "POST",
      button: btn,
    });
    if (!resp) return;
    toast("Logo mode gelap berhasil dirubah.", "success");
    file.val("");
  });

  $("#btnSimpanLogoLight").on("click", async function () {
    const btn = $(this);
    const file = $("#fileLight");
    const idLight = $("#idLight");
    if (file.prop("files").length == 0) {
      toast("File input wajib dipilih.", "error");
      file.addClass("is-invalid");
      return;
    }
    $(".is-invalid").removeClass("is-invalid");
    let set = new FormData();
    set.append("file", file.prop("files")[0]);
    set.append("type", "light");
    const resp = await fetchData({
      url:
        "../api/logo.php" +
        (idLight.val() !== "" ? "?id=" + idLight.val() : ""),
      data: set,
      method: "POST",
      button: btn,
    });
    if (!resp) return;
    toast("Logo mode terang berhasil dirubah.", "success");
    file.val("");
  });

  $("#btnSimpanLogoDefault").on("click", async function () {
    const btn = $(this);
    const file = $("#fileDefault");
    const idDefault = $("#idDefault");
    if (file.prop("files").length == 0) {
      toast("File input wajib dipilih.", "error");
      file.addClass("is-invalid");
      return;
    }
    $(".is-invalid").removeClass("is-invalid");
    let set = new FormData();
    set.append("file", file.prop("files")[0]);
    set.append("type", "default");
    const resp = await fetchData({
      url:
        "../api/logo.php" +
        (idDefault.val() !== "" ? "?id=" + idDefault.val() : ""),
      data: set,
      method: "POST",
      button: btn,
    });
    if (!resp) return;
    toast("Logo mode default berhasil dirubah.", "success");
    file.val("");
  });

  $("#btnSimpanLogoFavicon").on("click", async function () {
    const btn = $(this);
    const file = $("#fileFavicon");
    const idFavicon = $("#idFavicon");
    if (file.prop("files").length == 0) {
      toast("File input wajib dipilih.", "error");
      file.addClass("is-invalid");
      return;
    }
    $(".is-invalid").removeClass("is-invalid");
    let set = new FormData();
    set.append("file", file.prop("files")[0]);
    set.append("type", "favicon");
    const resp = await fetchData({
      url:
        "../api/logo.php" +
        (idFavicon.val() !== "" ? "?id=" + idFavicon.val() : ""),
      data: set,
      method: "POST",
      button: btn,
    });
    if (!resp) return;
    toast("Logo mode favicon berhasil dirubah.", "success");
    file.val("");
  });

  $("#btnEditHeader").on("click", function () {
    $("#isiHeader").summernote({
      focus: true,
      height: 100,
      dialogsInBody: true,
      toolbar: [
        ["style", ["bold", "italic", "underline"]],
        ["fontsize", ["fontsize"]],
        ["color", ["color"]],
        ["height", ["height"]],
      ],
    });
  });

  $("#btnSaveHeader").on("click", async function () {
    const btn = $(this);
    const id = $("#idHeader").val();
    var markup = $("#isiHeader").summernote("code");
    $("#isiHeader").summernote("destroy");
    const res = fetchData({
      url: "../api/header.php" + (id == "" ? "" : "?id=" + id),
      data: {
        isi: markup.replaceAll("<p", '<p class="m-0"'),
      },
      method: "POST",
      button: btn,
    });
    if (!res) return;
    toast("Header berhasil disimpan.", "success");
  });

  $("#btnEditHeroes").on("click", function () {
    $("#isiHeroes").summernote({
      focus: true,
      height: 300,
      dialogsInBody: true,
      toolbar: [
        ["misc", ["undo", "redo"]],
        ["paragraph", ["style", "clear"]],
        ["style", ["bold", "italic", "underline"]],
        ["font", ["fontname", "fontsize"]],
      ],
    });
  });

  $("#btnSaveHeroes").on("click", async function () {
    const btn = $(this);
    const id = $("#idHeroes").val();
    var markup = $("#isiHeroes").summernote("code");
    $("#isiHeroes").summernote("destroy");
    const res = fetchData({
      url: "../api/heroes.php" + (id == "" ? "" : "?id=" + id),
      data: {
        content: markup.replaceAll("<p", '<p class="m-0"'),
      },
      method: "POST",
      button: btn,
    });
    if (!res) return;
    toast("Heroes berhasil disimpan.", "success");
  });

  const tabelJadwal = $("#tabelJadwal").DataTable({
    dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
    lengthMenu: [
      [5, 10, 25, 50, 100, -1],
      [5, 10, 25, 50, 100, "All"],
    ],
    responsive: {
      details: {
        renderer: DataTable.Responsive.renderer.listHiddenNodes(),
      },
    },
    ordering: false,
    processing: true,
    pagingType: "simple",
    ajax: {
      url: "../api/jadwal.php",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
        className: "w-100",
        render: (data, type, rows, meta) => {
          const checked = rows.aktif == 1 ? "checked" : "";
          const label = rows.aktif == 1 ? "Aktif" : "Tidak Aktif";
          return (
            '<h6 class="mb-1">' +
            rows.title +
            "</h6>" +
            '<p class="m-0">' +
            rows.content +
            "</p>" +
            '<div class="form-check form-switch">' +
            '<input class="form-check-input btnSwitchJadwal" data-id="' +
            data +
            '" type="checkbox" role="switch" id="' +
            data +
            '" ' +
            checked +
            ">" +
            '<label class="form-check-label small text-muted" for="' +
            data +
            '">' +
            label +
            "</label>" +
            "</div>"
          );
        },
      },
      {
        data: "id",
        className: "text-center",
        width: "70px",
        render: (data, type, rows, meta) => {
          return (
            '<div class="btn-group btn-group-sm">' +
            '<button type="button" class="btn btn-danger btnHapusJadwal" data-id="' +
            data +
            '"><i class="bi bi-trash-fill"></i></button>' +
            "</div>"
          );
        },
      },
    ],
  });

  tabelJadwal.on("draw", function () {
    $(".btnSwitchJadwal").on("click", async function () {
      const id = $(this).data("id");
      const data = await fetchData("../api/jadwal.php?id=" + id);
      if (!data) return;

      const resp = await fetchData({
        url: "../api/jadwal.php?id=" + id,
        data: {
          aktif: $(this).is(":checked") ? 1 : 0,
        },
        method: "POST",
      });
      if (!resp) return;
      toast("Data jadwal pelaksanaan berhasil dirubah.", "success");
      tabelJadwal.ajax.reload(null, false);
    });

    $(".btnHapusJadwal").on("click", async function () {
      const id = $(this).data("id");
      const data = await fetchData("../api/jadwal.php?id=" + id);
      if (!data) return;
      const conf = await toast({
        title: "Hapus Jadwal?",
        message:
          "Jadwal: <strong>" +
          data.title +
          "</strong> akan dihapus permanen. yakin?",
        icon: "question",
        position: "middle-center",
      });
      if (conf) {
        const deleted = await fetchData({
          url: "../api/jadwal.php?id=" + id,
          method: "DELETE",
        });
        if (!deleted) return;
        toast(deleted.message, "success");
        tabelJadwal.ajax.reload(null, false);
      }
    });
  });

  $("#contentJadwal").summernote({
    height: 100,
    dialogsInBody: true,
    toolbar: [
      ["style", ["bold", "italic", "underline"]],
      ["view", ["fullscreen", "help"]],
    ],
  });

  $("#btnReloadTabelJadwal").on("click", () =>
    tabelJadwal.ajax.reload(null, false)
  );

  $("#searchTabelJadwal").on("keyup", (e) =>
    tabelJadwal.columns(0).search(e.target.value).draw()
  );

  $("#btnSimpanJadwal").on("click", async function () {
    const btn = $(this);
    const title = $("#titleJadwal");
    const content = $("#contentJadwal");
    if (!title.val().trim() || content.summernote("isEmpty")) {
      if (!title.val().trim()) title.addClass("is-invalid");
      else title.removeClass("is-invalid");
      if (content.summernote("isEmpty")) content.addClass("is-invalid");
      else content.removeClass("is-invalid");
      toast("Lengkapi form terlebih dahulu.", "error");
      return;
    }
    $(".is-invalid").removeClass("is-invalid");
    const resp = await fetchData({
      url: "../api/jadwal.php",
      data: {
        title: title.val(),
        content: content.summernote("code").replaceAll("<p", '<p class="mb-0"'),
        aktif: 1,
      },
      method: "POST",
      button: btn,
    });
    if (!resp) return;

    toast("Data jadwal pelaksanaan PPDB berhasil ditambahkan.", "success");
    title.val("");
    content.summernote("code", "");
    tabelJadwal.ajax.reload(null, false);
    $("#modalTambahJadwal").modal("hide");
  });

  const tabelJalur = $("#tabelJalur").DataTable({
    dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
    lengthMenu: [
      [5, 10, 25, 50, 100, -1],
      [5, 10, 25, 50, 100, "All"],
    ],
    responsive: {
      details: {
        renderer: DataTable.Responsive.renderer.listHiddenNodes(),
      },
    },
    ordering: false,
    processing: true,
    pagingType: "simple",
    ajax: {
      url: "../api/jalur.php",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
        className: "w-100",
        render: (data, type, rows, meta) => {
          return (
            '<h6 class="mb-1">' +
            rows.nama +
            "</h6>" +
            '<p class="m-0">(' +
            rows.persen +
            "%) " +
            rows.jumlah +
            " Peserta Didik</p>"
          );
        },
      },
      {
        data: "id",
        className: "text-center",
        width: "70px",
        render: (data, type, rows, meta) => {
          return (
            '<div class="btn-group btn-group-sm">' +
            '<button type="button" class="btn btn-danger btnHapusJalur" data-id="' +
            data +
            '"><i class="bi bi-trash-fill"></i></button>' +
            "</div>"
          );
        },
      },
    ],
  });

  tabelJalur.on("draw", function () {
    $(".btnSwitchJalur").on("click", async function () {
      const id = $(this).data("id");
      const data = await fetchData("../api/jalur.php?id=" + id);
      if (!data) return;

      const resp = await fetchData({
        url: "../api/jalur.php?id=" + id,
        data: {
          nama: data.nama,
          persen: data.persen,
          jumlah: data.jumlah,
        },
        method: "POST",
      });
      if (!resp) return;
      toast("Data jalur pendaftaran berhasil dirubah.", "success");
      tabelJalur.ajax.reload(null, false);
    });

    $(".btnHapusJalur").on("click", async function () {
      const id = $(this).data("id");
      const data = await fetchData("../api/jalur.php?id=" + id);
      if (!data) return;
      const conf = await toast({
        title: "Hapus Jalur?",
        message:
          "Jalur pendaftaran: <strong>" +
          data.nama +
          "</strong> akan dihapus permanen. yakin?",
        icon: "question",
        position: "middle-center",
      });
      if (conf) {
        const deleted = await fetchData({
          url: "../api/jalur.php?id=" + id,
          method: "DELETE",
        });
        if (!deleted) return;
        toast(deleted.message, "success");
        tabelJalur.ajax.reload(null, false);
      }
    });
  });

  $("#btnReloadTabelJalur").on("click", () =>
    tabelJalur.ajax.reload(null, false)
  );

  $("#searchTabelJalur").on("keyup", (e) =>
    tabelJalur.columns(0).search(e.target.value).draw()
  );

  $("#btnSimpanJalur").on("click", async function () {
    const btn = $(this);
    const nama = $("#namaJalur");
    const persen = $("#persenJalur");
    const jumlah = $("#jumlahPdJalur");
    if (!nama.val().trim() || !persen.val().trim() || !jumlah.val().trim()) {
      if (!nama.val().trim()) nama.addClass("is-invalid");
      else nama.removeClass("is-invalid");
      if (!persen.val().trim()) persen.addClass("is-invalid");
      else persen.removeClass("is-invalid");
      if (!jumlah.val().trim()) jumlah.addClass("is-invalid");
      else jumlah.removeClass("is-invalid");
      toast("Lengkapi form terlebih dahulu.", "error");
      return;
    }
    $(".is-invalid").removeClass("is-invalid");
    const resp = await fetchData({
      url: "../api/jalur.php",
      data: {
        nama: nama.val(),
        persen: persen.val(),
        jumlah: jumlah.val(),
      },
      method: "POST",
      button: btn,
    });
    if (!resp) return;

    toast("Data Jalur pelaksanaan PPDB berhasil ditambahkan.", "success");
    nama.val("");
    persen.val("");
    jumlah.val("");

    tabelJalur.ajax.reload(null, false);
    $("#modalTambahJalur").modal("hide");
  });

  $("#btnEditSyarat").on("click", function () {
    $("#isiSyarat").summernote({
      focus: true,
      height: 500,
      dialogsInBody: true,
      toolbar: [
        ["style", ["bold", "italic", "underline"]],
        ["fontsize", ["fontsize"]],
        ["para", ["ul", "ol", "paragraph"]],
      ],
    });
  });

  $("#btnSaveSyarat").on("click", async function () {
    const btn = $(this);
    const id = $("#idSyarat").val();
    var markup = $("#isiSyarat").summernote("code");
    $("#isiSyarat").summernote("destroy");
    const res = fetchData({
      url: "../api/syarat.php" + (id == "" ? "" : "?id=" + id),
      data: {
        content: markup.replaceAll("<p", '<p class="m-0"'),
      },
      method: "POST",
      button: btn,
    });
    if (!res) return;
    toast("Syarat berhasil disimpan.", "success");
  });

  $("#btnEditDokumen").on("click", function () {
    $("#isiDokumen").summernote({
      focus: true,
      height: 500,
      dialogsInBody: true,
      toolbar: [
        ["style", ["bold", "italic", "underline"]],
        ["fontsize", ["fontsize"]],
        ["para", ["ul", "ol", "paragraph"]],
      ],
    });
  });

  $("#btnSaveDokumen").on("click", async function () {
    const id = $("#idDokumen").val();
    const btn = $(this);
    var markup = $("#isiDokumen").summernote("code");
    $("#isiDokumen").summernote("destroy");
    const res = fetchData({
      url: "../api/dokumen.php" + (id == "" ? "" : "?id=" + id),
      data: {
        content: markup.replaceAll("<p", '<p class="m-0"'),
      },
      method: "POST",
      button: btn,
    });
    if (!res) return;
    toast("Dokumen kelengkapan berhasil disimpan.", "success");
  });

  $("#btnSimpanIdentitas").on("click", async function () {
    const btn = $(this);
    const id = $("#idIdentitas");
    const form = $("#formIdentitas");
    const data = form.serializeArray();
    let set = {};
    data.forEach((e) => {
      set[e.name] = e.value == "" ? null : e.value;
    });

    const resp = await fetchData({
      url: "../api/identitas.php" + (id.val() !== "" ? "?id=" + id.val() : ""),
      data: set,
      method: "POST",
      button: btn,
    });
    if (!resp) return;
    toast(resp.message, "success");
  });

  $("#btnSaveProfil").on("click", async function (e) {
    e.preventDefault();
    const btn = $(this);
    const id = $("#idAdmin").val();
    const form = $("#formProfil");
    const data = form.serializeArray();
    let set = {};
    data.forEach((e) => (set[e.name] = e.value));
    const result = await fetchData({
      url: "../api/auth.php?type=update&key=" + id,
      data: set,
      method: "POST",
      button: btn,
    });
    if (!result) return;
    toast(result.message, "success");
    if (result.data.affected !== 0) {
      toast("Session berubah, silahkan login kembali.", "info", "", 3000);
      setTimeout(() => {
        window.location.href = "../auth/logout.php";
      }, 3000);
    }
  });
});
