$(document).ready(function() {
    var clients = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nom', 'prenom'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/autocomplete?term=%QUERY',
            wildcard: '%QUERY'
        }
    });
    $('#nom').typeahead({
        hint: true,
        highlight: true,
        minLength: 2
    }, {
        source: clients.ttAdapter(),
        name: 'clients',
        display: function(data) {
            return data.nom + ' ' + data.prenom;
        },
        templates: {
            suggestion: function(data) {
                return '<div class="suggestion">' + data.nom + ' ' + data.prenom + '</div>';
            }
        }
    });
    $('#nom').on('typeahead:select', function(event, selected) {
        var selectedId = selected.id;
        $('#selectedId').val(selectedId);
    });
});

$(document).ready(function() {
    // Tableaux pour stocker les instances de Typeahead et les identifiants sélectionnés
    var serviceInstances = [];
    var employeInstances = [];

    $("#addButton").click(function() {
        var clonedDiv = $(".container-ambany:first").clone();

        // Réinitialisez les champs clonés
        clonedDiv.find("input[type='text']").val("");
        clonedDiv.find(".selectedIdService").val("");
        clonedDiv.find(".selectedIdEmploye").val("");

        // Ajoutez le clone à la fin
        $(".container-ambany:last").after(clonedDiv);

        initializeTypeahead(clonedDiv);
    });

    function initializeTypeahead(container) {
        var services = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nom'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/autocompleteService?term=%QUERY',
                wildcard: '%QUERY'
            }
        });

        var serviceInput = container.find('.typeahead.service');
        serviceInput.typeahead({
            hint: true,
            highlight: true,
            minLength: 2
        }, {
            source: services.ttAdapter(),
            name: 'services',
            display: function(data) {
                return data.nom;
            },
            templates: {
                suggestion: function(data) {
                    return '<div class="suggestion">' + data.nom + '</div>';
                }
            }
        });

        serviceInput.on('typeahead:select', function(event, selected) {
            var selectedId = selected.id; 
            container.find('.selectedIdService').val(selectedId);
        });

        // Stockez l'instance Typeahead dans le tableau
        serviceInstances.push(serviceInput);

        var employes = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nom', 'prenom'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/autocompleteEmploye?term=%QUERY',
                wildcard: '%QUERY'
            }
        });

        var employeInput = container.find('.typeahead.employe');
        employeInput.typeahead({
            hint: true,
            highlight: true,
            minLength: 2
        }, {
            source: employes.ttAdapter(),
            name: 'employes',
            display: function(data) {
                return data.nom + ' ' + data.prenom;
            },
            templates: {
                suggestion: function(data) {
                    return '<div class="suggestion">' + data.nom + ' ' + data.prenom + '</div>';
                }
            }
        });

        employeInput.on('typeahead:select', function(event, selected) {
            var selectedId = selected.id;
            container.find('.selectedIdEmploye').val(selectedId);
        });

        // Stockez l'instance Typeahead dans le tableau
        employeInstances.push(employeInput);
    }
    
    // Initialisez le Typeahead pour les champs existants
    initializeTypeahead($('.container-ambany'));
});


$(document).ready(function() {
    var clients = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nom', 'prenom'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/autocompleteInfluenceur?term=%QUERY',
            wildcard: '%QUERY'
        }
    });
    $('#nominfluenceur').typeahead({
        hint: true,
        highlight: true,
        minLength: 2
    }, {
        source: clients.ttAdapter(),
        name: 'clients',
        display: function(data) {
            return data.nom;
        },
        templates: {
            suggestion: function(data) {
                return '<div class="suggestion">' + data.nom + '</div>';
            }
        }
    });
    $('#nominfluenceur').on('typeahead:select', function(event, selected) {
        var selectedId = selected.id;
        $('#selectedIdinfluenceur').val(selectedId);
    });
});