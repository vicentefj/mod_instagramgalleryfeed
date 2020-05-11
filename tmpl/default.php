
<?php
defined('_JEXEC') or die;
// Desactivar toda notificación de error
error_reporting(0);


$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::base(true).'/modules/mod_instagramgalleryfeed/css/mod_instagramgalleryfeed.css');
$doc->addStyleSheet(JURI::base(true).'/modules/mod_instagramgalleryfeed/css/bootstrap.min.css');
$doc->addScript(JURI::root(true) . '/modules/mod_instagramgalleryfeed/css/bootstrap.min.js');
$tipoBusqueda = $params['opcionbusqueda'];
$url = "";
$columnas = $params['columnas'];
$numColumnas = 12/$columnas;
$filas = $params['filas'];
$titol="";

//Si la opcion de busqueda es de usuario
if ($tipoBusqueda == 0){
	$url = 'https://www.instagram.com/' . $params['userhashtag'] . '/?__a=1';
	$titol = '<i class="fa fa-instagram"></i> <i class="fa fa-user"></i> ' . $params['userhashtag'];
}
//Si la opcion de busqueda es etiqueta
if ($tipoBusqueda == 1){
	$url = 'https://www.instagram.com/explore/tags/' . $params["userhashtag"] . '/?__a=1';
	$titol = '<i class="fab fa-instagram"></i> # ' . $params['userhashtag'];
}
$data = "";

//Lanza error y termina ejecucion en caso de no poder leer el feed
if(!$data = file_get_contents($url)){
	echo JText::_( 'MOD_INSTAGRAMGALLERYFEED_ERROR_LECTURA_URL' );
	goto end;
}
$decodedData = json_decode($data);
$foto = 0;
?>

<h3 align="center"><?php echo $titol; ?></h3><hr/>
<div class="container" style="max-width:100%; padding:0.2rem;">

<?php
//Si la opcion de busqueda es de usuario 
if ($tipoBusqueda == 0){
	for ($s = 0; $s < $filas; $s++) {
		
		echo '<div class="row">';
		for ($i = 0; $i < $columnas; $i++) {
			if (!$decodedData->graphql->user->edge_owner_to_timeline_media->edges[$foto]->node->thumbnail_resources[2]->src){
				echo '</div><h3>' . JText::_( 'MOD_INSTAGRAMGALLERYFEED_FOTOS_INSUFICIENTES' ) . '</h3>';
				goto end;
			}
			echo '<div class="col-sm center columna-galeria"><div class="galeria"><a href="https://www.instagram.com/p/'. $decodedData->graphql->user->edge_owner_to_timeline_media->edges[$foto]->node->shortcode .'" target="_blank" style="text-decoration: none; color: white;"><img src="' . $decodedData->graphql->user->edge_owner_to_timeline_media->edges[$foto]->node->thumbnail_resources[2]->src . '" class="imagen-galeria"/></a></div>'.
			'<div class="galeria-item-info"><ul>'.
			'<li class="galeria-item-likes">' . $decodedData->graphql->user->edge_owner_to_timeline_media->edges[$foto]->node->edge_liked_by->count .' <i class="fa fa-heart" aria-hidden="true" ></i> </li>'.
			'<li class="galeria-item-comments">' . $decodedData->graphql->user->edge_owner_to_timeline_media->edges[$foto]->node->edge_media_to_comment->count . ' <i class="fa fa-comment" aria-hidden="true"></i></li>'.
			'</ul></div>'.
			'</div>';			
			$foto = $foto + 1;
		}
		echo '</div>';
	}
	$foto = 0;
	
}
//Si la opcion de busqueda es etiqueta
else if ($tipoBusqueda == 1){
	for ($s = 0; $s < $filas; $s++) {	
		echo '<div class="row">';
		for ($i = 0; $i < $columnas; $i++) {
			if (!$decodedData->graphql->hashtag->edge_hashtag_to_media->edges[$foto]->node->thumbnail_resources[3]->src){
				echo '</div><h3>' . JText::_( 'MOD_INSTAGRAMGALLERYFEED_FOTOS_INSUFICIENTES' ) . '</h3>';
				goto end;
			}
			echo '<div class="col-sm center columna-galeria"><div class="galeria"><a href="https://www.instagram.com/p/'. $decodedData->graphql->hashtag->edge_hashtag_to_media->edges[$foto]->node->shortcode .'" target="_blank" style="text-decoration: none; color: white;"><img src="' . $decodedData->graphql->hashtag->edge_hashtag_to_media->edges[$foto]->node->thumbnail_resources[3]->src . '" class="imagen-galeria"/></a></div>'.
			'<div class="galeria-item-info"><ul>'.
			'<li class="galeria-item-likes">' . $decodedData->graphql->hashtag->edge_hashtag_to_media->edges[$foto]->node->edge_liked_by->count .' <i class="fa fa-heart" aria-hidden="true" ></i> </li>'.
			'<li class="galeria-item-comments">' . $decodedData->graphql->hashtag->edge_hashtag_to_media->edges[$foto]->node->edge_media_to_comment->count . ' <i class="fa fa-comment" aria-hidden="true"></i></li>'.
			'</ul></div>'.
			'</div>';			
			$foto = $foto + 1;
		}
		echo '</div>';
	}
	$foto = 0;
}
end:

?>
</div>








