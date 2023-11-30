
document.addEventListener('DOMContentLoaded', function () {
    var xhr = new XMLHttpRequest();
    xhr.open("GET" , "comments_controller.php", true);
    xhr.onload =function(){
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                var comments = JSON.parse(xhr.responseText);
               
                var commentTableBody = commentTable.querySelector('tbody');
          
                for (var i in comments){
                    var newRow = document.createElement('tr');
                    newRow.innerHTML = ' <th scope="row">'+ (parseInt(i) + 1) +'</th>' +
                                    '<td>'+comments[i].comment_id +'</td>' +
                                    '<td>'+comments[i].name +'</td>' +
                                    '<td>'+comments[i].email +'</td>' +
                                    '<td>'+comments[i].message +'</td>' +
                                    '<td>'+comments[i].comment_time+'</td>';
                                   
                    commentTableBody.appendChild(newRow); 
                }
        
                
            }
        }
    }

    xhr.send();
});


let limit = 5;

document.getElementById("showMoreComment").addEventListener("click", showMoreComments);

// function that shows more comments if the button was clicked
function showMoreComments(event){
    event.preventDefault();

    limit = limit + 5;
    console.log(limit);
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "moreComments.php?limit=" + limit, true);
    xhr.onload =function(){
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                var comments = JSON.parse(xhr.responseText);
               
                var commentTableBody = commentTable.querySelector('tbody');
                commentTable.querySelector('tbody').innerHTML = '';
          
                for (var i in comments){
                    var newRow = document.createElement('tr');
                    newRow.innerHTML = ' <th scope="row">'+ (parseInt(i) + 1) +'</th>' +
                                    '<td>'+comments[i].comment_id +'</td>' +
                                    '<td>'+comments[i].name +'</td>' +
                                    '<td>'+comments[i].email +'</td>' +
                                    '<td>'+comments[i].message +'</td>' +
                                    '<td>'+comments[i].comment_time+'</td>';
                                   
                    commentTableBody.appendChild(newRow); 
                }
        
                
            }
        }
    }

    xhr.send();

}


document.getElementById("refreshComment").addEventListener("click", loadNewComments);

function loadNewComments(event){
    event.preventDefault();
    limit = 5;
    var xhr = new XMLHttpRequest();
    xhr.open("GET" , "comments_controller.php", true);
    xhr.onload =function(){
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                var comments = JSON.parse(xhr.responseText);

                var commentTableBody = commentTable.querySelector('tbody');
               
                commentTable.querySelector('tbody').innerHTML = '';
          
                for (var i in comments){
                    var newRow = document.createElement('tr');
                    newRow.innerHTML = ' <th scope="row">'+ (parseInt(i) + 1) +'</th>' +
                                    '<td>'+comments[i].comment_id +'</td>' +
                                    '<td>'+comments[i].name +'</td>' +
                                    '<td>'+comments[i].email +'</td>' +
                                    '<td>'+comments[i].message +'</td>' +
                                    '<td>'+comments[i].comment_time+'</td>';
                                   
                    commentTableBody.appendChild(newRow); 
                }
         
            }
        }
    }

    xhr.send();
}

    
document.getElementById("logoutBttn").addEventListener("click",destroySession);

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

var el = document.getElementById("wrapper");
var toggleButton = document.getElementById("menu-toggle");

toggleButton.onclick = function () {
    el.classList.toggle("toggled");
};