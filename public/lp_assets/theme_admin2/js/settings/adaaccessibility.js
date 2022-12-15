$(document).ready(function () {
    $(".custom-radio-btn").click(function () {
        $(".custom-radio-btn").find("input[name='is_ada_accessibility']:checked").removeAttr("checked");
        $(this).find("input[name='is_ada_accessibility']").attr("checked", "checked");
    });
});
