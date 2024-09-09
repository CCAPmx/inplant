 <?php
// if ($_SESSION["produccion"] == 1 and $_SESSION["maquinas"] == 1 and $_SESSION["bodega"] == 1 and $_SESSION["mantenimiento"] == 1):
?>


    <li class="list_item">
        <div class="list_button">
            <i class='align-middle fa-solid fa-house' style="color: #eaebef;"></i>
            <a href="#" class="nav_link list_img a_nav"> Home</a>
        </div>
    </li>    


    <li class="list_item">
        <div class="list_button list_button--click">
            <i class='align-middle fa-solid fa-recycle' style="color: #eaebef;"></i>
            <a href="#" class="list_img a_nav"> Producción</a>
            <i class="fa-solid fa-chevron-up list_arrow i_list_arrow" style="color: #eaebef;"></i>
        </div>

        <ul class="list_show">
            <li class="list_inside">
                <a href='visitastecnicas' class="nav_link nav_link--inside list_img a_nav">Visitas técnicas</a>
            </li>
        </ul>
    </li>




 <?php// endif; ?> 