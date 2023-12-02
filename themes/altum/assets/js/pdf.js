const adjunta = () => {
    const pdf = document.getElementById('pdf');
    const archivoInput = document.getElementById('archivo');
    
    if (fileValidation(archivoInput)) {
        const seleccionadoArray = archivoInput.value.split(/\\/);
        const archivo = seleccionadoArray.pop();
        pdf.value = `https://h01-qr.tubeat.pro/files/${archivo}`;
        pdf.dispatchEvent(new Event('change'));
    }
};

function fileValidation(fileInput) {
    const filePath = fileInput.value;
    const allowedExtensions = /(.pdf)$/i;

    if (!allowedExtensions.exec(filePath)) {
        alert('Por favor, sube un archivo con la extensión .pdf únicamente.');
        fileInput.value = '';
        return false;
    }

    return true;
}
