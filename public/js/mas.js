let hidBut = document.getElementById('hidBut');

let hidText = document.getElementById('hidText');

hidBut.addEventListener('click', toggleText);

function toggleText(){
    hidText.classList.toggle('show');

    if(hidText.classList.contains('show')){
        hidBut.innerHTML = ' - ';
    }else{
        hidBut.innerHTML = ' + ';
    }
}