let $doctor, $specialty, $date, $timesMorning, $timesAfternoon, $iteradio, $titleMorning, $titleAfternoon;

const titleMorning = `En la mañana`;

const titleAfternoon = `En la tarde`;

const nohours = `<h5 class="text-danger">No hay horas disponibles</h5>`;

$(function(){
    $specialty = $('#specialty');
    $doctor = $('#doctor');
    $date = $('#dateselect');
    $timesMorning = $('#timesMorning');
    $timesAfternoon = $('#timesAfternoon');
    $titleMorning = $('#titleMorning');
    $titleAfternoon = $('#titleAfternoon');

    $specialty.change(() => {
        const specialtyId = $specialty.val();
        const url = `/especialties/${specialtyId}/medicos`;
        $.getJSON(url, onDoctorsLoaded);
    });
    $doctor.change(loadTimes);
    $date.change(loadTimes);
});

function onDoctorsLoaded (doctors) {
    let htmlOptions = '';
    doctors.forEach(doctor => {
        htmlOptions += `<option value="${doctor.id}">${doctor.name}</option>`;
    });
    $doctor.html(htmlOptions);

    loadTimes();
}

function loadTimes(){
    const selectedDate = $date.val();
    const selectedId = $doctor.val();
    const url = `/schedules/horas?date=${encodeURIComponent(selectedDate)}&doctor_id=${encodeURIComponent(selectedId)}`;
    $.getJSON(url, onTimesLoaded);
}

function onTimesLoaded(data){
    let htmlTimesMorning = '';
    let htmlTimesAfternoon = '';

    $iteradio = 0;

    if(data.morning){
        const morning_intervalos = data.morning;
        morning_intervalos.forEach(intervalo => {
            htmlTimesMorning += getTimesHtml(intervalo);
        });
    }

    if(!htmlTimesMorning != ""){
        htmlTimesMorning += nohours;
    }

    if(data.afternoon){
        const afternoon_intervalos = data.afternoon;
        afternoon_intervalos.forEach(intervalo => {
            htmlTimesAfternoon += getTimesHtml(intervalo);
        });
    }

    if(!htmlTimesAfternoon != ""){
        htmlTimesAfternoon += nohours;
    }

    $timesMorning.html(htmlTimesMorning);
    $timesAfternoon.html(htmlTimesAfternoon);
    $titleMorning.html(titleMorning);
    $titleAfternoon.html(titleAfternoon);
}

function getTimesHtml(intervalo){
    const text = `${intervalo.start} - ${intervalo.end}`;

    return `<div class="form-check">
                <input class="form-check-input" type="radio" id="interval${$iteradio}" name="schedule_time" value="${intervalo.start}" required>
                <label class="form-check-label" for="interval${$iteradio++}">
                    ${text}
                </label>
            </div>`;
}
