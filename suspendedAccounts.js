let entryID;


// show once logout is clicked
document.getElementById("logoutBttn").addEventListener("click",destroySession);

// Fetch data and update table on document load
document.addEventListener('DOMContentLoaded', fetchSuspendedAccAndUpdateTable);

// Updates the table if the refresh icon was clicked
document.getElementById("refreshSaveProfile").addEventListener("click", fetchSuspendedAccAndUpdateTable);

// Update once success
document.getElementById("successAndRefresh").addEventListener("click", fetchSuspendedAccAndUpdateTable);

// Updates once error
document.getElementById("errorAndRefresh").addEventListener("click", fetchSuspendedAccAndUpdateTable);
 
document.getElementById("confirmUnsuspendModalBttn").addEventListener("click", unsuspendSaveprofile);

document.getElementById("confirmBlockModalModalBttn").addEventListener("click", blockSaveprofile);


// function that destroy the session if the user log out
function destroySession(event){
    event.preventDefault();

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

// fetch suspended Account
function fetchSuspendedAccAndUpdateTable() {
    
    // create a xhr object
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "suspended_accounts_fetch_data.php", true);
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
                    '<button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#confirmUnsuspendModal"onclick=" setEntryID(' + saveProfiles[i].entryID + ')">Unsuspend</button>' + "  " +
                    '<button class="btn btn-success btn-sm"  data-bs-toggle="modal" data-bs-target="#confirmBlockModal" onclick="setEntryID(' + saveProfiles[i].entryID + ')">Block</button>' +
                    '</td>';

                dashboardBody.appendChild(newRow);
            
                    }   
                }        
             }

    xhr.send();
}



function setEntryID(fetchedID){
    entryID = fetchedID;
}

// function that will update status to active
function unsuspendSaveprofile(){

    var xhr = new XMLHttpRequest();

    data = '&entryId=' + encodeURIComponent(entryID);

    xhr.open("POST", "unsuspend_saveprofile.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            $('#confirmUnsuspendModal').modal('hide');
            if(xhr.responseText.trim() === "Successful"){
                $("#successModal").modal("show");
            } else {
                $("#errorModal").modal("show");
            }
        }
    }

    xhr.send(data);

}

// function that will update status to block
function blockSaveprofile(){

    var xhr = new XMLHttpRequest();
    data = '&entryId=' + encodeURIComponent(entryID);

    xhr.open("POST", "block_saveprofile.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            $('#confirmBlockModal').modal('hide');
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

