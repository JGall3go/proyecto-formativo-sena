
function resetValue(element, newValue){
    // Date reset value
    element.setAttribute('value', newValue);
}

function showForm(){
    const forms = document.getElementsByClassName('forms');
    const createForm = document.getElementsByClassName('createForm');
    const updateForm = document.getElementsByClassName('updateForm');
    const body = document.querySelector("body");

    if(forms[0].style.display != 'flex'){

        let timeline = gsap.timeline(); // Timeline de GSAP ( Para animaciones )
        timeline.to(forms[0], {duration: 0.20, display: 'flex'}, 0) // Sequence start
            .to(createForm[0], {duration: 0, display: 'flex'}, 0)

        body.style.overflow = 'hidden'; // No se puede hacer scroll al fondo

    } else {

        forms[0].style.display = 'none';
        createForm[0].style.display ='none';
        updateForm[0].style.display ='none';

        body.style.overflow = 'auto'; // Se puede hacer scroll al fondo
    }
}

function selectColor(element) {
    element.style.color = '#686666'
    console.log(element.value)
}

// Arrastrar y soltar imagenes
const initApp = () => {

    for(i = 1; i < 2; i++){

        const dropArea = document.querySelector(`.dropArea-${i}`);
        const inputElement = dropArea.querySelector('.dropAreaInput');

        // Clase con estilos que se le aplicara al elemento cuando haya algo arriba.
        const active = () => dropArea.classList.add("dropAreaOver");
        const inactive = () => dropArea.classList.remove("dropAreaOver");

        const prevents = (e) => e.preventDefault();

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(evt => {
            dropArea.addEventListener(evt, prevents);
        });

        ['dragenter', 'dragover'].forEach(evt => {
            dropArea.addEventListener(evt, active);
        });

        ['dragleave', 'drop'].forEach(evt => {
            dropArea.addEventListener(evt, inactive);
        });

        // Cuando se suelte un archivo en el contenedor se pondra de fondo
        dropArea.addEventListener("drop", (e) => {
            if (e.dataTransfer.files.length) {
            handleDrop(e.dataTransfer.files[0]);
            }
        });

        // Cuando se haga click en el contenedor se pondra la ventana para buscar la imagen
        const inputClick = () => inputElement.click();
        dropArea.addEventListener("click", inputClick);

        // Cuando se seleccione la imagen se pondra de fondo
        inputElement.addEventListener("change", (e) => {
            if (inputElement.files.length) {
                handleDrop(inputElement.files[0]);
            }
        });
    }
}

document.addEventListener("DOMContentLoaded", initApp);

function handleDrop(e) {

    const file = e;

    for(i = 1; i < 2; i++){

        const dropArea = document.querySelector(`.dropArea-${i}`);
        let thumbnail = dropArea.querySelector('.dropAreaImage');
        let updateDefaultImage = document.querySelector('.updateDefaultImage');

        // Se retira el texto
        if(dropArea.querySelector('.dropTextArea')) {
            dropArea.querySelector('.dropTextArea').remove();
        }

        // Se añade el espacio para poner la imagen
        if(!thumbnail) {
            thumbnail = document.createElement('div');
            image = document.createElement('img');
            thumbnail.classList.add('dropAreaImage');
            thumbnail.appendChild(image)
            dropArea.appendChild(thumbnail);
        }

        // Si la imagen ya existe
        if(updateDefaultImage) {
            updateDefaultImage.remove();
            image = document.createElement('img');
            thumbnail.appendChild(image)
        }

        // Si el archivo ingresado es una imagen
        if(file.type.startsWith('image/')){
            const reader = new FileReader();

            reader.readAsDataURL(file);
            reader.onload = () => {
                image.setAttribute('src', reader.result);
            };
        } else {
            thumbnail.style.backgroundImage = null;
        }
    }
}

function restartErrorLabel(label, display) {

    // Color del borde
    var color = "";
    if(display == "none") {
        color = "#c7c6c6";
    } else {
        color = "#ca5050";
    }

    if(label == "repeatedKey") { // Error de key repetida

        document.getElementById('repeatedKey').style.display = display;
        document.getElementById('addTagSection').style.borderColor = color;
        document.getElementById('tagger').style.borderBottomColor = color;
    }
}

