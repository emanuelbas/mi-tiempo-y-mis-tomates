$(document).ready(function(){

   if (window.localStorage.getItem('notifyNewPomodoro') === "true" ) {
    notifyNewPomodoro();
    window.localStorage.setItem("notifyNewPomodoro", false);
  } 

  function notifyNewPomodoro () {
    $('#button-next-action').popover('show')
    if(periodType === "Trabajo" && endWorkAlarm === "1") {
      $.playSound("/sound/clock/alarm.mp3");   
    } else if(periodType === "Descanso" && endBreakAlarm === "1") {
      $.playSound("/sound/clock/alarm.mp3");  
    }
  }

  if (!$("#js-clock").length) {
     return;
  }

   $("#js-clock").countdowntimer({
    startDate: new Date().getTime(),
    dateAndTime: inicio,
    displayFormat: 'MS',
    timeUp: timerFinish
  });

   if (tickAlarm) {
    $.playLoopedSound("/sound/clock/tick_tock.mp3");   
   }

  $('.popover-dismiss').popover({
    trigger: 'focus'
  })

  function timerFinish() {
    window.localStorage.setItem("notifyNewPomodoro", "true");
    window.location.href = refreshRoute;
  } 
});