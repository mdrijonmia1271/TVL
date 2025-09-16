<?php
$this->load->view('sm/home/view_header');
?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Admin Notification
            </header>
            <div class="panel-body">
                <?php if (!empty($ntfication)): ?>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Notification</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php  foreach ($ntfication as $i => $f): ?>
                            <tr>
                                <td><?= (++$i); ?></td>
                                <td><?= $f->descirption; ?></td>
                                <td><?= date_convert($f->created_at); ?></td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>
<?php
$this->load->view('sm/home/view_footer');
?>

<script>
    $('#std').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });
    $('#end').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });
</script>