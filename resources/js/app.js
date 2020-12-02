require('./bootstrap');





function hideChildren(parent) {
    var children = parent.parentElement.querySelectorAll(":scope>a,:scope>div");
    for (var i = 0; i < children.length; i++) {
        if (children[i].classList.contains("d-block")) {
            children[i].classList.remove("d-block");
            children[i].classList.add("d-none");
        }
    }
}

function toggleSubMenu(){
    var children = this.parentElement.querySelectorAll(":scope>a,:scope>div");
    for(var i = 0; i < children.length; i++){
        if(children[i].classList.contains("d-block")){
            children[i].classList.remove("d-block");
            children[i].classList.add("d-none");
        }else{
            children[i].classList.remove("d-none");
            children[i].classList.add("d-block");
        }
    }
}

var hoverables = document.querySelectorAll(".clickable-submenu");
for(var i = 0; i < hoverables.length; i++){
    hoverables[i].addEventListener('click', toggleSubMenu);
}

var categoriesMenuElement = document.querySelector(".category-container");

if(categoriesMenuElement){
    document.addEventListener('click', function(event) {
        var isClickInside = categoriesMenuElement.contains(event.target);

        if (!isClickInside) {
            for (var i = 0; i < hoverables.length; i++) {
                hideChildren(hoverables[i]);
            }
        }
    });
}
