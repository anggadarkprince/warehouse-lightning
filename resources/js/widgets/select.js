import Choices from "choices.js";

function stringToBoolean(string) {
    switch (string.toLowerCase().trim()) {
        case "true":
        case "yes":
        case "1":
            return true;
        case "false":
        case "no":
        case "0":
        case null:
            return false;
        default:
            return Boolean(string);
    }
}

const selects = document.querySelectorAll('.select-choice:not([disabled])');
if (selects) {
    selects.forEach(select => {
        select.choices = new Choices(select, {
            placeholderValue: select.dataset.placeholder || "Select a data",
            searchPlaceholderValue: select.dataset.seachPlaceholder || "Search for a record",
            noResultsText: select.dataset.noResultText || "No data available",
            itemSelectText: select.dataset.itemSelectedText || "",
            removeItemButton: stringToBoolean(select.dataset.searchEnable || 'false'),
            searchEnabled: stringToBoolean(select.dataset.searchEnable || 'true'),
            searchResultLimit: 5,
            shouldSort: false,
        });
    });
}
