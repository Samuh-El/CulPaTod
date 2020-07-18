<?php
require __DIR__ . '/vendor/autoload.php';
include('constants.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico">

    <title>Llena los datos para tu compra.</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


    <!-- Bootstrap core CSS -->
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- Custom styles for this template -->
    <!-- <link href="css/cover.css" rel="stylesheet"> -->
</head>

<body>

<?php
    try
    {
        $titulo = $_POST['titulo'];
        if ($titulo==null)
        {
            header('Location: pantallaError.php'); // RUTA DE PANTALLA DE ERROR AQUI
        }
        else
        {
            $monto = $_POST['monto'];
            $descripcion = $_POST['descripcion'];
            $idEspectaculo = $_POST['idEspectaculo'];
            //echo "Titulo:" .$titulo."<br>Monto: ".$monto."<br>Descripcion: ".$descripcion."<br>ESPECTACULO: ".$idEspectaculo;
        }
    }
    
    catch (Exception $e)
    {
        header('Location: pantallaError.php'); // RUTA DE PANTALLA DE ERROR AQUI
    }
?>


<div class="container mt-5" >

<div style="text-align:center;margin-left:20%;margin-right:20%;">
<h4 style="color:white;font-weight: bold;">INGRESA TUS DATOS PARA PAGAR TU TICKET</h4>
<hr style="background-color: white;">
</div>
<div class="pt-4 pb-3 mt-5" style="background-color: #332C2C;margin-left:20%;margin-right:20%;">
<form class="form-horizontal mt-3" role="form" action="demo-send.php" method="post">
                    <!-- Enviar valores obtenidos desde pagina externa para armar el pago --->
                    <input type="hidden" name="titulo" value="<?php echo $titulo; ?>">
                    <input type="hidden" name="monto" value="<?php echo $monto; ?>">
                    <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>">
                    <input type="hidden" name="idEspectaculo" value="<?php echo $idEspectaculo; ?>">

                    <div class="form-group <?php echo $_REQUEST['invalid'] ? 'has-error' : ''; ?>">
                    <div style="margin-left:10%;margin-right:10%;">
                    <h5  style="color:white;" for="email" >Ingresa tu correo electr&oacute;nico</h5>
                    
       <p style="color:rgb(173, 173, 173)">A este correo llegara el comprobante de pago</p>
                        <div>
                            <input type="email" class="form-control" id="email" name="email" placeholder="mi@correo.cl">
                        </div>
                    </div>

                        

                    </div>
                    <div class="form-group">
                    <div style="margin-left:10%;margin-right:10%;">
                    <h5  style="color:white;" for="bankId" >Selecciona tu banco para el pago</h5>
                    
       <p style="color:rgb(173, 173, 173)">Selecciona un banco de la lista proporcionada</p>

<div>
    <select name="bankId" class="form-control" id="bankId">
                                       
        <?php
        $configuration = new Khipu\Configuration();
        $configuration->setReceiverId(RECEIVER_ID);
        $configuration->setSecret(SECRET);
        // $configuration->setDebug(true);

        $client = new Khipu\ApiClient($configuration);
        $banksApi = new Khipu\Client\BanksApi($client);

        try {
            $response = $banksApi->banksGet();
            foreach ($response->getBanks() as $bank) {
                echo "<option value=\"" . $bank->getBankId() . "\">" . $bank->getName()
                    . "</option>";
            }
        } catch (\Khipu\ApiException $e) {
            echo "Entro al catch";
            echo print_r($e->getResponseBody(), TRUE);
        }
        ?>

    </select>
</div>
                    </div>
                        
                    </div>
                    <div class="form-group">
                    <div class="mt-4" style="text-align:center">
                            <!-- <button type="submit" class="btn btn-primary">Revisar orden y pagar</button> -->
                            <button type="submit" class="btn btn-info" style="background-color: rgb(98, 110, 175);border:0px !important">REVISAR PARA PAGO</button>
                        </div>
                    </div>
                </form>
</div>

               
</div>
            
                

            
        

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- <script src="js/bootstrap.min.js"></script>
<script src="js/docs.min.js"></script> -->

<!-- JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


</body>
</html>
