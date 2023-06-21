// const http = require('http');
// const mysql = require('mysql');

// const connection = mysql.createConnection({
//     host: 'localhost',
//     user: 'root',
//     password: '',
//     database: 'appdb',
// });

// connection.connect((err) => {
//     if (err) {
//         console.error('Error connecting to the database: ', err);
//         return;
//     }
//     console.log('Connected to the database.');
// });

// const url = 'http://projets-tomcat.isep.fr:8080/appService/?ACTION=GETLOG&TEAM=0G4D';

// function fetchData() {
//     http.get(url, (response) => {
//         let data = '';
//         response.on('data', (chunk) => {
//             data += chunk;
//         });
//         response.on('end', () => {
//             processData(data);
//         });
//     }).on('error', (err) => {
//         console.error('Error fetching data: ', err);
//     });
// }

// function processData(data) {
//     const data_tab = data.match(/.{1,33}/g);
//     console.log('Tabular Data:');
//     data_tab.forEach((trame, i) => {
//         console.log(`Trame ${i}: ${trame}`);
//         let capteur = '';
//         const [, o, , c, , v] = trame.match(/(.)(.{4})(.)(.)(..)(.{4})/);
//         if (parseInt(c, 16) === 10) {
//             capteur = 'Son';
//         } else if (parseInt(c, 16) === 3) {
//             capteur = 'Température';
//         } else if (parseInt(c, 16) === 4) {
//             capteur = 'Humidité';
//         } else if (parseInt(c, 16) === 5) {
//             capteur = 'CO2';
//         } else if (parseInt(c, 16) === 6) {
//             capteur = 'BPM';
//         }
//         console.log(` || Value: ${parseInt(v, 16)}  || Capteur: ${capteur}`);

//         const devID = 'dev1';
//         const dapDate = new Date().toLocaleString('fr-FR');
//         const dapID = autoSetID('dap');
//         const dapBPM = Math.floor(Math.random() * (100 - 80 + 1)) + 80;
//         const dapLatitude = getRandomFloat(48, 49, 5);
//         const dapLongitude = getRandomFloat(2, 3, 5);
//         let dapCO2 = 0;
//         let dapDecibel = 0;
//         let dapTemp = 0;

//         if (parseInt(c, 16) === 10) {
//             dapDecibel = parseInt(v, 16);
//         } else if (parseInt(c, 16) === 3) {
//             dapTemp = parseInt(v, 16);
//         } else if (parseInt(c, 16) === 4) {
//             dapCO2 = parseInt(v, 16);
//         } else if (parseInt(c, 16) === 5) {
//             dapTemp = parseInt(v, 16);
//         } else if (parseInt(c, 16) === 6) {
//             dapTemp = parseInt(v, 16);
//         }

//         const insertDataSql = `INSERT INTO data_device(dapID, dapBPM, dapLatitude, dapLongitude, dapCO2, dapDecibel, dapTemp, dapDate, Device_devID) 
//                           VALUES ('${dapID}', '${dapBPM}', '${dapLatitude}', '${dapLongitude}', '${dapCO2}', '${dapDecibel}', '${dapTemp}', '${dapDate}', '${devID}')`;
//         connection.query(insertDataSql, (err) => {
//             if (err) {
//                 console.error('Error inserting data into the database: ', err);
//                 return;
//             }
//             console.log('Data inserted into the database.');
//         });
//     });
// }

// function autoSetID(prefix) {
//     // Implement your logic to generate an ID
//     return prefix + Math.random().toString(36).substr(2, 9);
// }

// function getRandomFloat(min, max, precision) {
//     return parseFloat((Math.random() * (max - min) + min).toFixed(precision));
// }

// setInterval(() => {
//     fetchData();
// }, 5000);
