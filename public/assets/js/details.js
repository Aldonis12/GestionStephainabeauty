function AlertEmploye(id, motif) {
    let confirmationText, icon, confirmButtonColor;

    if (motif === "quit") {
        confirmationText = "Êtes-vous sûr de vouloir supprimer cet employé?";
        icon = "warning";
        confirmButtonColor = '#d33';
    } else {
        confirmationText = "Êtes-vous sûr de vouloir reprendre cet employé?";
        icon = "question";
        confirmButtonColor = 'green';
    }

    Swal.fire({
        title: confirmationText,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: confirmButtonColor,
        cancelButtonColor: 'grey',
        confirmButtonText: 'Oui, ' + (motif === "quit" ? "supprimer!" : "reprendre!"),
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = '/FireEmploye/' + id + '/' + motif;
        }
    });
}

function AlertInfluenceur(id, motif) {
    let confirmationText, icon, confirmButtonColor;

    if (motif === "quit") {
        confirmationText = "Êtes-vous sûr de vouloir supprimer cet influenceur?";
        icon = "warning";
        confirmButtonColor = '#d33';
    } else {
        confirmationText = "Êtes-vous sûr de vouloir reprendre cet influenceur?";
        icon = "question";
        confirmButtonColor = 'green';
    }

    Swal.fire({
        title: confirmationText,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: confirmButtonColor,
        cancelButtonColor: 'grey',
        confirmButtonText: 'Oui, ' + (motif === "quit" ? "supprimer!" : "reprendre!"),
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = '/FireInfluenceur/' + id + '/' + motif;
        }
    });
}

function DeleteClient(id) {
    Swal.fire({
        title: "Êtes-vous sûr de vouloir supprimer ce client?",
        icon: "error",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: 'grey',
        confirmButtonText: 'Oui, supprimer!',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = '/DeleteClient/' + id;
        }
    });
}

function DeleteQuestion(id) {
    Swal.fire({
        title: "Êtes-vous sûr de vouloir supprimer cette question?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#5c94ed",
        cancelButtonColor: 'grey',
        confirmButtonText: 'Oui, supprimer!',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = '/DeleteQuestion/' + id;
        }
    });
}

function DeleteSalon(id) {
    Swal.fire({
        title: "Êtes-vous sûr de vouloir supprimer ce salon?",
        icon: "error",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: 'grey',
        confirmButtonText: 'Oui, supprimer!',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = '/DeleteSalon/' + id;
        }
    });
}

function DeleteService(id) {
    Swal.fire({
        title: "Êtes-vous sûr de vouloir supprimer ce Service?",
        icon: "error",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: 'grey',
        confirmButtonText: 'Oui, supprimer!',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = '/DeleteService/' + id;
        }
    });
}