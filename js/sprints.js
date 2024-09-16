// popup3

var popup3 = document.getElementById("popup3")

function openpopup3() {
    popup3.classList.add("open-popup3")
}
function closepopup3() {
    popup3.classList.remove("open-popup3")
}


// delete sprint popup
let deleteSprintId;
function openSprintPopup(sprintId) {
    console.log('Opening popup for sprintId:', sprintId);
    deleteSprintId = sprintId;
    document.getElementById('popup-sprint-' + sprintId).classList.add('show');

}
function closeSprintPopup() {
    console.log('Closing popup for sprintId:', deleteSprintId);
    document.getElementById('popup-sprint-' + deleteSprintId).classList.remove('show');

}
function confirmSprintDelete() {
    console.log('Confirming delete for sprintId:', deleteSprintId);
    document.getElementById('deleteSprintForm-' + deleteSprintId).submit();
}