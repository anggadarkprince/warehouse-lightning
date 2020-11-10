import QrScanner from "../modules/qr-scanner";
import Goods from "../modules/stocks/goods";
import Container from "../modules/stocks/container";

if (document.getElementById('modal-qr-scanner')) {
    QrScanner();
}
if (document.getElementById('form-unloading-job')) {
    const buttonToggleUnloadingJob = document.getElementById('btn-toggle-unloading-job');
    const formUnloadingJob = document.getElementById('form-unloading-job');

    buttonToggleUnloadingJob.addEventListener('click', function() {
        formUnloadingJob.classList.toggle('hidden');
        if(!formUnloadingJob.classList.contains('hidden')) {
            formUnloadingJob.scrollIntoView({behavior: 'smooth', block: 'nearest'});
        }
    });

    Container();
    Goods();
}
