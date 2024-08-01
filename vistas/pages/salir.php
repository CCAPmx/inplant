<?php
session_destroy();
echo '<script>
    sessionStorage.clear();
    localStorage.clear();
    window.location ="ingreso";
</script>';