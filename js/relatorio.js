function downloadPDF() {
  const item = document.querySelector('.content-relat')

  var opt = {
    margin: 0,
    filename: 'relatorio.pdf',
    html2canvas: { scale: 1 },
    css_media_type: 'screen',

    jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
  }

  html2pdf().set(opt).from(item).save()
}
