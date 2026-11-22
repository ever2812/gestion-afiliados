// Solo permitir dígitos en el teléfono
document.getElementById("telefono").addEventListener("input", function (e) {
  this.value = this.value.replace(/\D/g, "").slice(0, 10);
});

function showStatus(message, type = "success") {
  const box = document.getElementById("statusMessage");
  box.className = `alert alert-${type} py-2 px-3 rounded-3 small mb-3 shadow-sm`;
  box.innerHTML = `<i class="bi bi-${type === "success" ? "check-circle" : "exclamation-circle"} me-1"></i> ${message}`;
  box.classList.remove("d-none");
}

function resetPromotorForm() {
  document.getElementById("promotorForm").reset();
  document.getElementById("statusMessage").classList.add("d-none");
}

async function handleSavePromotor() {
  const nombres = document.getElementById("nombres").value.trim();
  const aPaterno = document.getElementById("aPaterno").value.trim();
  const aMaterno = document.getElementById("aMaterno").value.trim();
  const telefono = document.getElementById("telefono").value.trim();

  const btn = document.getElementById("btnSavePromotor");
  const btnText = document.getElementById("btnSaveText");
  const spinner = document.getElementById("btnSaveSpinner");

  if (!nombres || !aPaterno || !aMaterno || telefono.length !== 10) {
    showStatus("Verifica que el nombre, apellido paterno y teléfono (10 dígitos) sean válidos.", "danger");
    return;
  }

  btn.disabled = true;
  btnText.textContent = "Guardando...";
  spinner.classList.remove("d-none");

  try {
    // Integración con tu endpoint PHP:
    const response = await fetch("../api/promotor/create.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ nombres, aPaterno, aMaterno, telefono }),
    });
    const result = await response.json();
    if (!response.ok || !result.success) throw new Error(result.error || "No se pudo guardar" + result.mensaje);

    // Simulación de guardado
    // await new Promise(r => setTimeout(r, 600));

    // Agregar a la tabla visualmente
    const tbody = document.getElementById("promotoresTableBody");
    const nombreCompleto = `${nombres} ${aPaterno} ${aMaterno}`.trim();
    const tr = document.createElement("tr");
    tr.innerHTML = `
          <td class="fw-medium text-dark">${nombreCompleto}</td>
          <td class="font-monospace text-muted">${telefono}</td>
          <td class="text-end"><span class="badge bg-success-subtle text-success border border-success-subtle">Activo</span></td>
        `;
    tbody.prepend(tr);

    showStatus(`Promotor <strong>${nombreCompleto}</strong> guardado correctamente.`, "success");
    document.getElementById("formPromotor").reset();
  } catch (err) {
    showStatus(err.message || "Error al registrar promotor.", "danger");
  } finally {
    btn.disabled = false;
    btnText.textContent = "Guardar";
    spinner.classList.add("d-none");
  }
}
