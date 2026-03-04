<main>
    <h2>Contactanos</h2>
    <form action="index.php?s=gracias" method="post">
        <fieldset>
            <legend>¡Si tuviste algún problema con tus tesoritos no dudes en contactarnos!</legend>
            <div class="row justify-content-center">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                </div>    
        
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <label for="comentarios" class="form-label">Comentarios:</label>
                    <textarea name="comentarios" class="form-control" id="comentarios" cols="30" rows="5"></textarea>
                </div>
            </div>
            
            <button type="submit" class="btn btn-dark form-button">Enviar</button>
        </fieldset>
    </form>
</main>