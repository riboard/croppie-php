<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Croppie - PHP</title>
	<link href="croppie.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" language="javascript" src="jquery.js"></script>
	<script type="text/javascript" language="javascript" src="croppie.js"></script>
</head>
<body>
	
	<form id="croppie-example">
		<label for="nome">Foto</label>
        <input type="file" id="upload_img" name="upload_img" value="Escolher foto">
        <br>
        <div id="upload-preview"></div>
        <input type="hidden" id="imagebase64" name="imagebase64" />
        <br>
        <button type="subit">Salvar</button>
	</form>

	<script>
		$(document).ready(function(){

			var $uploadCropMorador;
			//INICIA CROPPIE
		    function readFileMorador(input) {
		        if (input.files && input.files[0]) {
		            var reader = new FileReader();
		            reader.onload = function (e) {
		                $uploadCropMorador.croppie('bind', {
		                    url: e.target.result
		                });
		                $('.upload-preview').addClass('ready');

		            }
		            reader.readAsDataURL(input.files[0]);
		        }
		    }

		    //DEFNIÇÕES DO PREVIEW (viewport : parte que define o crop | boundary : area extra para percepção do crop)
		    $uploadCropMorador = $('#upload-preview').croppie({
		        viewport: {
		            width: 300,
		            height: 300,
		            type: 'square'
		        },
		        boundary: {
		            width: 350,
		            height: 350
		        }
		    });
		    //Quando escolher uma imagem, salva ela local e mostra no preview
		    $('#upload_img').on('change', function () { readFileMorador(this); });

		    //SUBMIT FORM
		    $(document).on('submit', '#croppie-example', function(e){ 
		        e.preventDefault();

		        //Ao enviar o formulário o croppie processa a imagem e retorna uma Promisse quando terminar, quando finalizar o processamento envio via ajax ao PHP e o PHP salva a imagem na pasta.
		        $uploadCropMorador.croppie('result', {
		            type: 'canvas',
		            size: {
		                width:'200',
		                height:'200'
		            }
		        }).then(function (resp) {
		            $('#imagebase64').val(resp);

		            $.ajax({
	                    url: 'salva-img.php',
	                    type: 'post',
	                    data: new FormData(document.getElementById("croppie-example")),
	                    contentType: false,
	                    cache: false,
	                    processData:false
	                }).done(function(resposta){

	                	console.log(resposta)
	                	alert('Imagem salva com sucesso!');

	                });
		            

		        });


		    });

		});
	</script>

</body>
</html>