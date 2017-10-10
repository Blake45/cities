$(document).ready(function(){

    var testjson = '[{"id":71057,"name":"Paris","longitude":null,"latitude":null,"numberPopulation":"2229621","slug":"paris","codePostaux":"[75001]"}]';
    JSON.parse(testjson);
    json_villes = JSON.parse(json_villes);
    console.log(json_villes);

});