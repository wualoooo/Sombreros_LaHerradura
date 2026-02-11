const cpInput = document.getElementById("cp");

if (cpInput) {
  cpInput.addEventListener("input", function () {
    let cp = this.value;

    if (cp.length === 5) {

      fetch("/LaHerradura/Controller/BuscarCP.php?cp=" + cp)
        .then(response => {
          if (!response.ok) {
            throw new Error("Error en la red o archivo no encontrado");
          }
          return response.json();
        })
        .then(data => {
          console.log("Datos recibidos:", data); 
          
          if (!data.error) {
            document.getElementById("estado").value = data.estado;
            document.getElementById("municipio").value = data.municipio;

            let coloniaSelect = document.getElementById("colonia");
            coloniaSelect.innerHTML = "";

            data.colonias.forEach(colonia => {
              let option = document.createElement("option");
              option.value = colonia;
              option.textContent = colonia;
              coloniaSelect.appendChild(option);
            });
          } else {
            console.warn("CP no encontrado en BD");
          }
        })
        .catch(error => console.error("Error en el fetch:", error));
    }
  });
} else {
  console.error("El input con ID 'cp' no se encontró. Revisa si el script carga después del HTML.");
}