const reviewForm = document.getElementById("reviewForm");

reviewForm.addEventListener("submit", (e) => {
    e.preventDefault();

    if(!reviewForm.reportValidity()){
        return;
    }

    let data = new FormData(reviewForm);
    data.append("username", reviewForm.getAttribute("username"));
    data.append("album_id", reviewForm.getAttribute("album"));

    console.log(data);

    fetch("./php_scripts/insert_review.php", {
        method: "POST",
        body: data
    }).then((res) => res.text()).then(data => {
        console.log(data);
        if(data.error) {
            if(data.error.status == 401) {
                window.location.href = "./login.php";
            }
        } else {
            window.location.reload();
        }
    })
})