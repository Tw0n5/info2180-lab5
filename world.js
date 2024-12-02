document.addEventListener("DOMContentLoaded", function(){
    const lookbutton= document.getElementById("lookup");
    const lookcity= document.getElementById("lookupC")
    const rslt= document.getElementById("result");

    lookbutton.addEventListener("click", function(){
        const countryIN= document.getElementById("country");
        const country= countryIN ? countryIN.value.trim() : "";

        const XHR= new XMLHttpRequest();

        XHR.open("GET", `world.php?country=${encodeURIComponent(country)}`, true);

        XHR.onload= function(){
            if(XHR.status===200){
                rslt.innerHTML= XHR.responseText;
            }else{
                rslt.innerHTML= "Error fetching data";
            }
        };
        XHR.send();
    });

    lookcity.addEventListener("click", function(){
        const countryIN= document.getElementById("country");
        const country= countryIN ? countryIN.value.trim() : "";

        const XHR= new XMLHttpRequest();

        XHR.open("GET", `world.php?country=${encodeURIComponent(country)}&lookup=cities`, true);

        XHR.onload= function(){
            if(XHR.status===200){
                rslt.innerHTML= XHR.responseText;
            }else{
                rslt.innerHTML= "Error fetching data";
            }
        };
        XHR.send();
    });
});