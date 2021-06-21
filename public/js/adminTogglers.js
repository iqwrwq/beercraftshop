addRowButton = document.querySelector("#add-btn");
overlay = document.querySelector("#overlay");
addItemForm = document.querySelector("#add-item-form");
addItemInnerForm = document.querySelector("#inner-form");

addRowButton.addEventListener("click", () => {
    addItemForm.classList.remove("hide");
    overlay.classList.remove("hide");
    window.addEventListener('click', function (e) {
        if (overlay.contains(e.target)) {
            addItemInnerForm.reset();
            addItemForm.classList.add("hide");
            overlay.classList.add("hide");
        }
    });
})
changeBtn = document.querySelector("#changeBtn");
changeItemForm = document.querySelector("#change-item-form");
changeItemInnerForm = document.querySelector("#inner-change-form");
itemRows = document.querySelectorAll('.item-row');
itemRows.forEach(element => {
    element.addEventListener("click", () => {
        changeItemForm.classList.remove("hide");
        overlay.classList.remove("hide");
        changeBtn.disabled = true;
        document.querySelector("#oldNameField").value = element.cells[1].innerHTML;
        document.querySelector("#oldDescField").value = element.cells[2].innerHTML;
        document.querySelector("#oldImageField").value = element.cells[3].innerHTML;
        document.querySelector("#oldAlcoholContentField").value = element.cells[4].innerHTML;
        document.querySelector("#oldPriceField").value = element.cells[5].innerHTML;

        document.querySelector("#changeFormNameField").value = element.cells[1].innerHTML;
        document.querySelector("#changeFormDescField").value = element.cells[2].innerHTML;
        document.querySelector("#selectedItemImage").src = "/BeerCraftShop/public/resources/images/products/" + element.cells[3].innerHTML + ".jpg";
        document.querySelector("#changeFormAlcoholContentField").value = element.cells[4].innerHTML;
        document.querySelector("#changeFormPriceField").value = element.cells[5].innerHTML;
        document.querySelector("#changeFormNameField").addEventListener("change", () => {
            unlockChangeButton();
        });
        document.querySelector("#changeFormDescField").addEventListener("change", () => {
            unlockChangeButton()
        });
        document.querySelector("#changeFormImageField").addEventListener("change", () => {
            unlockChangeButton()
        });
        document.querySelector("#changeFormAlcoholContentField").addEventListener("change", () => {
            unlockChangeButton()
        });
        document.querySelector("#changeFormPriceField").addEventListener("change", () => {
            unlockChangeButton();
        });


        window.addEventListener('click', function (e) {
            if (overlay.contains(e.target)) {
                changeItemInnerForm.reset();
                changeItemForm.classList.add("hide");
                overlay.classList.add("hide");
            }
        });
    })
});

function unlockChangeButton() {
    changeBtn.disabled = false;
}

function displayLoadingOverlay() {
    document.querySelector("#loading-overlay").style.display = "grid";
}