/**
 * Mengambil data dari server dengan AJAX.
 * Bisa menerima parameter sebagai objek konfigurasi atau individual parameter.
 *
 * @param {string|Object} urlOrConfig - URL request atau objek konfigurasi.
 * @param {Object} [data={}] - Data yang dikirim (opsional, abaikan jika pakai objek konfigurasi).
 * @param {string} [dataType="json"] - Tipe data yang dikembalikan (opsional, abaikan jika pakai objek konfigurasi).
 * @param {string} [method="GET"] - Metode request (opsional, abaikan jika pakai objek konfigurasi).
 * @returns {Promise<any>} - Promise yang mengembalikan hasil response AJAX.
 * @throws {Error} - Jika terjadi error selama request.
 */
async function fetchData(urlOrConfig, ...restParams) {
  let config;
  if (typeof urlOrConfig === "object") {
    if (restParams.length > 0) {
      throw new Error(
        "fetchData() tidak boleh memiliki parameter tambahan jika menggunakan objek konfigurasi."
      );
    }

    config = {
      url: urlOrConfig.url,
      data: urlOrConfig.data || {},
      dataType: urlOrConfig.dataType || "json",
      method: urlOrConfig.method || "GET",
      button: urlOrConfig.button || null,
    };
  } else {
    config = {
      url: urlOrConfig,
      data: restParams[0] || {},
      method: restParams[1] || "GET",
      dataType: restParams[2] || "json",
    };
  }

  const btnText = config.button ? config.button.html() : null;

  if (config.button) {
    config.button.prop("disabled", true)
      .html(`<div class="spinner-border spinner-border-sm" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>`);
  }

  try {
    let isFormData = config.data instanceof FormData;

    let options = {
      url: config.url,
      method: config.method,
      dataType: config.dataType,
      cache: false,
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    };

    if (isFormData) {
      options.processData = false;
      options.contentType = false;
      options.enctype = "multipart/form-data";
      options.data = config.data;
    } else {
      options.contentType = "application/x-www-form-urlencoded";
      options.data = $.param(config.data);
    }
    return await $.ajax(options);
  } catch (error) {
    console.log(error);
    errorHandle(error);
    return false;
  } finally {
    if (config.button) {
      config.button.prop("disabled", false).text(btnText);
    }
  }
}
