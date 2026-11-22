async function guardarAfiliado() {
  const formData = new FormData();

  formData.append("nombres", document.getElementById("resNombre").value.trim());
  formData.append("aPaterno", document.getElementById("resApellidoPaterno").value.trim());
  formData.append("aMaterno", document.getElementById("resApellidoMaterno").value.trim());
  formData.append("curp", document.getElementById("resCurp").value.trim());
  formData.append("cveElector", document.getElementById("resClaveElector").value.trim());
  formData.append("domicilio", document.getElementById("resDomicilio").value.trim());
  formData.append("seccion", document.getElementById("resSeccion").value.trim());
  formData.append("ineVigencia", document.getElementById("resVigencia").value);
  formData.append("idPromotor", document.getElementById("promotorSelect").value);

  // Agregar fotografía
  const foto = document.getElementById("ineFileInput").files[0];

  if (!foto) {
    Swal.fire({
      icon: "warning",
      title: "Fotografía requerida",
      text: "Debes seleccionar la fotografía de la INE.",
    });
    return;
  }

  //animación de botón de guardado
  const btnSave = document.getElementById("btnRegistrar");
  btnSave.disabled = true;
  btnSave.innerHTML = `
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span>Guardando...</span>
      `;
  //

  formData.append("fotoIne", foto);

  try {
    const respuesta = await fetch("../api/afiliado/save.php", {
      method: "POST",
      credentials: "same-origin",
      body: formData,
    });

    const resultado = await respuesta.json();

    if (!respuesta.ok) {
      throw new Error(resultado.mensaje || "Error al guardar.");
    }

    resetAll();

    setTimeout(() => {
      btnSave.disabled = false;
      btnSave.innerHTML = `<i class="bi bi-cloud-arrow-up"></i> <span>Registrar</span>`;
      const nombreCompleto = `${document.getElementById("resNombre").value} ${document.getElementById("resApellidoPaterno").value}`;
      showStatus(`¡Registro de ${nombreCompleto || "la persona"} guardado correctamente!`, "success");
    }, 400);
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: error.message,
    });
  }
}

document.getElementById("btnRegistrar").addEventListener("click", guardarAfiliado);
