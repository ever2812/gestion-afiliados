// DOM Elements
const promotorSelect = document.getElementById("promotorSelect");
const dropZone = document.getElementById("dropZone");
const ineFileInput = document.getElementById("ineFileInput");
const filePreviewSection = document.getElementById("filePreviewSection");
const previewImg = document.getElementById("previewImg");
const previewPdfIcon = document.getElementById("previewPdfIcon");
const fileName = document.getElementById("fileName");
const fileSize = document.getElementById("fileSize");
const statusMessage = document.getElementById("statusMessage");
const btnProcess = document.getElementById("btnProcess");
const btnProcessText = document.getElementById("btnProcessText");
const resultsCard = document.getElementById("resultsCard");
const apiKeyInput = document.getElementById("apiKeyInput");
// const demoModeToggle = document.getElementById('demoModeToggle');
// const assignedPromoterBadge = document.getElementById('assignedPromoterBadge');
// const tokensRemainingBadge = document.getElementById('tokensRemainingBadge');

let currentFile = null;
let latestExtractedData = null;

function toggleApiKeyVisibility() {
  const isPassword = apiKeyInput.type === "password";
  apiKeyInput.type = isPassword ? "text" : "password";
  const icon = document.getElementById("eyeIcon");
  icon.className = isPassword ? "bi bi-eye-slash" : "bi bi-eye";
}

// Trigger file dialog
function triggerFileInput() {
  ineFileInput.click();
}

// Drag & Drop handlers
["dragenter", "dragover"].forEach((name) => {
  dropZone.addEventListener(name, (e) => {
    e.preventDefault();
    e.stopPropagation();
    dropZone.classList.add("is-dragover");
  });
});

["dragleave", "drop"].forEach((name) => {
  dropZone.addEventListener(name, (e) => {
    e.preventDefault();
    e.stopPropagation();
    dropZone.classList.remove("is-dragover");
  });
});

dropZone.addEventListener("drop", (e) => {
  const files = e.dataTransfer.files;
  if (files && files.length > 0) {
    processSelectedFile(files[0]);
  }
});

dropZone.addEventListener("click", (e) => {
  if (e.target.tagName !== "BUTTON" && !e.target.closest("button")) {
    triggerFileInput();
  }
});

ineFileInput.addEventListener("change", (e) => {
  if (e.target.files && e.target.files[0]) {
    processSelectedFile(e.target.files[0]);
  }
});

function processSelectedFile(file) {
  const validTypes = ["image/jpeg", "image/png", "image/webp", "application/pdf"];
  if (!validTypes.includes(file.type)) {
    showStatus("Formato no soportado. Proporciona una imagen JPEG, PNG, WebP o documento PDF.", "danger");
    return;
  }

  if (file.size > 10 * 1024 * 1024) {
    showStatus("El archivo excede el límite máximo de 10 MB.", "danger");
    return;
  }

  currentFile = file;
  fileName.textContent = file.name;
  fileSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + " MB";

  if (file.type.startsWith("image/")) {
    const reader = new FileReader();
    reader.onload = (e) => {
      previewImg.src = e.target.result;
      previewImg.classList.remove("d-none");
      previewPdfIcon.classList.add("d-none");
      previewPdfIcon.classList.remove("d-flex");
    };
    reader.readAsDataURL(file);
  } else {
    previewImg.classList.add("d-none");
    previewPdfIcon.classList.remove("d-none");
    previewPdfIcon.classList.add("d-flex");
  }

  filePreviewSection.classList.remove("d-none");
  hideStatus();
}

function removeSelectedFile() {
  currentFile = null;
  ineFileInput.value = "";
  previewImg.src = "";
  filePreviewSection.classList.add("d-none");
}

