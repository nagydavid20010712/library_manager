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
    $.each(errors, (k, v) => {
        //console.log(k, v);
        $("#" + v).css("visibility", "hidden");
    })

    let formData = new FormData();
    formData.append("_token", $("meta[name=csrf-token]").attr("content"));
    formData.append("title", $("#title").val());
    formData.append("publish", $("#publish").val());
    formData.append("description", $("#description").val());
    formData.append("writers", $("#writers").val());
    formData.append("genre", $("#genre").val());
    //formData.append("cover", document.getElementById("cover").files[0]);
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
                $.each(data["errors"], (k, v) => {
                    showErrors(k + "_error", v[0]);
                })
            } else if(data["msgType"] === "not_known") {
                $("#error_info").html(data["msg"]);
                $("#error_modal").modal("show");
            } else if(data["msgType"] === "success") {
                //console.log(data["msg"]); 
                //console.log(data["updated_data"]);
                
                /*adatok frissítése*/
                $("#book_title").html(data["updated_data"]["title"]);
                $("#book_description").html(data["updated_data"]["description"]);
                $("#publish_date").html(data["updated_data"]["publish_date"]);
                $("#book_writers").html(data["updated_data"]["writers"]);
                $("#book_genre").html(data["updated_data"]["genre"]);

                /*szerkesztő modal bezárása*/
                $("#change_book_modal").modal("hide");

                /*sikerességet jelző modal megnyitása*/
                $("#success_info").html(data["msg"]);
                $("#success_modal").modal("show");

            } else if(data["msgType"] === "update_err") {
                $("#error_info").html(data["msg"]);
                $("#error_modal").modal("show");
            }
        }
    })
});


function showErrors(id, val) {
    $("#" + id).html(val);
    $("#" + id).css("visibility", "visible");
}

$("#btn_translate").click(() => {
    $.ajax({
        url: "/translate",
        type: "POST",
        data: {
            "_token": $("meta[name=csrf-token]").attr("content"),
            "target_lang": $("#lang").val(),
            "isbn": $("#h_isbn").val()
        },
        success: function(data) {
            
            if(data.translation == "success") {
                console.log(data);
                $("#book_title").html(data.translated_title.translations[0]["text"]);
                $("#book_description").html(data.translated_description.translations[0]["text"]);
            } else {
                //console.log(data);
            }
        }
    });
});