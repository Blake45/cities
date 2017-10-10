$(document).ready(function(){
    $('form#filtre-liste-ville select').change(function(){
        $('form#filtre-liste-ville')
            .find('select:has(option:selected[value=""])')
            .attr('disabled', true);
        $('form#filtre-liste-ville').submit();
    });
});