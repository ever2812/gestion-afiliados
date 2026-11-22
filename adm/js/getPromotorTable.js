async function cargarTablaPromotores() {
  const tabla = document.getElementById("tablaPromotores");

  try {
    const respuesta = await fetch("../api/promotor/get.php");

    if (!respuesta.ok) {
      throw new Error("Error al consultar el servidor");
    }

    const resultado = await respuesta.json();

    if (!resultado.success) {
      throw new Error(resultado.mensaje);
    }

    resultado.data.forEach((promotor) => {
      // Agregar a la tabla visualmente
      const tbody = document.getElementById("tablaPromotores");
      const nombreCompleto = `${promotor.nombreCompleto}`.trim();
      const tr = document.createElement("tr");
      tr.innerHTML = `
          <td class="fw-medium text-dark">${nombreCompleto}</td>
          <td class="font-monospace text-muted">${promotor.telefono}</td>
          <td class="text-end"><span class="badge bg-success-subtle text-success border border-success-subtle">Activo</span></td>
        `;
      tbody.prepend(tr);
    });
  } catch (error) {
    console.error("Error al cargar promotores:", error);
  }
}

document.addEventListener("DOMContentLoaded", () => {
  cargarTablaPromotores();
});
