<?php
$couple = $con->readCondition('couples',['cId'=>$_GET['couple']]);
// print_r($couple);
?>
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header card-header-primary row justify-content-between align-items-center">
                <div>
                    <h4 class="card-title">Couple Detail</h4>
                    <p class="card-category">XXXXX XXXXX XXXXXX XXXXX XXXXXX</p>
                </div>
                <img src="./uploads/<?=$couple[0]['image']?>" alt="avatar" class="rounded-circle img-fluid"
                    style="width: 80px;aspect-ratio:1">

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Groom Names</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0"><?=$couple[0]['groomName']?></p>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Bride Names</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0"><?=$couple[0]['brideName']?></p>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Email</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0"><?=$couple[0]['email']?></p>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Venue</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0"><?=$couple[0]['venue']?></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">About Wedding</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0">
                            <?=$couple[0]['description']?>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body text-center gap-6">
                <img src="./qrCodes/<?=$couple[0]['username']?>.png" alt="avatar" class="img-fluid"
                    style="width: 150px;aspect-ratio:1">

                <div class="d-flex justify-content-center mb-2 gap-3">
                    <a href="http://localhost:8888/karts/gallary/" target="_blank" type="button" data-mdb-button-init
                        data-mdb-ripple-init class="btn btn-primary btn-round">View
                        Gallery</a>
                    <a href="./qrCodes/<?=$couple[0]['username']?>.png" data-mdb-button-init data-mdb-ripple-init
                        class="ms-1 btn btn-primary btn-round">Download QRCode</a>
                </div>
            </div>
        </div>
    </div>
</div>