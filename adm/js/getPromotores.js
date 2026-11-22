async function cargarPromotores() {
  const select = document.getElementById("promotorSelect");

  try {
    const respuesta = await fetch("../api/promotor/getPromotores.php");

    if (!respuesta.ok) {
      throw new Error("Error al consultar el servidor");
    }

    const resultado = await respuesta.json();

    if (!resultado.success) {
      throw new Error(resultado.mensaje);
    }

    select.innerHTML = `
            <option value="">Seleccione un promotor</option>
        `;

    resultado.data.forEach((promotor) => {
      const option = document.createElement("option");

      option.value = promotor.idPromotor;
      option.textContent = promotor.nombreCompleto;

      select.appendChild(option);
    });
  } catch (error) {
    console.error("Error al cargar promotores:", error);

    select.innerHTML = `
            <option value="">No fue posible cargar los promotores</option>
        `;
  }
}

document.addEventListener("DOMContentLoaded", () => {
  cargarPromotores();
});
