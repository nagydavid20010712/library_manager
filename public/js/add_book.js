var errors = ["number_of_pages_error", "language_error", "publisher_error", "isbn_error", "title_error", "publish_error", "description_error", "writers_error", "genre_error", "cover_error"];

$.each(errors, (k, v) => {
    //console.log(k, v);
    $("#" + v).css("visibility", "hidden");
})


$("#upload_btn").click(() => {
    let formData = new FormData();
    formData.append("_token", $("meta[name=csrf-token]").attr("content"));
    formData.append("isbn", $("#isbn").val());
    formData.append("publisher", $("#publisher").val());
    formData.append("title", $("#title").val());
    formData.append("publish", $("#publish").val());
    formData.append("description", $("#description").val());
    formData.append("writers", $("#writers").val());
    formData.append("language", $("#language").val());
    formData.append("number_of_pages", $("#number_of_pages").val());
    formData.append("genre", $("#genre").val());
    formData.append("cover", document.getElementById("cover").files[0]);

    $.ajax({
        url: "/upload_book",
        type: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function(data) {
            if(data["msgType"] === "success") {
                $("#success_info").html(data["msg"]);
                $("#success_modal").modal("show");

            } else if(data["msgType"] === "form_error") {
                $.each(data["errors"], (k, v) => {
                    showErrors(k + "_error", v[0]);
                });
                
            } else if(data["msgType"] === "cover_error" || data["msgType"] === "not_known" || data["msgType"] === "insert_error") {
                $("#error_info").html(data["msg"]);
                $("#error_modal").modal("show");
            }
        }
    });
});


function showErrors(id, val) {
    $("#" + id).html(val);
    $("#" + id).css("visibility", "visible");
}
