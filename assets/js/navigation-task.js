$(document).ready(function(){
   // Usar código de cuenta regresiva y refresco aca
    if (inicio === undefined) {
        return;
    }

   $("#js-clock").countdowntimer({
    startDate: new Date().getTime(),
    dateAndTime: inicio,
    displayFormat: 'MS',
    timeUp: timerFinish
  });

  function timerFinish() {
    alert ("Terminó el periodo de" + periodType);
    window.location.href = refreshRoute;
   }
});