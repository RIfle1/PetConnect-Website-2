function getElements(fromElementID, fromElementIDType, toElementID, toElementIDType) {
    let fromElement;
    let toElement;

    if(fromElementIDType === "id") {
        fromElement = $("#"+fromElementID);
    }
    else if(fromElementIDType === "class") {
        fromElement = $("."+fromElementID);
    }

    if(toElementIDType === "id") {
        toElement = $("#"+toElementID);
    }
    else if(toElementIDType === "class") {
        toElement = $("."+toElementID);
    }

    return {
        "fromElement": fromElement,
        "toElement": toElement
    };

}

function setWidth(fromElementID, fromElementIDType, toElementID, toElementIDType, extraPx) {

    let elements = getElements(fromElementID, fromElementIDType, toElementID, toElementIDType);
    let fromElement = elements['fromElement'];
    let toElement = elements['toElement'];

    let fromElementWidth = fromElement.width();
    toElement.css("width", fromElementWidth+extraPx+"px");

    $(window).on("resize", function() {
        toElement.css("width", fromElementWidth+extraPx+"px");
    })

}

function setMarginTop(fromElementID, fromElementIDType, toElementID, toElementIDType, extraPx) {

    let elements = getElements(fromElementID, fromElementIDType, toElementID, toElementIDType);
    let fromElement = elements['fromElement'];
    let toElement = elements['toElement'];
    let fromElementHeight = fromElement.height();

    toElement.css("margin-top", fromElementHeight+extraPx+"px");

    $(window).on("resize", function() {
        fromElementHeight = fromElement.height();
        toElement.css("margin-top", fromElementHeight+extraPx+"px");
    })

}

// GET DATE AND TIME IN EUROPEAN FORMAT
function getDateAndTime(date) {
    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();

    let hour = date.getHours();
    let minute = date.getMinutes();

    if(minute  < 10) {
        minute = "0"+minute;
    }
    return `${day}-${month}-${year} / ${hour}:${minute}`;
}

