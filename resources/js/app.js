require('./bootstrap');


/*  Navigatie rubrieken */
var categoriesMenuElement = document.querySelector("#category-container-parent");
var categoriesCopyElement = document.querySelector("#category-container-copy");

if(categoriesMenuElement){
    function hideChildren(parent) {
        var children = parent.parentElement.querySelectorAll(":scope>a,:scope>div");
        for (var i = 0; i < children.length; i++) {
            if (children[i].classList.contains("d-block")) {
                children[i].classList.remove("d-block");
                children[i].classList.add("d-none");
            }
        }
    }

    function toggleSubMenu() {
        var children = this.parentElement.querySelectorAll(":scope>a,:scope>div");
        for (var i = 0; i < children.length; i++) {
            if (children[i].classList.contains("d-block")) {
                children[i].classList.remove("d-block");
                children[i].classList.add("d-none");
            } else {
                children[i].classList.remove("d-none");
                children[i].classList.add("d-block");
            }
        }
    }

    var hoverables = document.querySelectorAll(".clickable-submenu");
    for (var i = 0; i < hoverables.length; i++) {
        hoverables[i].addEventListener('click', toggleSubMenu);
    }

    function closeAllHoverablesChildren(){
        for (var i = 0; i < hoverables.length; i++) {
            hideChildren(hoverables[i]);
        }
    }

    document.addEventListener('click', function (event) {
        var isClickInside = categoriesMenuElement.contains(event.target);

        if (!isClickInside) {
            closeAllHoverablesChildren();
        }
    });

    function debounce(func) {
        var timer;
        return function (event) {
            if (timer) clearTimeout(timer);
            timer = setTimeout(func, 100, event);
        };
    }

    function setNavCopySize() {
        categoriesCopyElement.style.height = categoriesMenuElement.offsetHeight + "px";
    }

    window.addEventListener("resize", debounce(function (e) {
        closeAllHoverablesChildren();
        setNavCopySize();
    }));

    window.addEventListener('load', function () {
        setNavCopySize();
    });
}
/*  Navigatie rubrieken einde */

/* Beoordeling rating selecteren */
var ratingDiv = document.querySelector("div.rating");
if(ratingDiv){
    var ratingInputs = ratingDiv.querySelectorAll(".rating input");
    for(var i = 0; i < ratingInputs.length; i++){
        ratingInputs[i].addEventListener("change", function(){
            var ratingLabels = ratingDiv.querySelectorAll(".rating .fa-star");
            for(var x = 0; x < ratingLabels.length; x++) {
                if(ratingLabels[x].querySelector("input").value <= this.value){
                    ratingLabels[x].classList.remove("far", "fa-star");
                    ratingLabels[x].classList.add("fa", "fa-star");
                }else{
                    ratingLabels[x].classList.remove("fa", "fa-star");
                    ratingLabels[x].classList.add("far", "fa-star");
                }
            }
        });
    }
}
/* Beoordeling rating selecteren einde */
