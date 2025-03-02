<button id="downloadReport" class="btn btn-primary">Descargar Reporte</button>

<div id="reportOptions" style="display: none;">
    <button id="downloadPDF" class="btn btn-secondary">Descargar PDF</button>
    <button id="downloadExcel" class="btn btn-secondary">Descargar Excel</button>
</div>

<script>
    document.getElementById('downloadReport').addEventListener('click', function() {
        document.getElementById('reportOptions').style.display = 'block';
    });

    document.getElementById('downloadPDF').addEventListener('click', function() {
        window.location.href = '/C:/xampp/htdocs/Inventario/controllers/descargarReporte.php?format=pdf';
    });

    document.getElementById('downloadExcel').addEventListener('click', function() {
        window.location.href = '/C:/xampp/htdocs/Inventario/controllers/descargarReporte.php?format=excel';
    });
</script>
