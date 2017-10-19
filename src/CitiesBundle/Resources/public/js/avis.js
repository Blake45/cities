$(document).ready(function(){
   $('#citiesbundle_avis_securite, ' +
       '#citiesbundle_avis_loisir, ' +
       '#citiesbundle_avis_culture, ' +
       '#citiesbundle_avis_emploi, ' +
       '#citiesbundle_avis_environnement, ' +
       '#citiesbundle_avis_sante, ' +
       '#citiesbundle_avis_commerce, ' +
       '#citiesbundle_avis_transport, ' +
       '#citiesbundle_avis_enseignement'
   )
       .barrating({
      theme: 'bars-1to10',
      onSelect: function(value, text, event) {
          $(this.$elem).find('option[value="'+value+'"]').attr('selected', 'selected');
      }
   });
});