function returnLanguageList() {
    return {
        "English": {
            "address-buttons" : {
                "Default address" : "Default address",
                "Modify" : "Modify",
                "Delete" : "Delete",
                "Set as default" : "Set as default",
            },
            "connection-security-buttons" : {
                "New" : "New",

                "Edit" : "Edit",
                "Confirm" : "Confirm",
                "Confirm Code" : "Confirm Code",

                "Username must be at least 3 characters long" :
                    "Username must be at least 3 characters long",
                "First Name must be at least 3 characters long" :
                    "First Name must be at least 3 characters long",
                "Last Name must be at least 3 characters long" :
                    "Last Name must be at least 3 characters long",

                "Must be a number" : "Must be a number",

                "Input a valid Email" : "Input a valid Email",
                "A confirmation code has been sent to your new email address."
                    : "A confirmation code has been sent to your new email address.",
                "Input the confirmation code :" : "Input the confirmation code :",
                "This email is already Taken." : "This email is already Taken.",
                "The email could not be sent." : "The email could not be sent.",
                "The Confirmation Code is Incorrect." : "The Confirmation Code is Incorrect.",

                "Password must be at least 8 characters." : "Password must be at least 8 characters.",
                "Password must contain at least one letter." : "Password must contain at least one letter.",
                "Password must contain at least one number." : "Password must contain at least one number.",
                "Passwords must match." : "Passwords must match.",
                "Your old password is incorrect." : "Your old password is incorrect.",
                "Your new password must be different from your old password." : "Your new password must be different from your old password.",
            },
            "manage-user-buttons" : {
                "Promote User" : "Promote User",
                "Promoted" : "Promoted",
                "Delete User" : "Delete User",
                "Submit Changes" : "Submit Changes",
            },
            "message-center-buttons" : {
                "Message Owner:" : "Message Owner:",
                "Start Date:" : "Start Date:",
                "End Date:" : "End Date:",

                "Hide Active Messages" : "Hide Active Messages",
                "Show Active Messages" : "Show Active Messages",

                "Show Resolved Messages" : "Show Resolved Messages",
                "Hide Resolved Messages" : "Hide Resolved Messages",

                "Select Start Date:" : "Select Start Date:",
                "Select Date:" : "Select Date:",

                "Resolved messages before" : "Resolved messages before",
                "Resolved messages after" : "Resolved messages after",
                "Resolved messages between" : "Resolved messages between",
                "and" : "and",
                "have been deleted." : "have been deleted.",
                "Please input a Date." : "Please input a Date.",
                "Please input a Start Date and an End Date." : "Please input a Start Date and an End Date.",


            },
            "password-reset-validation" : {
                "New Password is required" : "New Password is required",
                "Passwords should match" : "Passwords should match",
            },
            "signup-validation" : {
                "Client Username is required" : "Client Username is required",
                "Client Username must be at least 3 characters" : "Client Username must be at least 3 characters",
                "Client First Name is required" : "Client First Name is required",
                "Client First Name must be at least 3 characters" : "Client First Name must be at least 3 characters",
                "Client Last Name is required" : "Client Last Name is required",
                "Client Last Name must be at least 3 characters" : "Client Last Name must be at least 3 characters",
                "Client Email is required" : "Client Email is required",
                "Must be an email" : "Must be an email",
                "Email is already Taken" : "Email is already Taken",
                "Client Phone Number must be a number" : "Client Phone Number must be a number",
                "Client Password is required" : "Client Password is required",
                "Passwords should match" : "Passwords should match",
            },
        },

        "French": {
            "address-buttons" : {
                "Default address" : "Adresse par défaut",
                "Modify" : "Modifier",
                "Delete" : "Supprimer",
                "Set as default" : "Définir par défaut",
            },
            "connection-security-buttons" : {
                "New" : "Nouveau",
                "Edit" : "Modifier",
                "Confirm" : "Confirmer",
                "Confirm Code" : "Code de confirmation",

                "Username must be at least 3 characters long" :
                    "Le nom d'utilisateur doit comporter au moins 3 caractères",
                "First Name must be at least 3 characters long" :
                    "Le prénom doit comporter au moins 3 caractères",
                "Last Name must be at least 3 characters long" :
                    "Le nom de famille doit comporter au moins 3 caractères",

                "Must be a number" : "Doit être un nombre",

                "Input a valid Email" : "Entrez une adresse e-mail valide",
                "A confirmation code has been sent to your new email address."
                    : "Un code de confirmation a été envoyé à votre nouvelle adresse e-mail.",
                "Input the confirmation code :" : "Entrez le code de confirmation :",
                "This email is already Taken." : "Cette adresse e-mail est déjà prise.",
                "The email could not be sent." : "L'e-mail n'a pas pu être envoyé.",
                "The Confirmation Code is Incorrect." : "Le code de confirmation est incorrect.",

                "Password must be at least 8 characters." : "Le mot de passe doit comporter au moins 8 caractères.",
                "Password must contain at least one letter." : "Le mot de passe doit contenir au moins une lettre.",
                "Password must contain at least one number." : "Le mot de passe doit contenir au moins un chiffre.",
                "Passwords must match." : "Les mots de passe doivent être identiques.",
                "Your old password is incorrect." : "Votre ancien mot de passe est incorrect.",
                "Your new password must be different from your old password." : "Votre nouveau mot de passe doit être différent de votre ancien mot de passe.",
            },
            "manage-user-buttons" : {
                "Promote User" : "Promouvoir",
                "Promoted" : "Promu",
                "Delete User" : "Supprimer",
                "Submit Changes" : "Soumettre",
            },
            "message-center-buttons" : {
                "Message Owner:" : "Propriétaire du message :",
                "Start Date:" : "Date de début :",
                "End Date:" : "Date de fin :",
                "Hide Active Messages" : "Masquer les messages actifs",
                "Show Active Messages" : "Afficher les messages actifs",

                "Show Resolved Messages" : "Afficher les messages résolus",
                "Hide Resolved Messages" : "Masquer les messages résolus",

                "Select Start Date:" : "Sélectionner la date de début :",
                "Select Date:" : "Sélectionner la date :",

                "Resolved messages before" : "Messages résolus avant",
                "Resolved messages after" : "Messages résolus après",
                "Resolved messages between" : "Messages résolus entre",
                "and" : "et",
                "have been deleted." : "ont été supprimés.",
                "Please input a Date." : "Veuillez entrer une date.",
                "Please input a Start Date and an End Date." : "Veuillez entrer une date de début et une date de fin.",
            },
            "password-reset-validation" : {
                "New Password is required" : "New Password is required",
                "Passwords should match" : "Passwords should match",
            },
            "signup-validation" : {
                "Client Username is required" : "Nom d'utilisateur du client requis",
                "Client Username must be at least 3 characters" : "Le nom d'utilisateur du client doit comporter au moins 3 caractères",
                "Client First Name is required" : "Prénom du client requis",
                "Client First Name must be at least 3 characters" : "Le prénom du client doit comporter au moins 3 caractères",
                "Client Last Name is required" : "Nom de famille du client requis",
                "Client Last Name must be at least 3 characters" : "Le nom de famille du client doit comporter au moins 3 caractères",
                "Client Email is required" : "Adresse e-mail du client requise",
                "Must be an email" : "Doit être une adresse e-mail",
                "Email is already Taken" : "L'adresse e-mail est déjà utilisée",
                "Client Phone Number must be a number" : "Le numéro de téléphone du client doit être un nombre",
                "Client Password is required" : "Mot de passe du client requis",
                "Passwords should match" : "Les mots de passe doivent correspondre",
            },
        },

        // "Russian":
    }
}

