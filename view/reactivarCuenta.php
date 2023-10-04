<!DOCTYPE html>
<html>

<head>
    <title> UNA </title>
    <meta charset="utf-8">

</head>

<body>

    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="card mb-3">
                                
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Reactivar cuenta</h5>
                                </div>
                                <div class="card-body">
                                    
                                        <form action="../business/clienteAction.php" method="post" class="row g-3 needs-validation">
                                            <div class="col-12">
                                                <input type="text" name="username_email" placeholder="Correo electrónico" required="">
                                                <div class="invalid-feedback">Por favor ingrese un correo electrónico válido.</div>
                                            </div>
                                            <div class="col-12">
                                                <input type="password" name="password" placeholder="Contraseña" required="">
                                                <div class="invalid-feedback">Por favor ingrese una contraseña.</div>
                                            </div>
                                            <div class="send-button">
                                                <input type="submit" name="reactivate" value="Reactivar cuenta">
                                            </div>
                                        </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>



</body>


</html>
