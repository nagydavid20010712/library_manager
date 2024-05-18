



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


function showErrors(id, val) {
    $(id).html(val);
    $(id).css("visibility", "visible");
}

