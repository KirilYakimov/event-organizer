$(document).ready(function() {
    // alert for updating posting
    setTimeout(function() {
        $(".alert").slideUp(1000);
    }, 4000);

    //Show image name on upload
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
      });
});
