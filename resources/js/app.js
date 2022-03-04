require("./bootstrap");

const ajaxErrorTxt = "Нещо се обърка! Опитайте пак по късно!";

$(document).ready(function ($) {
    // pregnancyChild
    $("body").on("change", "#pregnancyChild", function (event) {
        let pregnancyChildCount = $(this).val();

        let pregnancyChildGenderTemplate = $("#childrenHolder")
            .children()
            .first()
            .clone();
        $(pregnancyChildGenderTemplate)
            .find("option:selected")
            .removeAttr("selected");
        $(pregnancyChildGenderTemplate).find(".pregnancyChildNumber").html("");

        $("#childrenHolder").html("");

        for (let i = 1; i <= pregnancyChildCount; i++) {
            if (pregnancyChildCount > 1)
                $(pregnancyChildGenderTemplate)
                    .find(".pregnancyChildNumber")
                    .html(i);

            $("#childrenHolder").append(pregnancyChildGenderTemplate.clone());
        }
    });

    // Flash Message Modal
    if ($("#flashMessage").length > 0) {
        $("#ajaxModalTitle").html("");
        $("#ajaxModalBody").html($("#flashMessage").html());
        hideLoader();
        $("#ajaxModal").modal("show");
    }

    // Delete Modal
    $("body").on("click", ".deleteModal", function (event) {
        event.preventDefault();
        $("#deleteModalTitle").html("");
        $("#deleteModalBody").html($(this).data("title"));
        $("#deleteModalForm").attr("action", $(this).data("href"));
        $("#deleteModal").modal("show");
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Open Modal Form
    $("body").on("click", ".openModalForm", function (event) {
        event.preventDefault();

        $("#ajaxModalTitle").html($(this).data("title"));
        showLoader();
        $("#ajaxModal").modal("show");

        const ajaxUrl = $(this).data("href");

        $.ajax({
            type: "GET",
            url: ajaxUrl,
            success: function (res) {
                hideLoader();
                $("#ajaxModalBody").html(res);
            },
            error: function (request, status, error) {
                hideLoader();
                $("#ajaxModalBody").html(ajaxErrorTxt);
            },
        });
    });

    // Submit Ajax Form
    $("body").on("submit", ".ajaxForm", function (event) {
        event.preventDefault();

        let actionUrl = $(this).attr("action");
        let formData = $(this).serialize();

        showLoader();

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: formData,
            dataType: "json",
            success: function (res) {
                $(".formErrorHoder").html("");
                if (res.success) {
                    $("#ajaxModalBody").html(res.html);
                    if (typeof res.updateData !== "undefined") {
                        if (res.updateData.type === "id") {
                            $("#" + res.updateData.element).html(
                                res.updateData.html
                            );
                        } else {
                            $("." + res.updateData.element).html(
                                res.updateData.html
                            );
                        }
                    }
                    if (typeof res.deleteElement !== "undefined") {
                        if (res.deleteElement.type === "id") {
                            $("#" + res.deleteElement.element).remove();
                        } else {
                            $("." + res.deleteElement.element).remove();
                        }
                    }
                } else {
                    $.each(res.err, function (key, item) {
                        $(".formErrorHoder").append(
                            '<div class="alert alert-danger" role="alert">' +
                                item +
                                "</div>"
                        );
                    });
                }
                hideLoader();
            },
            error: function (request, status, error) {
                hideLoader();
                $("#ajaxModalBody").html(ajaxErrorTxt);
            },
        });
    });
});

function showLoader() {
    $("#loaderHolder").show();
    $("#ajaxModalBody").hide();
}

function hideLoader() {
    $("#loaderHolder").hide();
    $("#ajaxModalBody").show();
}
