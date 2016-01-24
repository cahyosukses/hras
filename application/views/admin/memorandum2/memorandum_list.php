<?php $this->load->view('admin/datepicker') ?>
<?php $this->load->view('admin/checkAll') ?>
<div class="col-md-12 col-sm-12 col-xs-12 main post-inherit">
    <div class="x_panel post-inherit">
        <h3>
            Daftar Surat Panggilan Kedua
            <a href="<?php echo site_url('admin/memorandum2/add'); ?>" ><span class="glyphicon glyphicon-plus-sign"></span></a>
        <span class="pull-right">
                <a class="btn btn-sm btn-default" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" ><span class="glyphicon glyphicon-align-justify"></span></a>
            </span>
            <div class="collapse" id="collapseExample">
                <?php echo form_open(current_url(), array('method' => 'get')) ?> <br>
                <div class="row">                
                    <div class="col-md-2">
                        <input type="text" name="n" placeholder="NIK" value="" class="form-control">
                    </div>                
                    <div class="col-md-2">
                        <input type="submit" class="btn btn-success" value="Cari">
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <?php echo validation_errors() ?>    </h3>
        <form action="<?php echo site_url('admin/memorandum2/delete_multiple'); ?>" method="post">
            <select name="action">
                <option value="null">Pilih Action</option>
                <option value="delete">Delete</option>
            </select>
            <input type="submit" name="submit" value="Action"> 
            <!-- Indicates a successful or positive action -->

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" value="checkbox" name="checkbox" onclick="checkUncheckAll(this);"/></th>
                            <th class="controls" align="center">NO. SURAT</th>
                            <th class="controls" align="center">NIK</th>
                            <th class="controls" align="center">NAMA KARYAWAN</th>
                            <th class="controls" align="center">TGL DIKIRIM</th>
                            <th class="controls" align="center">TGL PANGGILAN</th>
                            <th class="controls" align="center">AKSI</th>
                        </tr>
                    </thead>
                    <?php
                    if (!empty($memorandum)) {
                        foreach ($memorandum as $row) {
                            ?>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" name="msg[]" value="<?php echo $row['memorandum_id']; ?>"></td>
                                    <td ><?php echo $row['memorandum_number']; ?></td>
                                    <td ><?php echo $row['employe_nik']; ?></td>
                                    <td ><?php echo $row['employe_name']; ?></td>
                                    <td ><?php echo pretty_date($row['memorandum_date_sent'], 'd F Y', false); ?></td>
                                    <td ><?php echo pretty_date($row['memorandum_call_date'], 'd F Y', false); ?></td>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="Detail" class="btn btn-warning btn-xs" href="<?php echo site_url('admin/memorandum2/detail/' . $row['memorandum_id']); ?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
                                        <a data-toggle="tooltip" data-placement="top" title="Print Surat" class="btn btn-success btn-xs" href="<?php echo site_url('admin/memorandum2/printPdf/' . $row['memorandum_id']) ?>"target="_blank"><span class="glyphicon glyphicon-print"></span></a>
                                        <a data-toggle="tooltip" data-placement="top" title="Print Amplop" class="btn btn-info btn-xs" href="<?php echo site_url('admin/memorandum2/printEnvl/' . $row['memorandum_id']) ?>"target="_blank"><span class="fa fa-envelope"></span></a>
                                        <?php
                                        foreach ($memorandum3 as $key) {
                                            if ($key['memorandum2_memorandum_id'] == $row['memorandum_id']) {
                                                $matchid = $row['memorandum_id'];
                                                $sp_3 = $key['memorandum_id'];
                                            }
                                        }
                                        ?>
                                        <?php if ((isset($matchid) AND $matchid == $row['memorandum_id'])) { ?>
                                        <a class="btn btn-primary btn-xs" href="<?php echo site_url('admin/memorandum3/detail/' . $sp_3); ?>" ><span class="fa fa-eye"></span> Lihat SP 3</a>
                                        <?php } elseif (empty($memorandum3)) { ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Selesai Panggilan" class="btn btn-primary btn-xs" href="<?php echo site_url('admin/memorandum2/present/' . $row['memorandum_id']); ?>" ><span class="fa fa-check"></span></a>
                                        <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal<?php echo $row['memorandum_id'] ?>"><span class="fa fa-plus"></span>&nbsp; SP 3</button> 
                                        <?php } else { ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Selesai Panggilan" class="btn btn-primary btn-xs" href="<?php echo site_url('admin/memorandum2/present/' . $row['memorandum_id']); ?>" ><span class="fa fa-check"></span></a>
                                        <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal<?php echo $row['memorandum_id'] ?>"><span class="fa fa-plus"></span>&nbsp; SP 3</button> 
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                            <div class="modal fade" id="modal<?php echo $row['memorandum_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <?php echo form_open(site_url('admin/memorandum3/add')) ?>
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Tambah Surat Panggilan Ketiga</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="memorandum2_id" value="<?php echo $row['memorandum_id']; ?>" />
                                            <input type="hidden" name="from_list" value="TRUE" >
                                            <label >Tanggal Dikirim *</label>
                                            <input name="memorandum_date_sent" placeholder="Tanggal Dikirim" type="text" class="form-control datepicker"><br>
                                            <label >Tanggal Panggilan *</label>
                                            <input name="memorandum_call_date" placeholder="Tanggal Panggilan" type="text" class="form-control datepicker"><br>
                                            <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                        <?php echo form_close() ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <tbody>
                            <tr id="row">
                                <td colspan="5" align="center">Data Kosong</td>
                            </tr>
                        </tbody>
                        <?php
                    }
                    ?>   
                </table>
            </div>
            <div >
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>