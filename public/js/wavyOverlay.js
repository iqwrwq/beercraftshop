document.body.style.overflow = "hidden";

document.getElementById("continue-install-form").addEventListener("click", () => {
    if (document.getElementById("host_input").value !== "" && document.getElementById("db_user_input").value !== ""){
        document.getElementById("wavy-overlay").classList.add("coverPage");
        document.getElementById("setup-user-form").classList.remove("hide");
        document.getElementById("setup-user-form").classList.add("placeForm");
    }else{
        alert("Please enter your information")
    }
})

function resetBody(){
    document.body.style.overflow = "unset";
}


