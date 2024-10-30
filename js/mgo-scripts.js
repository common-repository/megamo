let mgobutton = document.getElementById("mgo-back-to-top");

window.onscroll = function () {
    mgoScrollObserver()
};

function mgoScrollObserver() {
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        mgobutton.removeAttribute('mgo-hidden');
    } else {
        mgobutton.setAttribute('mgo-hidden', null);
    }
}

// When the user clicks on the button, scroll to the top of the document
function mgoBackToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}