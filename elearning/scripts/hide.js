
function toggle() {
    var ele = document.getElementById("toggleText");
    var text = document.getElementById("displayText");
    if(ele.style.display == "block") {
            ele.style.display = "none";
        text.innerHTML = "Show Subject Remarks";
    }
    else {
        ele.style.display = "block";
        text.innerHTML = "Hide Subject Remarks";
    }
} 

 
function toggle1() {
    var ele = document.getElementById("toggleText1");
    var text = document.getElementById("displayText1");
    if(ele.style.display == "block") {
            ele.style.display = "none";
        text.innerHTML = "Show General Remarks";
    }
    else {
        ele.style.display = "block";
        text.innerHTML = "Hide Subject Remarks";
    }
} 
 
function toggle2() {
    var ele = document.getElementById("toggleText2");
    var text = document.getElementById("displayText2");
    if(ele.style.display == "block") {
            ele.style.display = "none";
        text.innerHTML = "Show Head's Remarks";
    }
    else {
        ele.style.display = "block";
        text.innerHTML = "Hide Head's Remarks";
    }
} 
