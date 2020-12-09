require('./bootstrap');


/*  Navigatie rubrieken */
var categoriesMenuElement = document.querySelector("#category-container-parent");
var categoriesCopyElement = document.querySelector("#category-container-copy");

if (categoriesMenuElement) {
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

    function closeAllHoverablesChildren() {
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

/* Auction rubrieken selectie */
window.categorySelect = function (level) {
    var field = document.querySelector("select[c-level='" + level + "']");
    var fielsNo = parseInt(field.value);
    var fields = document.querySelectorAll("select[name='category[]']");
    for (var i = 0; i < fields.length; i++) {
        if(parseInt(fields[i].getAttribute("c-level")) > parseInt(level)){
            fields[i].parentNode.remove();
        }
    }
    if (fielsNo > -1) {
        addCategorySelect(fielsNo);
    }
}

function addCategorySelect(categoryId){
    var fields = document.querySelectorAll("select[name='category[]']");
    var maxId = 0;
    for (var i = 0; i < fields.length; i++) {
        var curInt = parseInt(fields[i].getAttribute("c-level"));
        if (curInt > maxId) {
            maxId = curInt;
        }
    }

    var categorySelectContainer = document.querySelector("#category-select-container");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var div = document.createElement('div');
            div.innerHTML = this.responseText;
            div.className = "mb-3 col-md-2";
            categorySelectContainer.appendChild(div);
        }
    };
    xhttp.open("GET", "/veilingmaken/categoryselect/" + categoryId +"/"+(maxId+1), true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}
/* Auction rubrieken selectie einde */
