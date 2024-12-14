/*
https://api.whatsapp.com/send?text=[post-title] [post-url]

https://www.facebook.com/sharer.php?u=[post-url]

https://twitter.com/share?url=[post-url]&text=[post-title]

https://www.linkedin.com/shareArticle?url=[post-url]&title=[post-title]

https://pinterest.com/pin/create/bookmarklet/?media=[post-img]&url=[post-url]&is_video=[is_video]&description=[post-title]


*/
const facebookbtn = document.querySelector(".facebook-btn");
const twt = document.querySelector(".twiter-btn");
const whats = document.querySelector(".whats-btn");

function init() {
    const postimagesa = document.querySelector(".postimg");
    const posttitled = document.querySelector(".posttir");
    const posrdis = document.querySelector(".posr-dis");
    const posrdis2 = document.querySelector(".posr-dis2");
    const postcont = document.querySelector(".post-content");
    const posturls = document.querySelector(".post-urls");
    let postUrl = encodeURI(document.location.href);
    let afterEdit = postUrl.replace("&", "%26");
    let titlexc = encodeURI(posttitled.textContent);
    let postimagelink = encodeURI(postimagesa.src);
    document.title = posttitled.textContent;
    let posrtit2 = document.querySelector(".tit-li");
    facebookbtn.setAttribute("href", `https://www.facebook.com/sharer.php?u=${afterEdit}`);
    twt.setAttribute("href", `https://twitter.com/share?url=${postUrl}&text=${titlexc}`);
    //telegrams.setAttribute("href", `https://t.me/share/url?url=${postUrl}&text=${titlexc}`);
    whats.setAttribute("href", `https://api.whatsapp.com/send?text=${titlexc} ${afterEdit}`);
    posrdis.setAttribute("content", (postcont.textContent).substr(0, 350));
    posrdis2.setAttribute("content", (postcont.textContent).substr(0, 350));
    posrtit2.setAttribute("content", posttitled.textContent);
    posturls.setAttribute("content", document.location.href);
    console.log(location.href);
}
init();