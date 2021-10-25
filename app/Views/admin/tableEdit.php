<main class="mt-5 py-3">
    <div class="content p-4 my-4">
        <div class="row">
            <?php for ($i=1; $i <=25 ; $i++) { ?>
                <div class="col-3">
                <!--  style="max-width: 15rem;"-->
                    <div class="card text-white bg-success mb-3" >        
                        <div class="card-header"> 
                            <strong>Mesa N°<?=$i?></strong> 
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Estado
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">Habilitado</a></li>
                                    <li><a class="dropdown-item" href="#">Deshabilitado</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body ">
                            <img src="<?=base_url('/assets/image/table.png')?>" class="img-fluid " alt="..." width="100px" height="100px">
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>    
    </div>
</main>