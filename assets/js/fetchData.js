/**
 * Mengambil data dari server dengan AJAX.
 * Bisa menerima parameter sebagai objek konfigurasi atau individual parameter.
 *
 * @param {string|Object} urlOrConfig - URL request atau objek konfigurasi.
 * @param {Object} [data={}] - Data yang dikirim (opsional, abaikan jika pakai objek konfigurasi).
 * @param {string} [dataType="json"] - Tipe data yang dikembalikan (opsional, abaikan jika pakai objek konfigurasi).
 * @param {string} [type="GET"] - Metode request (opsional, abaikan jika pakai objek konfigurasi).
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
      type: urlOrConfig.type || "GET",
    };
  } else {
    config = {
      url: urlOrConfig,
      data: restParams[0] || {},
      dataType: restParams[1] || "json",
      type: restParams[2] || "GET",
    };
  }

  try {
    let isFormData = config.data instanceof FormData;

    let options = {
      url: config.url,
      type: config.type,
      dataType: config.dataType,
    };

    if (isFormData) {
      options.processData = false;
      options.contentType = false;
      options.enctype = "multipart/form-data";
      options.data = config.data;
    } else {
      options.contentType =
        config.dataType === "json"
          ? "application/json"
          : "application/x-www-form-urlencoded";

      options.data =
        config.type === "GET"
          ? $.param(config.data)
          : config.dataType === "json"
          ? JSON.stringify(config.data)
          : config.data;
    }
    return await $.ajax(options);
  } catch (error) {
    console.log(error);
    return null;
  }
}
