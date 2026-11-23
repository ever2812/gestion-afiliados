
const API_DASHBOARD = '../api/dashboard/';

let afiliados = [];

document.addEventListener('DOMContentLoaded', cargarDashboard);

document.getElementById('btnActualizar').addEventListener('click', cargarDashboard);
document.getElementById('buscarAfiliado').addEventListener('input', filtrarAfiliados);

async function cargarDashboard() {
    const boton = document.getElementById('btnActualizar');
    const error = document.getElementById('dashboardError');

    boton.disabled = true;
    boton.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Actualizando';
    error.classList.add('d-none');

    try {
        const respuesta = await fetch(API_DASHBOARD, {
            method: 'GET',
            credentials: 'same-origin',
            headers: { 'Accept': 'application/json' }
        });

        if (respuesta.status === 401) {
            window.location.href = '../../login/';
            return;
        }

        const resultado = await respuesta.json();

        if (!respuesta.ok || !resultado.success) {
            throw new Error(resultado.mensaje || 'No se pudieron cargar los datos.');
        }

        const data = resultado.data;

        afiliados = data.afiliados || [];

        document.getElementById('totalAfiliados').textContent =
            Number(data.total).toLocaleString('es-MX');

        renderizarResumen(data.resumen || []);
        renderizarTabla(afiliados);

    } catch (errorCarga) {
        error.textContent = errorCarga.message;
        error.classList.remove('d-none');

        document.getElementById('tablaAfiliados').innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-danger py-4">
                    No fue posible cargar los registros.
                </td>
            </tr>`;
    } finally {
        boton.disabled = false;
        boton.innerHTML = '<i class="bi bi-arrow-clockwise me-1"></i> Actualizar datos';
    }
}

function renderizarResumen(resumen) {
    const porSeccion = {};
    const porCasilla = {};

    resumen.forEach(item => {
        const seccion = String(item.seccion);
        const casilla = item.casilla || 'Sin asignar';
        const total = Number(item.total);

        porSeccion[seccion] = (porSeccion[seccion] || 0) + total;

        const clave = `${seccion}-${casilla}`;
        porCasilla[clave] = {
            seccion,
            casilla,
            total
        };
    });

    const secciones = Object.entries(porSeccion);
    const totalSecciones = secciones.length;
    const totalCasillas = Object.keys(porCasilla).length;
    const maximo = Math.max(1, ...secciones.map(([, total]) => total));

    document.getElementById('totalSecciones').textContent = totalSecciones;
    document.getElementById('totalCasillas').textContent = totalCasillas;

    const contenedorSecciones = document.getElementById('resumenSecciones');

    if (!secciones.length) {
        contenedorSecciones.innerHTML =
            '<div class="col-12 text-muted small">Todavía no hay afiliados registrados.</div>';
    } else {
        contenedorSecciones.innerHTML = secciones.map(([seccion, total]) => {
            const porcentaje = (total / maximo) * 100;

            return `
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="section-card p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold section-number">Sección ${escaparHTML(seccion)}</span>
                            <span class="badge text-bg-light">${total} afiliados</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width:${porcentaje}%"></div>
                        </div>
                    </div>
                </div>`;
        }).join('');
    }

    const contenedorCasillas = document.getElementById('resumenCasillas');
    const casillas = Object.values(porCasilla).sort((a, b) =>
        a.seccion.localeCompare(b.seccion) ||
        a.casilla.localeCompare(b.casilla)
    );

    if (!casillas.length) {
        contenedorCasillas.innerHTML =
            '<div class="col-12 text-muted small">No hay casillas con registros.</div>';
    } else {
        contenedorCasillas.innerHTML = casillas.map(item => `
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="section-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted">Sección ${escaparHTML(item.seccion)}</div>
                            <span class="fw-bold">${escaparHTML(item.casilla)}</span>
                        </div>
                        <div class="text-end">
                            <div class="fs-4 fw-bold">${item.total}</div>
                            <small class="text-muted">afiliados</small>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }
}

function renderizarTabla(datos) {
    const tbody = document.getElementById('tablaAfiliados');

    document.getElementById('contadorResultados').textContent =
        `${datos.length.toLocaleString('es-MX')} registros`;

    if (!datos.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted py-4">
                    No hay afiliados para mostrar.
                </td>
            </tr>`;
        return;
    }

    tbody.innerHTML = datos.map(afiliado => {
        const nombre = [
            afiliado.nombres,
            afiliado.aPaterno,
            afiliado.aMaterno
        ].filter(Boolean).join(' ');

        return `
            <tr>
                <td>
                    <div class="fw-semibold text-dark">${escaparHTML(nombre)}</div>
                </td>
                <td><span class="font-monospace small">${escaparHTML(afiliado.curp)}</span></td>
                <td><span class="section-number">${escaparHTML(afiliado.seccion)}</span></td>
                <td><span class="badge badge-casilla">${escaparHTML(afiliado.casilla || 'N/A')}</span></td>
                <td>${escaparHTML(afiliado.promotor || 'Sin promotor')}</td>
                <td class="text-muted">${formatearFecha(afiliado.fechaRegistro)}</td>
            </tr>`;
    }).join('');
}

function filtrarAfiliados() {
    const busqueda = document.getElementById('buscarAfiliado')
        .value.trim().toLocaleLowerCase('es-MX');

    const filtrados = afiliados.filter(afiliado => {
        const texto = [
            afiliado.nombres,
            afiliado.aPaterno,
            afiliado.aMaterno,
            afiliado.curp,
            afiliado.seccion,
            afiliado.casilla,
            afiliado.promotor
        ].join(' ').toLocaleLowerCase('es-MX');

        return texto.includes(busqueda);
    });

    renderizarTabla(filtrados);
}

function formatearFecha(fecha) {
    if (!fecha) return 'N/A';

    const valor = String(fecha).replace(' ', 'T');
    const date = new Date(valor);

    if (Number.isNaN(date.getTime())) return fecha;

    return date.toLocaleDateString('es-MX', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });
}

function escaparHTML(valor) {
    return String(valor ?? '').replace(/[&<>"']/g, caracter => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    })[caracter]);
}