// Tagger para guardar las keys de los productos
var keysArray = new Array(); // Array que contiene todas las keys
function createTag(event, form) {

    const input = document.getElementsByClassName('addTagInput');
    input[0].value = input[0].value.replace(/\s/g, '-');

    const tagger = document.getElementsByClassName('tagger');
    const tags = document.getElementsByClassName('tag');
    const count = document.getElementsByClassName('opaqueLabelText');
    const inputAllTags = document.getElementsByClassName('inputAllTags');
    const inputAmount = document.getElementById('inputAmount');

    // Si la tecla presionada es Enter entonces se creara el div
    if(event.key == "Enter" || event == "[object MouseEvent]" || event == "[object PointerEvent]") {

        restartErrorLabel("repeatedKey", "none");

        if(form == "create") {
            
            if(input[0].value != "" && keysArray.indexOf(input[0].value) === -1) {

                inputAllTags[0].value += `/${ input[0].value }`;
                tagger[0].innerHTML += `<div class="tag"><div class="tagNumber">${ tags.length + 1 }</div><div class="tagText">${ input[0].value }</div><div onclick="deleteTag(this, 'create')" class="tagButton"><svg xmlns="http://www.w3.org/2000/svg" class="deleteIcon" viewBox="0 0 512 512"><title>Eliminar</title><path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"/></svg></div></div>`;
                count[0].innerHTML = `- Cantidad ${ tags.length }`; // Se cambia la cantidad de tags que hay en total
                keysArray.push(input[0].value);
                inputAmount.value = tags.length;
                input[0].value = "";
            }
            
            if(keysArray.indexOf(input[0].value) !== -1){
                restartErrorLabel("repeatedKey", "flex");
            }
        }

        if(form == "edit") {

            if(input[1].value != "" && keysArray.indexOf(input[1].value) === -1) {

                console.log(inputAllTags[1].value);

                inputAllTags[1].value += `/${ input[1].value }`;
                tagger[1].innerHTML += `<div class="tag"><div class="tagNumber">${ tags.length + 1 }</div><div class="tagText">${ input[1].value }</div><div onclick="deleteTag(this, 'edit')" class="tagButton"><svg xmlns="http://www.w3.org/2000/svg" class="deleteIcon" viewBox="0 0 512 512"><title>Eliminar</title><path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"/></svg></div></div>`;
                count[1].innerHTML = `- Cantidad ${ tags.length }`; // Se cambia la cantidad de tags que hay en total
                keysArray.push(input[1].value);
                inputAmount.value = tags.length;
                input[1].value = "";
            }
            
            if(keysArray.indexOf(input[1].value) !== -1){
                restartErrorLabel("repeatedKey", "flex");
            }
        }
    }
}

function deleteTag(element, form) {

    const tagText = element.parentNode.getElementsByClassName('tagText');
    const inputAllTags = document.getElementsByClassName('inputAllTags');

    if(form == "create") {

        console.log("delete")

        // Se elimina la key del valor del input (inputAllTags)
        inputAllTags[0].value = inputAllTags[0].value.replace(`/${tagText.innerHTML}`, '');
        keysArray = keysArray.filter(e => e !== tagText.innerHTML); // Se elimina el Key del Array

        // Se eliminan los elementos con la misma Id
        element.parentNode.remove();

        const tagNumber = document.getElementsByClassName('tagNumber');
        const count = document.getElementsByClassName('opaqueLabelText');
        const inputAmount = document.getElementById('inputAmount');
        inputAmount.value = tagNumber.length;
        count[0].innerHTML = `- Cantidad ${ tagNumber.length }`; // Se cambia la cantidad de tags que hay en total

        // Se reorganizan los numeros de las tags con respecto a la cantidad
        for(i = 0; i < tagNumber.length; i++) {
            tagNumber[i].innerHTML = i+1;
        }
    }

    if(form == "edit") {

        // Se elimina la key del valor del input (inputAllTags)
        inputAllTags[1].value = inputAllTags[1].value.replace(`/${tagText.innerHTML}`, '');
        keysArray = keysArray.filter(e => e !== tagText.innerHTML); // Se elimina el Key del Array

        // Se eliminan los elementos con la misma Id
        element.parentNode.remove();

        const tagNumber = document.getElementsByClassName('tagNumber');
        const count = document.getElementsByClassName('opaqueLabelText');
        const inputAmount = document.getElementById('inputAmount');
        inputAmount.value = tagNumber.length;
        count[1].innerHTML = `- Cantidad ${ tagNumber.length }`; // Se cambia la cantidad de tags que hay en total

        // Se reorganizan los numeros de las tags con respecto a la cantidad
        for(i = 0; i < tagNumber.length; i++) {
            tagNumber[i].innerHTML = i+1;
        }
    }
}