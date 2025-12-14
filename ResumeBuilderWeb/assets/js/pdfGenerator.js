function generatePDF(elementId, filename = 'resume.pdf') {
    const element = document.getElementById(elementId);
    const opt = {
        margin: 10,
        filename: filename,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    
    html2pdf().from(element).set(opt).save();
}

function openPDFInNewWindow(elementId, filename = 'resume.pdf') {
    const element = document.getElementById(elementId);
    const opt = {
        margin: 10,
        filename: filename,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    
    html2pdf().from(element).set(opt).outputPdf('blob').then(pdf => {
        const url = URL.createObjectURL(pdf);
        window.open(url, '_blank');
    });
}