const path = require('path');

/**
 * validacion.test.js
 * Pruebas con Jest + jsdom para validacion.js (ubicado en la misma carpeta)
 */

function loadScriptAndTriggerDOMContentLoaded() {
    // require el script (registra un listener DOMContentLoaded)
    require('./validacion.js');
    // Dispara el evento para que se ejecute el handler DOMContentLoaded del script
    document.dispatchEvent(new Event('DOMContentLoaded', { bubbles: true }));
}

function createFileInput(name, fileName) {
    const wrapper = document.createElement('div');
    wrapper.className = 'caja-preview';
    const input = document.createElement('input');
    input.type = 'file';
    input.name = name;
    // Crea un File y lo adjunta mediante DataTransfer (soportado en jsdom)
    const file = new File(['content'], fileName || `${name}.jpg`, { type: 'image/jpeg' });
    const dt = new DataTransfer();
    dt.items.add(file);
    Object.defineProperty(input, 'files', { value: dt.files, configurable: true });
    wrapper.appendChild(input);
    return { wrapper, input, file };
}

function setupBasicForm(overrides = {}) {
    // Limpiar el body del documento
    document.body.innerHTML = '';

    const form = document.createElement('form');
    form.id = 'form-AggSom';
    form.action = overrides.action || '/test-endpoint';

    // Inputs de texto
    ['NombreSombrero', 'ColorSombrero', 'MaterialSombrero'].forEach(name => {
        const inp = document.createElement('input');
        inp.name = name;
        inp.type = 'text';
        form.appendChild(inp);
    });

    // Selects
    ['HormaSombrero', 'CopaSombrero'].forEach(name => {
        const sel = document.createElement('select');
        sel.name = name;
        const optNull = document.createElement('option'); optNull.value = 'Null'; optNull.text = '---';
        const optOk = document.createElement('option'); optOk.value = 'ok'; optOk.text = 'OK';
        sel.appendChild(optNull); sel.appendChild(optOk);
        form.appendChild(sel);
    });

    // Inputs numéricos
    ['PrecioSombrero', 'TamañoCopaSombrero', 'TamañoAlaSombrero'].forEach(name => {
        const inp = document.createElement('input');
        inp.name = name;
        inp.type = 'number';
        form.appendChild(inp);
    });

    // Inputs de archivo 1..4
    for (let i = 1; i <= 4; i++) {
        const { wrapper } = createFileInput(`imgSombrero${i}`, `img${i}.jpg`);
        form.appendChild(wrapper);
    }

    // Submit
    const submit = document.createElement('input');
    submit.type = 'submit';
    submit.value = 'Guardar';
    form.appendChild(submit);

    // Contenedor del modal donde se añade mensaje-error-js
    const modalContent = document.createElement('div');
    modalContent.className = 'modal-content-AggSom';

    document.body.appendChild(form);
    document.body.appendChild(modalContent);

    return form;
}

beforeEach(() => {
    jest.resetModules();
    // resetear DOM
    document.body.innerHTML = '';
    // mock de alert y location.reload por defecto
    global.alert = jest.fn();
    global.location = { reload: jest.fn() };
});

afterEach(() => {
    jest.restoreAllMocks();
});

test('muestra errores cuando los campos obligatorios están vacíos y marca las vistas previas de imagen', () => {
    const form = setupBasicForm();
    // Dejar inputs de texto vacíos, selects por defecto 'Null', inputs num vacíos, los file inputs ya tienen archivos por el helper -> eliminar archivos para simular ausencia
    // Eliminar archivos de imgSombrero1..4
    form.querySelectorAll('.caja-preview input[type="file"]').forEach(input => {
        Object.defineProperty(input, 'files', { value: [], configurable: true });
    });

    loadScriptAndTriggerDOMContentLoaded();

    // Disparar submit
    form.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));

    const msgBox = document.getElementById('mensaje-error-js');
    expect(msgBox).not.toBeNull();
    expect(msgBox.style.display).toBe('block');

    // Comprobar que la clase caja-error se añadió a cada preview (archivos faltantes)
    const cajas = form.querySelectorAll('.caja-preview');
    cajas.forEach(c => {
        expect(c.classList.contains('caja-error')).toBe(true);
    });

    // Al menos un input-error debería estar presente para inputs de texto requeridos
    const anyInputError = form.querySelector('.input-error');
    expect(anyInputError).not.toBeNull();
});

