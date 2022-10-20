<head>
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</head>

<?php
echo "<script type='text/javascript'>



    teste();


</script>";


?>

<script>
  function teste() {
      div = document.querySelector('.div').style.display = 'none';
      div.style.display = 'none';
    }
</script>

<style>
  .esconde{display: none;}
</style>

<div class="div">
  <p>Texto</p>
</div>