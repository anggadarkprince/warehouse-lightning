import QrScanner from "../modules/qr-scanner";
import Goods from "../modules/stocks/goods";
import Container from "../modules/stocks/container";

if (document.getElementById('modal-qr-scanner')) {
    QrScanner();
}
if (document.getElementById('form-gate')) {
    Container();
    Goods();
}
