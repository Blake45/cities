function GraphZone(container, data) {
    this.data = data
    this.container = container;
    this.initGraph();
};
GraphZone.prototype.initGraph = function () {

    var ctx = document.getElementById(this.container);
    console.log(this.data);
    var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: this.data,
        options: {}
    });

};

$(document).ready(function(){
    var dataset = JSON.parse(json_economie_zone);
    var graph = new GraphZone("economie", dataset);
});