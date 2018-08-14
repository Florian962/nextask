
/* BRON: https://stackoverflow.com/questions/32378590/set-date-input-fields-max-date-to-today */
console.log("connected");
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
 if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 

today = dd+'-'+mm+'-'+yyyy;
document.getElementById("taskdeadline").setAttribute("min", today);