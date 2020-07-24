<?php
// 0 activa modo prueba, 1 para valor de producción

define('ProPayPal', 0);
if(ProPayPal){
	define("PayPalClientId", "AVaNsxw5yj0CKf9vfNo0Nnx-slAracjCnT_HGlopLT8mY9-kUbXdbx8d8WBYbKKhf6kAFPaNHM823kS6");
	define("PayPalSecret", "EIuaMlOcrUT6pEjJtP9Ni3yvLQTyDao5g8UB4KS22VfiXCfGk7iOQwEnVquzSsOJbVl6QvrNuIQ3lrQ4");
	define("PayPalBaseUrl", "http://localhost/Paypal/");
	define("PayPalENV", "production");
} 

else {
	define("PayPalClientId", "AQYU0LtEm467fWBheE5o-udG1MTtH8ORlNO7ZnZRGkDVRVsx0xzazFtVR2kH4oX45QsGDuxJB1hsVXj9");
	define("PayPalSecret", "EJ_lR3-CgIqJDsq2efsO59dJGMmNVE2jQOE1ZW8fYX-JbkRUFxm917725_SgNbpucchmxz724mvWJh-f");
	define("PayPalBaseUrl", "http://localhost/Paypal/"); // URL base de la app
	define("PayPalENV", "sandbox");
}
?>