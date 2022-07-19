const { create } = require("lodash");

function resetValue(element, newValue){
    // Date reset value
    element.setAttribute('value', newValue);
}

$(document).ready(function () {
    // Handler for .ready() called.
    if (window.location.href.indexOf("/edit") > -1) {
        $('html, body').animate({
            scrollTop: $('#lastInput').offset().top
        }, 'slow');
        $("#secondForm").css("box-shadow", "rgba(113, 130, 228, 0.50) 0px 1px 3px 0px, rgba(94, 114, 228, 0.50) 0px 0px 0px 1px");
    }    
});

function showForm(){
    var forms = document.getElementsByClassName('forms');
    var createForm = document.getElementsByClassName('createForm');
    var updateForm = document.getElementsByClassName('updateForm');

    if(forms[0].style.display != 'flex'){

        let timeline = gsap.timeline(); // Timeline de GSAP ( Para animaciones )
        timeline.to(forms[0], {duration: 0.20, display: 'flex', backgroundColor: '#3f3f3f85'}, 0) // Sequence start
            .to(createForm[0], {duration: 0, display: 'flex'}, 0)
    } else {
        forms[0].style.display = 'none';
        createForm[0].style.display ='none';
        updateForm[0].style.display ='none';

    }
}

function selectColor(element) {
    element.style.color = '#686666'
}