document.addEventListener("DOMContentLoaded", function(event) {
    document.getElementById("menu-open").addEventListener("click", async function(){
        let mobileMenu = document.querySelector("div.mobile-menu");
        let mobileMenuContent = document.querySelector("div.mobile-menu a");
        mobileMenu.style.width = "20rem";
        let promise = new Promise((res, rej) => {
            setTimeout(() => res("Now it's done!"), 400)
        });
        let result = await promise;
        mobileMenuContent.style.color = "red";
    });

    document.getElementById("menu-close").addEventListener("click", async function(){
        let mobileMenu = document.querySelector("div.mobile-menu");
        let mobileMenuContent = document.querySelector("div.mobile-menu a");
        mobileMenu.style.width = "0";
        mobileMenuContent.style.color = "black";
    });
});