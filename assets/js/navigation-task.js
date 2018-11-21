$(document).ready(function(){

   $("#js-clock").countdowntimer({
    startDate: new Date().getTime(),
    dateAndTime: inicio,
    displayFormat: 'MS',
    timeUp: timerFinish
  });

  $('.popover-dismiss').popover({
    trigger: 'focus'
  })

  if (window.localStorage.getItem('notifyNewPomodoro') === "true" ) {
    notifyNewPomodoro();
    window.localStorage.setItem("notifyNewPomodoro", false);
  } 

  function timerFinish() {
    window.localStorage.setItem("notifyNewPomodoro", "true");
    //alert ("Terminó el periodo de" + periodType);
    window.location.href = refreshRoute;
   }

  function notifyNewPomodoro () {
    console.log('notify');
    $('#button-next-action').popover('show')
    $.playSound("/sound/clock/alarm.mp3");   
  }
});