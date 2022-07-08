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
    var titulo_profile = document.getElementById('tituloProfile');
    var profile_sidebar = document.getElementById('profileSidebar');
    var profile_ancla = document.getElementById('profileAncla');
    var content = document.getElementById('content');

    let timeline = gsap.timeline(); // Timeline de GSAP ( Para animaciones )

    /* Sidebar is desappear */

    if (!sidebar.classList.contains('sidebarCollected')){
        
        sidebar.classList.add('sidebarCollected');
        sidebar_header.classList.remove('sidebarHeader');
        sidebar_header.classList.add('sidebarHeaderCollect');
        content.classList.remove('content');
        content.classList.add('contentCollect');

        /* Adding Element Styles */
        dropbox.style.display = "none";
        complementarios.style.display = "none";
        complementario_hidden.style.display = "block";
        company_title.style.display = "none";
        sidebar_header.style.width = "60px";
        menu_icon.style.display = "none";
        menu_icon_back.style.display = "flex";
        titulo_profile.style.display = "none";
        profile_sidebar.style.width = "60px";
        profile_sidebar.style.justifyContent = "center";
        profile_ancla.style.marginRight = "10px";

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

            /* Adding Element Styles */
            dropbox.style.display = "flex";
            complementarios.style.display = "block";
            complementario_hidden.style.display = "none";
            company_title.style.display = "block";
            sidebar_header.style.width = "200px";
            menu_icon.style.display = "flex";
            menu_icon_back.style.display = "none";
            titulo_profile.style.display = "flex";
            profile_sidebar.style.width = "200px";
            profile_sidebar.style.justifyContent = "flex-start";
            
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
        timeline.to("#complementarios", {duration: 0, maxHeight: "0px"}) // Sequence start
            .to(element, {duration: 0, backgroundColor: "#323232"})
            .to("#complementarios", {duration: 0.30, maxHeight: "200px"}) 
        state = "dropped";
    }

    else {
        timeline.to("#complementarios", {duration: 0, maxHeight: "200px"}) // Sequence start
            .to(element, {duration: 0, background: "#1A1A1A"})
            .to("#complementarios", {duration: 0.30, maxHeight: "0px"})
        state = "collect";
    }
}

/* On window resize (to restart styles)*/

function reportWindowSize() {

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
    var titulo_profile = document.getElementById('tituloProfile');
    var profile_sidebar = document.getElementById('profileSidebar');

    var w = window.innerWidth;

    for(var i = 0; i < span_deployed.length; i++) {
        span_deployed[i].classList.remove('textElementMenuCollected');
        span_deployed[i].classList.add('textElementMenu');
    }

    if(w >= 1024) {
        var sidebar = document.getElementById('sidebar');
        var sidebar_header = document.getElementById('sidebarHeader');
        sidebar.style.left = "0px";
        sidebar.style.width = "200px";
        sidebar_header.style.left = "0px";
        sidebar_header.style.width = "200px";
        sidebar.classList.remove('sidebarResponsive');
        sidebar_header.classList.remove('sidebarHeader');
        sidebar_header.classList.add('sidebarHeader');
        sidebar.classList.remove('sidebarCollected');
            
        /* Adding Element Styles */
        dropbox.style.display = "flex";
        complementarios.style.display = "block";
        complementario_hidden.style.display = "none";
        company_title.style.display = "block";
        sidebar_header.style.width = "200px";
        menu_icon.style.display = "flex";
        menu_icon_back.style.display = "none";
        titulo_profile.style.display = "flex";
        profile_sidebar.style.width = "200px";
        profile_sidebar.style.justifyContent = "flex-start";
    }

    if(w < 1024){

        var sidebar = document.getElementById('sidebar');
        var sidebar_header = document.getElementById('sidebarHeader');
        sidebar.style.left = "-250px";
        sidebar.style.width = "250px";
        sidebar_header.style.left = "-250px";
        sidebar_header.style.width = "250px";
        sidebar_header.classList.remove('sidebarHeaderCollect');
        sidebar_header.classList.add('sidebarHeader');
        sidebar.classList.remove('sidebarCollected');

        /* Adding Element Styles */
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