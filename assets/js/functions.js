function fileSize(size, unit = "auto", decimals = 0) {
  const units = ["B", "KB", "MB", "GB", "TB", "PB"];
  let index = 0;

  if (unit === "auto") {
    while (size >= 1024 && index < units.length - 1) {
      size /= 1024;
      index++;
    }
  } else {
    index = units.indexOf(unit.toUpperCase());
    if (index === -1) return "Invalid unit";
    size = size / Math.pow(1024, index);
  }

  return parseFloat(size.toFixed(decimals)) + " " + units[index];
}

function getFileIcon(mimeTypeOrExtension) {
  if (!mimeTypeOrExtension || typeof mimeTypeOrExtension !== "string") {
    return "<i class='bi bi-file-earmark'></i>";
  }

  const icons = {
    image: "bi-file-image",
    video: "bi-file-play",
    audio: "bi-file-music",
    "application/pdf": "bi-file-earmark-pdf",
    "application/msword": "bi-file-earmark-word",
    "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
      "bi-file-earmark-word",
    "application/vnd.ms-excel": "bi-file-earmark-excel",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
      "bi-file-earmark-excel",
    "application/vnd.ms-powerpoint": "bi-file-earmark-ppt",
    "application/vnd.openxmlformats-officedocument.presentationml.presentation":
      "bi-file-earmark-ppt",
    "text/plain": "bi-file-text",
    "application/zip": "bi-file-zip",
    "application/x-rar-compressed": "bi-file-zip",
    "application/x-7z-compressed": "bi-file-zip",
    "application/octet-stream": "bi-file-binary",
    pdf: "bi-file-earmark-pdf",
    doc: "bi-file-earmark-word",
    docx: "bi-file-earmark-word",
    xls: "bi-file-earmark-excel",
    xlsx: "bi-file-earmark-excel",
    ppt: "bi-file-earmark-ppt",
    pptx: "bi-file-earmark-ppt",
    txt: "bi-file-text",
    jpg: "bi-file-image",
    jpeg: "bi-file-image",
    png: "bi-file-image",
    gif: "bi-file-image",
    zip: "bi-file-zip",
    tar: "bi-file-zip",
    rar: "bi-file-zip",
    mp4: "bi-file-play",
    avi: "bi-file-play",
    mkv: "bi-file-play",
  };

  if (icons[mimeTypeOrExtension]) {
    return '<i class="bi ' + icons[mimeTypeOrExtension] + '"></i>';
  }

  const type = mimeTypeOrExtension.split("./")[0];

  return (
    '<i class="bi ' + icons[type] + '"></i>' ||
    "<i class='bi bi-file-earmark'></i>"
  );
}

function reloadWidget() {
  fetchData("../api/widget.php").then((e) => {
    $("#totalInfo").text(e.info);
    $("#totalBerkas").text(e.berkas);
    $("#totalBanner").text(e.banner);
    $("#totalEvent").text(e.event);
    $("#totalTautan").text(e.tautan);
    $("#totalForum").text(e.forum);
  });
}

