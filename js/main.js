$(function(){
    $("#headerNavBar").load("./header.html"); 
});

$(function(){
    $("#footerDiv").load("./footer.html");
});

$(".dropdown-item").click(function () {
    console.log("item clicked");
    alert("works");
    window.location = $(this).attr('href');
});

