// data Rythme cardiaque
const dataBPM = {
    datasets: [{
        label: 'BPM',
        data: [],
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'rgba(255, 99, 132, 1)',
        borderWidth: 1
    }]
};


// data Qualité de l'air
const dataPPM = {
    datasets: [{
        label: 'PPM',
        data: [],
        backgroundColor: 'rgb(6, 219, 28, 0.2)',
        borderColor: 'rgb(6, 219, 28)',
        borderWidth: 1
    }]
};

// data Température
const dataTc = {
    datasets: [{
        label: '°C',
        data: [],
        backgroundColor: 'rgb(255, 184, 0, 0.2)',
        borderColor: 'rgb(255, 184, 0)',
        borderWidth: 1
    }]
};

// data Décibel
const dataDB = {
    datasets: [{
        label: 'DB',
        data: [],
        backgroundColor: 'rgb(105, 166, 170, 0.2)',
        borderColor: 'rgb(105, 166, 170)',
        borderWidth: 1
    }]
};




// config block
function config(data, ymin, ymax, vmin, vmax) {
    const config = {
        type: 'line',
        data: data,
        options: {
            plugins: {
                streaming: {
                    duration: 20000,

                    refresh: 200,
                    // frameRate: 20
                }
            },
            interaction: {
                intersect: false
            },
            scales: {
                x: {
                    type: 'realtime',
                    realtime: {
                        onRefresh: chart => {
                            chart.data.datasets.forEach(dataset => {
                                dataset.data.push({
                                    x: Date.now(),
                                    y: Math.random() * (vmax - vmin) + vmin,
                                });
                            });
                        }
                    }

                },
                y: {
                    suggestedMin: ymin,
                    suggestedMax: ymax,
                }
            }
        }
    }
    return config
}
// Rythme cardique
const BPMChart = new Chart(
    document.getElementById('graphBPM'),
    config(dataBPM, 0, 200, 70, 180)
);

// Qualité de l'air
const PPMChart = new Chart(
    document.getElementById('graphPPM'),
    config(dataPPM, 400, 1600, 800, 1200)
);

// Température
const TcChart = new Chart(
    document.getElementById('graphTc'),
    config(dataTc, 0, 45, 37, 40)
);


// Aboiement
const DBChart = new Chart(
    document.getElementById('graphDB'),
    config(dataDB, 0, 110, 0, 10)
);



function typeChart(xChart) {
    if (xChart.config.type === 'line') {
        xChart.config.type = 'bar';
    } else {
        xChart.config.type = 'line';
    }
    xChart.update();
}



function pauseChart(xChart) {

    if (xChart.options.plugins.streaming.pause === false) {
        xChart.options.plugins.streaming.pause = true;
    } else {
        xChart.options.plugins.streaming.pause = false;
    }
    xChart.update();
};


function dayChart(xChart) {

    if (xChart.options.plugins.streaming.duration !== 86400000) {
        xChart.options.plugins.streaming.duration = 86400000;
    } else {
        xChart.options.plugins.streaming.duration = 20000;
    }
    xChart.update();
};


function weekChart(xChart) {

    if (xChart.options.plugins.streaming.duration !== 604800000) {
        xChart.options.plugins.streaming.duration = 604800000;
    } else {
        xChart.options.plugins.streaming.duration = 20000;
    }
    xChart.update();
};

function monthChart(xChart) {

    if (xChart.options.plugins.streaming.duration !== 2628002880) {
        xChart.options.plugins.streaming.duration = 2628002880;
    } else {
        xChart.options.plugins.streaming.duration = 20000;
    }
    xChart.update();
};

function liveChart(xChart) {
    xChart.options.plugins.streaming.duration = 20000;
    xChart.options.plugins.streaming.pause = false;
    xChart.update();

};




// map localisation
navigator.geolocation.getCurrentPosition(position => {
    const {
        latitude,
        longitude
    } = position.coords;

    map.innerHTML = '<iframe width="350" height="250" src="https://maps.google.com/maps?q=' + latitude + ',' + longitude + '&amp;z=15&amp;output=embed"></iframe>';
});