async function uploadMedia(file, summernoteElm = "textarea#isi") {
  let berkas = new FormData();
  berkas.append("title", file.name);
  berkas.append("file", file);
  const res = await fetchData({
    url: "./api/berkas.php",
    data: berkas,
    method: "POST",
  });

  if (!res)
    return toast("Berkas: <strong>" + file.name + "</strong> gagal diupload.");
  let listMimeImg = [
    "image/png",
    "image/jpeg",
    "image/webp",
    "image/gif",
    "image/svg",
  ];
  let listMimeAudio = ["audio/mpeg", "audio/ogg"];
  let listMimeVideo = ["video/mpeg", "video/mp4", "video/webm"];
  let elem;
  let childElem;
  let elemFancy;

  if (listMimeImg.indexOf(file.type) > -1) {
    //Picture
    elem = document.createElement("a");
    elem.setAttribute("href", res.data.src);
    elem.setAttribute("data-fancybox", "");
    elem.setAttribute("data-id", res.data.id);
    childElem = document.createElement("img");
    childElem.setAttribute("class", "img-thumbnail");
    childElem.setAttribute("data-id", res.data.id);
    childElem.setAttribute("src", res.data.src);
    childElem.style.width = "240px";
    childElem.style.height = "180px";
    childElem.style.objectFit = "cover";
    elem.appendChild(childElem);
    $(summernoteElm).summernote("insertNode", elem);
  } else if (listMimeAudio.indexOf(file.type) > -1) {
    //Audio
    elem = document.createElement("audio");
    elem.setAttribute("src", res.data.src);
    elem.setAttribute("controls", "controls");
    elem.setAttribute("preload", "metadata");
    $(summernoteElm).summernote("insertNode", elem);
  } else if (listMimeVideo.indexOf(file.type) > -1) {
    //Video
    elemFancy = document.createElement("a");
    elemFancy.setAttribute("href", res.data.src);
    elemFancy.setAttribute("data-fancybox", "");
    elem = document.createElement("video");
    elem.setAttribute("src", res.data.src);
    elem.setAttribute("controls", "controls");
    elem.setAttribute("preload", "metadata");
    elem.setAttribute("class", "img-thumbnail");
    elem.setAttribute("width", 480);
    elemFancy.appendChild(elem);
    $(summernoteElm).summernote("insertNode", elemFancy);
  } else {
    //Other file type
    elem = document.createElement("a");
    let linkText = document.createTextNode(file.name);
    elem.appendChild(linkText);
    elem.title = file.name;
    elem.href = res.data.src;
    elem.target = "_blank";
    $(summernoteElm).summernote("insertNode", elem);
  }
}

function progressHandlingFunction(e) {
  if (e.lengthComputable) {
    if (e.total > 2097152) {
      const current = Math.round((e.loaded / e.total) * 100);
      $("#loadingModal").modal("show");
      $("#currentPercent").text(current);

      //Reset progress on complete
      if (e.loaded === e.total) {
        $("#loadingModal").modal("hide");
        toast("success", "Upload selesai!");
      }
    }
  }
}

async function deleteMedia(file) {
  const id = $(file).data("id");
  const res = await fetchData({
    url: "./api/berkas.php?id=" + id,
    method: "DELETE",
  });
  if (!res) return toast("Berkas gagal dihapus.", "error");
  toast("Berkas berhasil dihapus.", "success");
  var content = $("textarea#isi");
  var temp = document.createElement("div");
  temp.innerHTML = content.summernote("code");
  var elm = temp.querySelectorAll('a[data-id="' + id + '"]');
  elm.forEach((e) => e.remove());
  content.summernote("code", temp.innerHTML);
}

function getFileExtension(filename) {
  const parts = filename.split(".");
  if (parts.length === 1 || (parts[0] === "" && parts.length === 2)) {
    return "";
  }
  return parts.pop().toLowerCase();
}

function randomString(length = 8) {
  const characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  let result = "";
  const charactersLength = characters.length;

  for (let i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }

  return result;
}

function clearFiles() {
  $("#fileInput").val("").trigger("change");
}

function tanggal(input, outputFormat = "d F Y") {
  if (!input) return "";

  // Array nama bulan dalam bahasa Indonesia
  const bulanIndo = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
  ];

  // Parsing tanggal
  const date = new Date(input);
  if (isNaN(date.getTime())) return "Invalid Date";

  // Ambil komponen tanggal
  const d = date.getDate();
  const m = date.getMonth();
  const y = date.getFullYear();
  const h = date.getHours();
  const i = date.getMinutes();
  const s = date.getSeconds();

  // Ganti format dengan nilai yang sesuai
  const formatMap = {
    d: String(d).padStart(2, "0"), // 01 - 31
    D: d, // 1 - 31
    F: bulanIndo[m], // Januari - Desember
    m: String(m + 1).padStart(2, "0"), // 01 - 12
    M: bulanIndo[m].slice(0, 3), // Jan - Des
    Y: y, // 2025
    y: String(y).slice(-2), // 25
    H: String(h).padStart(2, "0"), // 00 - 23
    i: String(i).padStart(2, "0"), // 00 - 59
    s: String(s).padStart(2, "0"), // 00 - 59
  };

  return outputFormat.replace(
    /d|D|F|m|M|Y|y|H|i|s/g,
    (match) => formatMap[match]
  );
}