test('detecta archivos de imagen duplicados y marca la vista previa duplicada', () => {
    const form = setupBasicForm();

    // Rellenar texto y números válidos para evitar otros errores
    form.querySelector('[name="NombreSombrero"]').value = 'Sombrero Bonito';
    form.querySelector('[name="ColorSombrero"]').value = 'Rojo';
    form.querySelector('[name="MaterialSombrero"]').value = 'Fieltro';
    form.querySelector('[name="HormaSombrero"]').value = 'ok';
    form.querySelector('[name="CopaSombrero"]').value = 'ok';
    form.querySelector('[name="PrecioSombrero"]').value = '100';
    form.querySelector('[name="TamañoCopaSombrero"]').value = '10';
    form.querySelector('[name="TamañoAlaSombrero"]').value = '5';

    // Establecer archivos: img1 y img2 mismo nombre de archivo
    const inputs = Array.from(form.querySelectorAll('.caja-preview input[type="file"]'));
    const fileA = new File(['a'], 'duplicate.jpg', { type: 'image/jpeg' });
    const fileB = new File(['b'], 'duplicate.jpg', { type: 'image/jpeg' });
    const fileC = new File(['c'], 'unique1.jpg', { type: 'image/jpeg' });
    const fileD = new File(['d'], 'unique2.jpg', { type: 'image/jpeg' });

    const dt1 = new DataTransfer(); dt1.items.add(fileA); Object.defineProperty(inputs[0], 'files', { value: dt1.files, configurable: true });
    const dt2 = new DataTransfer(); dt2.items.add(fileB); Object.defineProperty(inputs[1], 'files', { value: dt2.files, configurable: true });
    const dt3 = new DataTransfer(); dt3.items.add(fileC); Object.defineProperty(inputs[2], 'files', { value: dt3.files, configurable: true });
    const dt4 = new DataTransfer(); dt4.items.add(fileD); Object.defineProperty(inputs[3], 'files', { value: dt4.files, configurable: true });

    loadScriptAndTriggerDOMContentLoaded();

    // Submit
    form.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));

    // Esperar que el cuadro de mensaje muestre error genérico
    const msgBox = document.getElementById('mensaje-error-js');
    expect(msgBox).not.toBeNull();
    expect(msgBox.style.display).toBe('block');

    // El duplicado debería tener su clase .caja-error (el segundo duplicado)
    const previews = form.querySelectorAll('.caja-preview');
    expect(previews[1].classList.contains('caja-error')).toBe(true);
});

test('envía el formulario cuando todos los campos son válidos y maneja respuesta exitosa del servidor', async () => {
    const form = setupBasicForm();

    // Rellenar valores válidos
    form.querySelector('[name="NombreSombrero"]').value = 'Sombrero OK';
    form.querySelector('[name="ColorSombrero"]').value = 'Negro';
    form.querySelector('[name="MaterialSombrero"]').value = 'Cuero';
    form.querySelector('[name="HormaSombrero"]').value = 'ok';
    form.querySelector('[name="CopaSombrero"]').value = 'ok';
    form.querySelector('[name="PrecioSombrero"]').value = '250';
    form.querySelector('[name="TamañoCopaSombrero"]').value = '12';
    form.querySelector('[name="TamañoAlaSombrero"]').value = '7';

    // Archivos únicos
    const inputs = Array.from(form.querySelectorAll('.caja-preview input[type="file"]'));
    inputs.forEach((input, idx) => {
        const f = new File([`d${idx}`], `u${idx}.jpg`, { type: 'image/jpeg' });
        const dt = new DataTransfer(); dt.items.add(f);
        Object.defineProperty(input, 'files', { value: dt.files, configurable: true });
    });

    // Mock de fetch para devolver JSON de éxito
    global.fetch = jest.fn().mockResolvedValue({
        json: async () => ({ success: true, message: 'Guardado' })
    });

    // Espiar form.reset y cierre de modal (id del modal en el script: modal-AggSombrero)
    const modal = document.createElement('div');
    modal.id = 'modal-AggSombrero';
    document.body.appendChild(modal);

    loadScriptAndTriggerDOMContentLoaded();

    // Submit
    form.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));

    // Esperar al siguiente tick para permitir resolver la cadena de promesas
    await Promise.resolve();

    // Esperar que fetch haya sido llamado con la acción y método POST
    expect(global.fetch).toHaveBeenCalled();
    const fetchCallArgs = global.fetch.mock.calls[0];
    expect(fetchCallArgs[0]).toBe('/test-endpoint');
    // Asegurar que alert fue mostrado con el mensaje del servidor
    expect(global.alert).toHaveBeenCalledWith(expect.stringContaining('Guardado'));
    // Asegurar que se intentó recargar la ubicación
    expect(global.location.reload).toHaveBeenCalled();
});
