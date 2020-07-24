$(document).ready(function() {
    $(function(){
        $("#image img").on("click",function(){
           var src = $(this).attr("src");
           $(".modal-img").prop("src",src);
        })
      })
});
