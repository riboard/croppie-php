<?php 

$imagem = explode(",", $_POST['imagebase64']);

$value = null;

function base64_to_jpeg( $base64_string, $dir, $output_file ) {
    $ifp = fopen( $dir.$output_file, "wb" );
    fwrite( $ifp, base64_decode( $base64_string) );
    fclose( $ifp );
    return( $output_file );
}

$dir = "imagens-croppie/";
$value = base64_to_jpeg( $imagem[1], $dir, md5($imagem[1]).'.jpg' );

echo $value;
