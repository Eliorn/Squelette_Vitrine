$(function() {
    /*
     *Gestion par défaut des datatables
     */
    $(document).ready(function() {
        $('.dataTable').DataTable( {
            responsive: true,
            destroy: true,
            "pageLength": 10,
            "order": [[ 0, "asc" ]],
            "language": {
                "sProcessing":     "Traitement en cours...",
                "sSearch":         "Rechercher&nbsp;:",
                "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                "sInfoPostFix":    "",
                "sLoadingRecords": "Chargement en cours...",
                "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
                "oPaginate": {
                    "sFirst":      "Premier",
                    "sPrevious":   "Pr&eacute;c&eacute;dent",
                    "sNext":       "Suivant",
                    "sLast":       "Dernier"
                },
                "oAria": {
                    "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                }
            }
        } );
    } );



    /*
     * Activer les popovers
     */
  	$(document).ready(function(){
  		$('[data-toggle="popover"]').popover();


  	});

    /*
     * Paramétrage des popover
     */
  	$(document).on('click', function (e) {
  		$('[data-toggle="popover"],[data-original-title]').each(function () {
  			//the 'is' for buttons that trigger popups
  			//the 'has' for icons within a button that triggers a popup
  			if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
  				(($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
  			}

  		});
  	});





      $('a.thumbcrsl').each(function(index){
        $(this).click(function(){
          
            $('.carousel').carousel(index);


          });
        });




});
