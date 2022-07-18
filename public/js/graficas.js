//capturar en un constante para el contenedor del ID MyChart
//Fon size para el Cambio de TODO el TAMAÑO de la Letra del GRAFICO
Chart.defaults.font.size = 14;
const ctx= document.getElementById('MyChart')
const ctx2= document.getElementById('MyChart2')
//Se coloca en una constante para luego se llamada en la DATA
const mes = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
//La grafica esta por Porcentaje, lo que significa que x sera lo que vale por cada Mes
const x =['8','15','32','185','25','30','25','22','3','4','30','30']

const myChart = new Chart(ctx, {
    type: 'bar',
    data:{
        labels: mes,
        datasets: [{
            barThickness: 30,
            label: 'Vista EJ // Ventas por Mes del Año 2022',
            data: x,
            backgroundClor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 2.0 
        }]
       
    }
    
})

const myChart2 = new Chart(ctx2, {
    type: 'bar',
    data:{
        labels: mes,
        datasets: [{
            barThickness: 30,
            label: 'Vista EJ // Ventas por Mes del Año 2022',
            data: x,
            backgroundClor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 2.0 
        }]
       
    }
    
})