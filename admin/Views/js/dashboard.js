
$('#year, #qtr').change(function (e) { 
    e.preventDefault();
    getPopulations()
    getPurokPopulationChart()
});


let getPopulationsAttempt = 0
let getPopulationsByPurokAttempt = 0

function getPopulations() {
    $.ajax({
        type: "GET",
        url: "submits/appRequests.php?action=getPopulations",
        data: {
            'year': $('#year').val(),
            'qtr': $('#qtr').val(),
        },
        dataType: "JSON",
        beforeSend: function () {
            if (getPopulationsAttempt == 0) {
                showLoadingContent('#numberOfPopulation')
                showLoadingContent('#numberOfHouseholds')
            }
        },
        success: function (response) {
            setTimeout(() => {
                getPopulationsAttempt = 0;
                $('#numberOfPopulation').html('<span class="fade_in">'+response.citizens+'</span>');
                $('#numberOfHouseholds').html('<span class="fade_in">'+response.households+'</span>');

                // console.log(response.datas)
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                if (getPopulationsAttempt <= 3) {
                    getPopulationsAttempt++;
                    getPopulations();
                } else {
                    getPopulationsAttempt = 0;
                    console.log(err)
                    $('#numberOfPopulation').html("")
                    $('#numberOfHouseholds').html("")
                }
            }, timeout);
        }
    });
}
getPopulations()



let popUlationBar = null;
function getPurokPopulationChart() {

    $.ajax({
        type: "GET",
        url: "submits/appRequests.php?action=getPopulationsByPurok",
        data: {
            'year': $('#year').val(),
            'qtr': $('#qtr').val(),
        },
        dataType: "JSON",
        beforeSend: function () {
            if (getPopulationsByPurokAttempt == 0) {
                showLoadingContent('.chart_container_loader');
            }
            if (popUlationBar != null) {
                popUlationBar.destroy()
                popUlationBar = null;
            }
        },
        success: function (response) {
            setTimeout(() => {
                getPopulationsByPurokAttempt = 0
                hideLoadingContent('.chart_container_loader')
                console.log(response)
                generatePurokPopulationChart(response)
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                if (getPopulationsByPurokAttempt++ <= 3) {
                    getPurokPopulationChart();
                } else {
                    hideLoadingContent('.chart_container_loader')
                    getPopulationsByPurokAttempt = 0;
                    console.log(err)
                }
            }, timeout);
        },
    });
}
function generatePurokPopulationChart(data) {

    if (popUlationBar != null) {
        popUlationBar.destroy()
        popUlationBar = null;
    }

    const xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
    const yValues = [55, 49, 44, 24, 15];
    const barColors = ["red", "green","blue","orange","brown"];

    popUlationBar = new Chart(document.getElementById('popUlationBar'), {
        type: 'bar',
        data: {
          labels: data.labels,
          datasets: data.datasets
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          // plugins: {
          //     legend: {
          //         display: false
          //     },
          //     datalabels: {
          //         display: true,
          //         anchor: 'end',
          //         align: 'top',
          //         formatter: (value) => value,
          //         color: '#000',
          //         font: {
          //             weight: 'bold',
          //             size: 12
          //         },
          //         offset: 4
          //     }
          // },
  
          plugins: {
              legend: {
                  display: true,
                  position: 'top',
                  align: 'center',
                  labels: {
                      boxWidth: 14,
                      boxHeight: 14,
                  },
              },
              tooltip: {
                  enabled: true,
                  backgroundColor: '#fff',
                  titleColor: '#000',
                  bodyColor: '#000'
              },
              datalabels: {
                  formatter: (value, content) => {
                      // if (value == 0){
                      //     return "0%"
                      // } else {
  
  
                      //     let datapoints = content.chart.data.datasets[0].data
                      //     let total = datapoints.reduce((total, datapoint) => total + datapoint, 0)
                      //     let percentages = value / total * 100
                      //     let percentage = percentages.toFixed(1) + "%"
                      //     let label = content.chart.data.labels[content.dataIndex];
  
  
                      //     return percentage
                      // }
  
                      return value.toLocaleString();
                  },
                  color: "#000",
                  anchor: 'end',
                  align: 'top',
                  offset: 4, // Adjust this value to position the label further away or closer to the top of the bar
                  
              }
          }
        },
        plugins: [ChartDataLabels]
  
      });
}
getPurokPopulationChart()