function timeAgo(datetime, full = false) {
  const now = new Date();
  const past = new Date(datetime);
  let diffInSeconds = Math.floor((now - past) / 1000);

  if (isNaN(diffInSeconds)) return "Waktu tidak valid";

  const timeUnits = {
    y: { value: 31536000, label: "tahun" },
    m: { value: 2592000, label: "bulan" },
    w: { value: 604800, label: "minggu" },
    d: { value: 86400, label: "hari" },
    h: { value: 3600, label: "jam" },
    i: { value: 60, label: "menit" },
    s: { value: 1, label: "detik" },
  };

  let result = [];
  for (let unit in timeUnits) {
    let count = Math.floor(diffInSeconds / timeUnits[unit].value);
    if (count > 0) {
      result.push(count + " " + timeUnits[unit].label);
      diffInSeconds %= timeUnits[unit].value;
    }
  }

  if (!full) result = result.slice(0, 1);
  return result.length ? result.join(", ") + " lalu" : "baru saja";
}

function toggleButton(buttonElm, text, forceLoading = false) {
  const elm =
    '<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span><span role="status">' +
    text +
    "</span>";

  if (forceLoading) {
    buttonElm.html(elm).prop("disabled", true);
  } else {
    if (!buttonElm.prop("disabled")) {
      buttonElm.html(elm).prop("disabled", true);
    } else {
      buttonElm.text(text).prop("disabled", false);
    }
  }
}

async function counterInner() {
  let dataEvent = [];
  try {
    const res = await fetchData("./api/event.php");
    if (!res) return;
    res.forEach((e) => {
      if (e.status == 1) dataEvent.push([e.name, e.tanggal]);
    });
  } catch (err) {
    console.error(err);
    return;
  }

  const countDownClock = (seconds) => {
    const daysElement = document.querySelector(".days");
    const hoursElement = document.querySelector(".hours");
    const minutesElement = document.querySelector(".minutes");
    const secondsElement = document.querySelector(".seconds");

    if (!daysElement || !hoursElement || !minutesElement || !secondsElement) {
      console.warn("Elemen countdown tidak ditemukan.");
      return;
    }

    function updateDisplay(sec) {
      const days = Math.floor(sec / 86400);
      const hours = Math.floor((sec % 86400) / 3600);
      const minutes = Math.floor(((sec % 86400) % 3600) / 60);
      const seconds = sec % 60;

      daysElement.textContent = days;
      hoursElement.textContent = hours.toString().padStart(2, "0");
      minutesElement.textContent = minutes.toString().padStart(2, "0");
      secondsElement.textContent = seconds.toString().padStart(2, "0");
    }

    let countdown = setInterval(() => {
      seconds--;

      if (seconds <= 0) {
        clearInterval(countdown);
        return;
      }

      updateDisplay(seconds);
    }, 1000);

    updateDisplay(seconds);
  };

  const eventNameElement = document.querySelector("#eventName");
  const today = new Date();

  for (const [name, dateString] of dataEvent) {
    const [datePart, timePart] = dateString.split(" ");
    const [year, month, day] = datePart.split("-").map(Number);
    const [hour, minute, second] = timePart
      ? timePart.split(":").map(Number)
      : [0, 0, 0];

    const target = new Date(year, month - 1, day, hour, minute, second);
    const diffInSeconds = Math.floor((target - today) / 1000);

    if (diffInSeconds > 0) {
      countDownClock(diffInSeconds);
      if (eventNameElement) {
        eventNameElement.innerHTML = `<h3 class="text-center fw-bold">${name}</h3><p class="small fs-6 text-center">(${tanggal(
          dateString,
          "D F Y H:i WIB"
        )})</p>`;
      }
      break;
    }
  }
}

function errorHandle(err) {
  if (err.responseJSON && err.responseJSON.message) {
    toast(err.responseJSON.message, "error", 0);
  } else if (err.code === 400) {
    toast(err.messages, "error", 0);
  } else if (err.code === 500 || err.status === 400) {
    toast(
      err.responseJSON ? err.responseJSON.messages.error : "Error server",
      "error",
      0
    );
  } else {
    toast("An error occurred", "error", 0);
  }
}
