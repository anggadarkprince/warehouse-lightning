import EditorContainer from "../modules/editors/container";
import EditorGoods from "../modules/editors/goods";
import StockContainer from "../modules/stocks/container";
import StockGoods from "../modules/stocks/goods";

if (document.getElementById('form-tally-unloading')) {
    EditorContainer();
    EditorGoods();
}

if (document.getElementById('form-tally-loading')) {
    StockContainer();
    StockGoods();
}
