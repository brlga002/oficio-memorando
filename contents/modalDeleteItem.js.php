<!-- JS Delete -->
<script>
$(function () {
    $("body").on("click", "[data-itemNome]", function (e) {
        e.preventDefault();
        var data = $(this).data();
        var urlDeletar = $("#urlDeletar");
        var itemnome = $("#itemnome");
        urlDeletar.attr("href",data["url"]);
        itemnome.html(data["itemnome"]);
        $("#deleteModal").modal()
    });
});
</script>
<!-- JS Delete -->