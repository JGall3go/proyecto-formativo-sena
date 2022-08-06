var state = "collect";

window.onload = function load(){
}

function collectSidebar(element){

    /* Getting the variables */
    var dropbox = document.querySelector('dropbox');
    var sidebar = document.getElementById('sidebar');
    var span_deployed = document.querySelectorAll('[id=spanCollect]');
    var complementarios = document.getElementById('complementarios');
    var complementario_hidden = document.getElementById('complementariosHidden');
    var dropbox = document.getElementById('dropbox');
    var company_title = document.getElementById('companyTitle');
    var sidebar_header = document.getElementById('sidebarHeader');
    var menu_icon = document.getElementById('menuIcon');
    var menu_icon_back = document.getElementById('menuIconBack');
    var content = document.getElementById('content');
    var topBar = document.getElementById('topBar');

    let timeline = gsap.timeline(); // Timeline de GSAP ( Para animaciones )

    /* Sidebar is desappear */

    if (!sidebar.classList.contains('sidebarCollected')){
        
        sidebar.classList.add('sidebarCollected');
        sidebar_header.classList.remove('sidebarHeader');
        sidebar_header.classList.add('sidebarHeaderCollect');
        content.classList.remove('content');
        content.classList.add('contentCollect');
        topBar.classList.remove('topBar');
        topBar.classList.add('topBarCollected');

        /* Adding Element Styles */
        dropbox.style.display = "none";
        complementarios.style.display = "none";
        complementario_hidden.style.display = "block";
        company_title.style.display = "none";
        sidebar_header.style.width = "60px";
        menu_icon.style.display = "none";
        menu_icon_back.style.display = "flex";

        for(var i = 0; i < span_deployed.length; i++) {
            span_deployed[i].classList.remove('textElementMenu');
            span_deployed[i].classList.add('textElementMenuCollected');
        }

        timeline.to("#sidebar", {duration: 0, width: "200px"}) // Sequence start
            .to("#sidebar", {duration: 0, width: "60px"})
        
    } else {

        /* Sidebar is restart */

        if (sidebar.classList.contains('sidebarCollected')){

            sidebar.classList.remove('sidebarCollected');
            sidebar_header.classList.remove('sidebarHeaderCollect');
            sidebar_header.classList.add('sidebarHeader');
            content.classList.remove('contentCollect');
            content.classList.add('content');
            topBar.classList.remove('topBarCollected');
            topBar.classList.add('topBar');

            /* Adding Element Styles */
            dropbox.style.display = "flex";
            complementarios.style.display = "block";
            complementario_hidden.style.display = "none";
            company_title.style.display = "block";
            sidebar_header.style.width = "200px";
            menu_icon.style.display = "flex";
            menu_icon_back.style.display = "none";
            
            timeline.to("#sidebar", {duration: 0, width: "60px"}) // Sequence start
                .to("#sidebar", {duration: 0, width: "200px"})
            
            for(var i = 0; i < span_deployed.length; i++) {
                span_deployed[i].classList.remove('textElementMenuCollected');
                span_deployed[i].classList.add('textElementMenu');
            }
        }
    }
}

function collectSidebarResponsive(element){

    /* Getting the variables */
    var sidebar = document.getElementById('sidebar');
    
    let timeline = gsap.timeline(); // GSAP Timeline ( To animations )

    /* The sidebar appear */

    if (!sidebar.classList.contains('sidebarResponsive')){

        timeline.to(".sidebarHeader", {duration: 0.3, left: "0px", width: "250px"}, 0);
        timeline.to(".sidebar", {duration: 0.3, left: "0px", width: "250px"}, 0); // Sequence start 

        sidebar.classList.add('sidebarResponsive');

    }else {

        /* The sidebar desappear */

        if (sidebar.classList.contains('sidebarResponsive')){

            timeline.to(".sidebar", {duration: 0.3, left: "-250px", width: "250px"}, 0) // Sequence start
            timeline.to(".sidebarHeader", {duration: 0.3, left: "-250px", width: "250px"}, 0)

            sidebar.classList.remove('sidebarResponsive');
        }
    }
}

function dropMenu(element){

    let timeline = gsap.timeline(); // GSAP Timeline ( To animations )

    if(state == "collect"){
        timeline.to("#complementarios", {duration: 0, maxHeight: "0px"}, 0) // Sequence start
            .to(".rotateArrow", {duration: 0.3, rotation: 180}, 0)    
            .to(element, {duration: 0, backgroundColor: "#323232"}, 0)        
            .to("#complementarios", {duration: 0.30, maxHeight: "200px"}, 0) 
        state = "dropped";
    }

    else {
        timeline.to("#complementarios", {duration: 0, maxHeight: "200px"}, 0) // Sequence start
            .to(".rotateArrow", {duration: 0.3, rotation: 360}, 0)  
            .to(element, {duration: 0, background: "#1A1A1A"}, 0)
            .to("#complementarios", {duration: 0.30, maxHeight: "0px"}, 0)
        state = "collect";
    }
}

/* On window resize (to restart styles)*/

function reportWindowSize() {

    // Getting the variables
    var content = document.getElementById('content');
    var dropbox = document.querySelector('dropbox');
    var sidebar = document.getElementById('sidebar');
    var span_deployed = document.querySelectorAll('[id=spanCollect]');
    var complementarios = document.getElementById('complementarios');
    var complementario_hidden = document.getElementById('complementariosHidden');
    var dropbox = document.getElementById('dropbox');
    var company_title = document.getElementById('companyTitle');
    var sidebar_header = document.getElementById('sidebarHeader');
    var menu_icon = document.getElementById('menuIcon');
    var menu_icon_back = document.getElementById('menuIconBack');
    var titulo_profile = document.getElementById('tituloProfile');
    var profile_sidebar = document.getElementById('profileSidebar');
    var topBar = document.getElementById('topBar');

    var w = window.innerWidth;

    if(w >= 1024) {
        
        sidebar.style.left = "0";
        sidebar_header.style.left = "0";
        content.classList.remove('contentCollect');
        content.classList.add('content');

        if(sidebar.classList.contains('sidebarCollected')) {
            content.classList.remove('content');
            content.classList.add('contentCollect');
        }

        if(!sidebar.classList.contains('sidebarCollected')){
            sidebar.style.width = "200px";
            sidebar_header.style.width = "200px";
            content.classList.remove('contentCollect');
            content.classList.add('content');
            topBar.classList.remove('topBarCollected')
            topBar.classList.add('topBar')
        }

    }

    if(w < 1024){

        for(var i = 0; i < span_deployed.length; i++) {
            span_deployed[i].classList.remove('textElementMenuCollected');
            span_deployed[i].classList.add('textElementMenu');
        }

        var sidebar = document.getElementById('sidebar');
        var sidebar_header = document.getElementById('sidebarHeader');
        sidebar.style.left = "-250px";
        sidebar.style.width = "250px";
        sidebar_header.style.left = "-250px";
        sidebar_header.style.width = "250px";
        sidebar_header.classList.remove('sidebarHeaderCollect');
        sidebar_header.classList.add('sidebarHeader');
        sidebar.classList.remove('sidebarCollected');

        // Adding Element Styles
        dropbox.style.display = "flex";
        complementarios.style.display = "block";
        complementario_hidden.style.display = "none";
        company_title.style.display = "block";
        menu_icon.style.display = "flex";
        menu_icon_back.style.display = "none";
        titulo_profile.style.display = "flex";
        profile_sidebar.style.justifyContent = "flex-start";
    }
}
window.onresize = reportWindowSize;