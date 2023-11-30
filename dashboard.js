 
let saveProfiles;
let currentEntryId;
let entryId;

// populates the update data modal form fields base on the index of the data
function displayInfoInModal(index) {
    var userIdField = document.getElementById("userID");
    var currentHealthField = document.getElementById("currentHealth");
    var maxHealthField = document.getElementById("maxHealth");
    var secondCurrentHealthField = document.getElementById("secondCurrentHealth");
    var secondMaxHealthField = document.getElementById("secondMaxHealth");
    var heartshield = document.getElementById("heartshield");
    var currentRoomField = document.getElementById("currentRoom");
    var saveNameField = document.getElementById("saveName");

    // update base on the index in the form
    currentEntryId = saveProfiles[index].entryID;

    userIdField.value = saveProfiles[index].saveProfileID;
    currentHealthField.value = saveProfiles[index].mcCurrentHealth;
    maxHealthField.value = saveProfiles[index].maxHealth;
    secondCurrentHealthField.value =  saveProfiles[index].secondCurrentMcHealth;
    secondMaxHealthField.value =  saveProfiles[index].secondMaxHealth;
    heartshield.value =  saveProfiles[index].Heartshield;
    currentRoomField.value = saveProfiles[index].currentRoom;
    saveNameField.value = saveProfiles[index].filename;
  
}
// Fetch data and update table on document load
document.addEventListener('DOMContentLoaded', fetchDataAndUpdateTable);

// Updates the table if the refresh icon was clicked
document.getElementById("refreshSaveProfile").addEventListener("click", fetchDataAndUpdateTable);

// Update once success
document.getElementById("successAndRefresh").addEventListener("click", fetchDataAndUpdateTable);

// Updates once error
document.getElementById("errorAndRefresh").addEventListener("click", fetchDataAndUpdateTable);

function fetchDataAndUpdateTable() {
    
    // create a xhr object
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "dashboard_fetch_data.php", true);
    xhr.onreadystatechange = function (){
        if(xhr.readyState == 4 && xhr.status == 200){

            
            saveProfiles = JSON.parse(xhr.responseText);
            // get table 
            var dashboardBody = dashboardTable.querySelector("tbody");
            dashboardBody.innerHTML = ' ';

            for (var i in saveProfiles){
                var newRow = document.createElement('tr');

                // Calculate time difference
                var timeUpdated = new Date(saveProfiles[i].timeUpdated);
                var currentTime = new Date();
                var timeDifference = currentTime - timeUpdated;

                // Calculate days, hours, and minutes
                var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));

                newRow.innerHTML =
                    '<th scope="row">' + (parseInt(i) + 1) + '</th>' +
                    '<td>' + saveProfiles[i].entryID + '</td>' +
                    '<td>' + saveProfiles[i].saveProfileID + '</td>' +
                    '<td>' + saveProfiles[i].mcCurrentHealth + '</td>' +
                    '<td>' + saveProfiles[i].maxHealth + '</td>' +
                    '<td>' + saveProfiles[i].secondCurrentMcHealth + '</td>' +
                    '<td>' + saveProfiles[i].secondMaxHealth + '</td>' +
                    '<td>' + saveProfiles[i].Heartshield + '</td>' +
                    '<td>' + saveProfiles[i].currentRoom + '</td>' + 
                    '<td>' + saveProfiles[i].map_t + '</td>' +
                    '<td>' + saveProfiles[i].filename + '</td>' +
                    '<td>' + days + ' days ' + hours + ' hrs ' + minutes + ' mins ago </td>' +
                    '<td>' +
                    '<button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal" onclick="displayInfoInModal('+ i +')"> Update</button>' + "  " +
                    '<button class="btn btn-success btn-sm"  data-bs-toggle="modal" data-bs-target="#confirmSuspendModal" onclick="fetchEntryID(' + saveProfiles[i].entryID + ')">Suspend</button>' +
                    '</td>';

                dashboardBody.appendChild(newRow);
            
                    }   
                }        
             }

    xhr.send();
}


// function that destroy the session if the user log out
document.getElementById("logoutBttn").addEventListener("click",destroySession);

function destroySession(){
    var xhr = new XMLHttpRequest();
    xhr.open("GET","logout.php", true);
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            if(xhr.responseText === "Successful"){
                window.location.href = "login.php";
            }
        }
    }
    xhr.send();

}

// function that show the confirm logout modal
function showConfirmModal(){
    $("#confirmLogoutModal").modal("show");
}


// function that will update the specific record in the database if the admin clicked yes in the confirmation
document.getElementById("confirmUpdateModalBttn").addEventListener("click", updateSaveProfile);

function updateSaveProfile(){
    // fetch the data from form
    var userID = document.getElementById("userID").value;
    var currentHealth = document.getElementById("currentHealth").value;
    var maxHealth = document.getElementById("maxHealth").value;
    var secondCurrentHealth = document.getElementById("secondCurrentHealth").value;
    var secondMaxHealth = document.getElementById("secondMaxHealth").value;
    var heartshield = document.getElementById("heartshield").value;
    var currentRoom = document.getElementById("currentRoom").value;
    var saveName = document.getElementById("saveName").value;

    // check if the form is empty
    if (!userID || !currentHealth || !maxHealth || !secondCurrentHealth || !secondMaxHealth || !heartshield || !currentRoom || !saveName) {
        // Show an alert or any other appropriate user feedback for empty fields
        alert("All Fields Should Not Be Empty");
        return;
    }

    // create the data that will be posted

    var data =  'userID=' + encodeURIComponent(userID) +
                '&currentHealth=' + encodeURIComponent(currentHealth) +
                '&maxHealth=' + encodeURIComponent(maxHealth) +
                '&secondCurrentHealth=' +  encodeURIComponent(secondCurrentHealth)+
                '&secondMaxHealth=' +  encodeURIComponent(secondMaxHealth) +
                '&heartshield=' +  encodeURIComponent(heartshield) +
                '&currentRoom=' + encodeURIComponent(currentRoom) +
                '&entryId=' + encodeURIComponent(currentEntryId) +
                '&saveName=' + encodeURIComponent(saveName);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "dashboard_update_data.php",true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            $('#confirmUpdateModal').modal('hide');
            if(xhr.responseText.trim() === "Successful"){
                $("#successModal").modal("show");
            } else {
                $("#errorModal").modal("show");
            }
        }
    }

    xhr.send(data);
}


// update entry id
function fetchEntryID(id){
    entryId = id;
}

document.getElementById("confirmSuspendModalBttn").addEventListener("click",suspendSaveProfile);

// function that updates the status to "suspended"
function suspendSaveProfile(){
    
    var data = '&entryId=' + encodeURIComponent(entryId);

    var xhr = new XMLHttpRequest();
    xhr.open("POST","suspend_saveprofile.php",true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            $('#confirmSuspendModal').modal('hide');
            if(xhr.responseText.trim() === "Successful"){
                $("#successModal").modal("show");
            } else {
                $("#errorModal").modal("show");
            }
        }
    }

    xhr.send(data);

}


var el = document.getElementById("wrapper");
var toggleButton = document.getElementById("menu-toggle");

toggleButton.onclick = function () {
    el.classList.toggle("toggled");
};