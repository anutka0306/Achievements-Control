/*google.charts.load('current', {packages: ['corechart', 'line']});
let d = [
    [new Date('2015-01-01'), 0],[new Date('2015-01-02'), 20], [new Date('2015-01-03'), 30],  [new Date('2015-01-04'), 10],
];
google.charts.setOnLoadCallback(drawBackgroundColor);


function drawBackgroundColor() {
    var data = new google.visualization.DataTable();
    data.addColumn('date', 'X');
    data.addColumn('number', 'Dogs');

    data.addRows([
        [new Date('2015-01-01'), 0],[new Date('2015-01-02'), 20], [new Date('2015-01-03'), 30],  [new Date('2015-01-04'), 10],
    ]);

    var options = {
        hAxis: {
            title: 'Time'
        },
        vAxis: {
            title: 'Popularity'
        },
        backgroundColor: '#f1f8e9'
    };

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}

 */