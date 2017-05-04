<script>
var regex = /(<([^>]+)>)/ig;
var body = "<strong><b>test<b></strong><b> sss</b> [variable] <img src='testo'>";
var result = body.replace(regex, "");

alert(result);
</script>