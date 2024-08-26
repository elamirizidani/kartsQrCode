<?php
$couples = $con->read('couples');
?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-primary row justify-content-between">
            <div>
                <h4 class="card-title ">Registored Couples</h4>
                <p class="card-category">Couples We worked with</p>
            </div>
            <a href="#pablo" class="btn btn-primary btn-round">Add a couple</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class=" text-primary">
                        <th>
                            ID
                        </th>
                        <th>
                            Bride
                        </th>
                        <th>
                            Groom
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Details
                        </th>
                    </thead>
                    <tbody>
                        <?php
                        if(!empty($couples))
                        {
                            foreach($couples as $couple)
                            {
                                ?>
                        <tr>
                            <td>
                                1
                            </td>
                            <td>
                                <?=$couple['brideName']?>
                            </td>
                            <td>
                                <?=$couple['groomName']?>
                            </td>
                            <td>
                                <?=$couple['email']?>
                            </td>
                            <td>
                                <a class="text-primary" href="index.php?coupleDetails&couple=<?=$couple['cId']?>">
                                    View
                                </a>
                            </td>
                        </tr>
                        <?php
                            }
                        }
                        ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>