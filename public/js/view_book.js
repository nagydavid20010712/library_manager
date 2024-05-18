var errors = ["title_error", "publish_error", "description_error", "writers_error", "genre_error", "cover_error"];

$.each(errors, (k, v) => {
    //console.log(k, v);
    $("#" + v).css("visibility", "hidden");
})


$("#open_modal").click(() => {
    $("#change_book_modal").modal("show");
})

$("#del_open_modal").click(() => {
    $("#confirm_del_modal").modal("show");
});


$("#confirm_book_delete").click(() => {
    $.ajax({
        url: "/delete_book/" + parseInt($("#confirm_book_delete").val()),
        type: "DELETE",
        data: {
            _token: $("meta[name=csrf-token]").attr("content")
        },
        success: function(data) {
            if(data["success"]) {
                window.location.href = "/list_books";
            } else {
                $("#error_info").html(data["err"]);
                $("#error_modal").modal("show");
            }
        }
    });
});

$("#confirm_book_update").click(() => {
    let formData = new FormData();
    formData.append("_token", $("meta[name=csrf-token]").attr("content"));
    formData.append("title", $("#title").val());
    formData.append("publish", $("#publish").val());
    formData.append("description", $("#description").val());
    formData.append("writers", $("#writers").val());
    formData.append("genre", $("#genre").val());
    formData.append("cover", document.getElementById("cover").files[0]);
    formData.append("isbn", parseInt($("#confirm_book_update").val()));

    $.ajax({
        url: "/update_book",
        type: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function(data) {
            if(data["msgType"] === "form_error") {
                //console.log(data["msg"]);
                $.each(data["msg"], (k, v) => {
                    showErrors(k + "_error", v[0]);
                })
            } else if(data["msgType"] === "not_known") {
                console.log(data["msg"]);
            } else if(data["msgType"] === "success") {
                console.log(data["msg"]); 
            } else if(data["msgType"] === "cover_error") {
                console.log(data["msg"]);
            }

        }
    })
});


function showErrors(id, val) {
    $("#" + id).html(val);
    $("#" + id).css("visibility", "visible");
}