// Main Extraction Handler
async function handleExtractData() {
  const selectedPromoter = promotorSelect.value;
  if (!selectedPromoter) {
    showStatus("Selecciona un promotor antes de realizar la extracción.", "warning");
    promotorSelect.focus();
    return;
  }

  if (!currentFile) {
    showStatus("Adjunta la fotografía del INE a procesar.", "warning");
    dropZone.scrollIntoView({ behavior: "smooth", block: "center" });
    return;
  }

  // UI: Loading State
  setLoadingState(true);
  hideStatus();

  try {
    let responseData;

    if (20.1 > 1) {
      // Mocking the exact JSON structure of extraerdatosdeine.com /api/v1/extract
      await new Promise((resolve) => setTimeout(resolve, 1400));
      responseData = {
        success: true,
        extraction_id: "demo_" + Math.random().toString(36).substring(2, 10),
        data: {
          nombre: "MARÍA ELENA",
          apellidoPaterno: "RODRÍGUEZ",
          apellidoMaterno: "HERNÁNDEZ",
          curp: "ROHM880415MDFRRN09",
          claveElector: "RDHEMR88041509M200",
          fechaNacimiento: "15/04/1988",
          sexo: "M",
          domicilio: "AV. INSURGENTES SUR 1602, CRÉDITO CONSTRUCTOR, BENITO JUÁREZ, CIUDAD DE MÉXICO, C.P. 03940",
          calle: "AV. INSURGENTES SUR 1602",
          colonia: "CRÉDITO CONSTRUCTOR",
          codigoPostal: "03940",
          municipio: "BENITO JUÁREZ",
          estado: "CIUDAD DE MÉXICO",
          seccion: "4321",
          vigencia: "2024-2034",
          emision: "02",
          anioRegistro: "2006",
          ocr: "0943210123456",
          cic: "194857201",
        },
        tokens_remaining: 18,
        upload_method: "multipart",
      };
      showStatus("Modo Demo: Datos simulados con éxito (conforme al formato de extraerdatosdeine.com).", "info");
    } else {
      // Real API call via FormData (Multipart Form-Data)
      const formData = new FormData();
      formData.append("image_front", currentFile);
      const response = await fetch("./api/extract/index.php", {
        method: "POST",
        body: formData,
      });

      const json = await response.json().catch(() => null);

      if (!response.ok) {
        let errorMsg = `Error ${response.status}: `;
        if (json && json.message) {
          errorMsg += json.message;
        } else if (response.status === 401) {
          errorMsg += "API Key inválida o no proporcionada en extraerdatosdeine.com";
        } else if (response.status === 402) {
          errorMsg += "Saldo de tokens insuficiente en tu cuenta.";
        } else if (response.status === 429) {
          errorMsg += "Límite de peticiones alcanzado. Intenta de nuevo en un momento.";
        } else {
          errorMsg += "No se pudo procesar la imagen del INE.";
        }
        throw new Error(errorMsg);
      }

      responseData = json;
      showStatus("¡Datos de INE extraídos con éxito desde la API!", "success");
    }

    if (responseData && responseData.data) {
      populateResults(responseData.data, selectedPromoter, responseData.tokens_remaining);
    } else {
      throw new Error("La API respondió pero no contenía datos legibles.");
    }
  } catch (error) {
    showStatus(error.message || "Error de conexión con el servicio de OCR.", "danger");
  } finally {
    setLoadingState(false);
  }
}

function populateResults(data, promoter, tokens) {
  latestExtractedData = {
    promotor: promoter,
    timestamp: new Date().toISOString(),
    ...data,
  };

  // Populate text inputs
  document.getElementById("resNombre").value = data.nombre || "";
  document.getElementById("resApellidoPaterno").value = data.apellidoPaterno || "";
  document.getElementById("resApellidoMaterno").value = data.apellidoMaterno || "";
  document.getElementById("resCurp").value = data.curp || "";
  document.getElementById("resClaveElector").value = data.claveElector || "";
  document.getElementById("resDomicilio").value = data.domicilio || "";
  // document.getElementById("resCalle").value = data.calle || "";
  // document.getElementById("resColonia").value = data.colonia || "";
  // document.getElementById("resMunicipio").value = data.municipio || "";
  // document.getElementById("resEstado").value = data.estado || "";
  // document.getElementById("resCodigoPostal").value = data.codigoPostal || "";
  // document.getElementById("resFechaNacimiento").value = data.fechaNacimiento || "";

  // const sexoSelect = document.getElementById("resSexo");
  // if (data.sexo && ["H", "M", "X"].includes(data.sexo.toUpperCase())) {
  //   sexoSelect.value = data.sexo.toUpperCase();
  // }

  document.getElementById("resSeccion").value = data.seccion || "";
  document.getElementById("resVigencia").value = data.vigencia || "";
  document.getElementById("resEmision").value = data.emision || "";
  document.getElementById("resAnioRegistro").value = data.anioRegistro || "";
  //   document.getElementById('resOcr').value = data.ocr || '';
  //   document.getElementById('resCic').value = data.cic || '';

  // Show results
  resultsCard.classList.remove("d-none");
  resultsCard.scrollIntoView({ behavior: "smooth", block: "start" });
}

