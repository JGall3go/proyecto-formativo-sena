
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