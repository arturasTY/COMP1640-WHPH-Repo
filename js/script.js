"use strict";

$(document).ready(function(){
    
    $('.navbar-nav li a').each(function(){
       if(this.href == window.location.href){
           $(this).addClass('activePage');
       } 
    });
    
});