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
    var services = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nom'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/autocompleteService?term=%QUERY',
            wildcard: '%QUERY'
        }
    });
    $('#service').typeahead({
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
    $('#service').on('typeahead:select', function(event, selected) {
        var selectedId = selected.id;
        $('#selectedIdService').val(selectedId);
    });
});

$(document).ready(function() {
    var employes = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nom', 'prenom'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/autocompleteEmploye?term=%QUERY',
            wildcard: '%QUERY'
        }
    });
    $('#employe').typeahead({
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
    $('#employe').on('typeahead:select', function(event, selected) {
        var selectedId = selected.id;
        $('#selectedIdEmploye').val(selectedId);
    });
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
            return data.nom + ' ' + data.prenom;
        },
        templates: {
            suggestion: function(data) {
                return '<div class="suggestion">' + data.nom + ' ' + data.prenom + '</div>';
            }
        }
    });
    $('#nominfluenceur').on('typeahead:select', function(event, selected) {
        var selectedId = selected.id;
        $('#selectedIdinfluenceur').val(selectedId);
    });
});