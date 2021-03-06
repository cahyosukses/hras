<div class="col-md-12 col-sm-12 col-xs-12 main post-inherit">
    <div class="x_panel post-inherit">
        Daftar Surat Pengantar Mutasi
        <span class="pull-right add-btn hidden-xs">
        <a href="<?php echo site_url('admin/spm/add'); ?>" role="button"><span class="fa fa-plus"> Tambah</span></a>
        </span>
        <span class="pull-right add-btn hidden-lg hidden-md hidden-sm">
            <a href="<?php echo site_url('admin/spm/add'); ?>" role="button"><span class="fa fa-plus"></span></a>
        </span>
    </div>  

    <!-- Indicates a successful or positive action -->

    <div class="table-responsive">
        <table class="table table-condensed">
            <thead class="thed">
                <tr>
                    <th class="controls" align="center">NO. SURAT</th>
                    <th class="controls" align="center">NIK</th>
                    <th class="controls" align="center">NAMA KARYAWAN</th>
                    <th class="controls" align="center">JABATAN</th>
                    <th class="controls" align="center">BRANCH</th>                        
                    <th class="controls" align="center">AKSI</th>
                </tr>
            </thead>
            <?php
            if (!empty($spm)) {
                foreach ($spm as $row) {
                    ?>
                    <tbody class="tbodies">
                        <tr>
                            <td ><?php echo $row['spm_number']; ?></td>
                            <td ><?php echo $row['spm_employe_nik']; ?></td>
                            <td ><?php echo $row['spm_employe_name']; ?></td>
                            <td ><?php echo $row['spm_employe_position']; ?></td>                                
                            <td ><?php echo $row['spm_branch']; ?></td>                                
                            <td>
                                <a data-toggle="tooltip" data-placement="top" title="Detail" class="btn btn-warning btn-xs" href="<?php echo site_url('admin/spm/detail/' . $row['spm_id']); ?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
                                <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-success btn-xs" href="<?php echo site_url('admin/spm/edit/' . $row['spm_id']); ?>" ><span class="glyphicon glyphicon-edit"></span></a>
                                <a data-toggle="tooltip" data-placement="top" title="Print Surat" class="btn btn-danger btn-xs" href="<?php echo site_url('admin/spm/printPdf/' . $row['spm_id']) ?>"target="_blank"><span class="glyphicon glyphicon-print"></span></a>
                            </td>
                        </tr>
                    </tbody>
                    <?php
                }
            } else {
                ?>
                <tbody>
                    <tr id="row">
                        <td colspan="6" align="center">Data Kosong</td>
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