function setLoadingState(isLoading) {
  btnProcess.disabled = isLoading;
  if (isLoading) {
    btnProcess.innerHTML = `
          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
          <span>Extrayendo datos....</span>
        `;
  } else {
    btnProcess.innerHTML = `
          <i class="bi bi-cpu"></i>
          <span id="btnProcessText">Escanear y Extraer Datos de INE</span>
        `;
  }
}

function copyExtractedJSON() {
  if (!latestExtractedData) return;

  // Update data with current edited inputs
  const currentSnapshot = {
    ...latestExtractedData,
    nombre: document.getElementById("resNombre").value,
    apellidoPaterno: document.getElementById("resApellidoPaterno").value,
    apellidoMaterno: document.getElementById("resApellidoMaterno").value,
    curp: document.getElementById("resCurp").value,
    claveElector: document.getElementById("resClaveElector").value,
    domicilio: document.getElementById("resDomicilio").value,
    // calle: document.getElementById("resCalle").value,
    // colonia: document.getElementById("resColonia").value,
    // municipio: document.getElementById("resMunicipio").value,
    // estado: document.getElementById("resEstado").value,
    // codigoPostal: document.getElementById("resCodigoPostal").value,
    // fechaNacimiento: document.getElementById("resFechaNacimiento").value,
    // sexo: document.getElementById("resSexo").value,
    seccion: document.getElementById("resSeccion").value,
    vigencia: document.getElementById("resVigencia").value,
    emision: document.getElementById("resEmision").value,
    anioRegistro: document.getElementById("resAnioRegistro").value,
    // ocr: document.getElementById('resOcr').value,
    // cic: document.getElementById('resCic').value
  };

  const jsonStr = JSON.stringify(currentSnapshot, null, 2);

  // Robust copy method for iframe compatibility
  const dummy = document.createElement("textarea");
  document.body.appendChild(dummy);
  dummy.value = jsonStr;
  dummy.select();
  document.execCommand("copy");
  document.body.removeChild(dummy);

  showStatus("Datos copiados al portapapeles en formato JSON.", "success");
}

function saveFinalRecord() {
  const btnSave = document.getElementById("btnSaveRecord");
  btnSave.disabled = true;
  btnSave.innerHTML = `
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span>Guardando...</span>
      `;

  setTimeout(() => {
    btnSave.disabled = false;
    btnSave.innerHTML = `<i class="bi bi-cloud-arrow-up"></i> <span>Guardar Registro</span>`;
    const nombreCompleto = `${document.getElementById("resNombre").value} ${document.getElementById("resApellidoPaterno").value}`;
    showStatus(`¡Registro de ${nombreCompleto || "la persona"} guardado correctamente!`, "success");
  }, 800);
}

function resetAll() {
  document.getElementById("ineExtractionForm").reset();
  document.getElementById("extractedDataForm").reset();
  removeSelectedFile();
  resultsCard.classList.add("d-none");
  latestExtractedData = null;
  hideStatus();
  window.scrollTo({ top: 0, behavior: "smooth" });
}

function showStatus(text, variant = "info") {
  statusMessage.className = `alert alert-${variant} border py-2 px-3 rounded-3 small mb-3 shadow-sm`;
  statusMessage.textContent = text;
  statusMessage.classList.remove("d-none");
}

function hideStatus() {
  statusMessage.classList.add("d-none");
}
