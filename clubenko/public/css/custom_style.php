<?php
    header("Content-type: text/css; charset: UTF-8");

   $pantone = "";
   
?>

#header,
#footer, 
div#app-navbar-collapse,
.blue-button,
.ultimas-promos, 
.section-title,
.carousel-indicators li,
.carousel-indicators li.active,

.texto-visualizacion-cupon,
.back,
.botones-usuario a.ver-cupones,
.submit-datos,
.submenu-comercio .submenu-item-list,
.radio-box-active,
.radio-subcategorias input[type="radio"]:checked + label,
.btn-blue,
.perfil .blue,
#ges-categorias .blue,
.btn-comentario
{
	background:<?php echo $pantone; ?> !important;
}

.submenu-comercio .submenu-item-list .active{
	border-top: 2px solid <?php echo $pantone; ?>;
    border-bottom: 2px solid <?php echo $pantone; ?>;
}