<div class="col-md-12 col-sm-12 col-xs-12 main post-inherit">
    <div class="post-inherit">
        <div class="row">
            <div class="col-md-8">
                <h3>
                    Detail BPJS Kesehatan
                </h3>
            </div>
            <div class="col-md-4">
                <span class=" pull-right">
                    <a href="<?php echo site_url('admin/bpjs') ?>" class="btn btn-info"><span class="fa fa-arrow-left"></span>&nbsp; Kembali</a> 
                    <a href="<?php echo site_url('admin/bpjs/edit/' . $cetak['bpjs_id']) ?>" class="btn btn-success"><span class="fa fa-edit"></span>&nbsp; Edit</a> 
                    <a href="<?php echo site_url('admin/bpjs/printPdf/' . $cetak['bpjs_id']) ?>" target="_blank" class="btn btn-primary"><span class="fa fa-print"></span>&nbsp; Cetak</a>
                </span>
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>NOKA</td>
                            <td>:</td>
                            <td><?php echo $cetak['bpjs_noka'] ?></td>
                        </tr>
                        <tr>         
                            <td>NIK KTP</td>
                            <td>:</td>
                            <td><?php echo $cetak['bpjs_ktp'] ?></td>
                        </tr>  
                        <tr>         
                            <td>NPP</td>
                            <td>:</td>
                            <td><?php echo $cetak['bpjs_npp'] ?></td>
                        </tr>  
                        <tr>         
                            <td>Nama</td>
                            <td>:</td>
                            <td><?php echo $cetak['bpjs_name'] ?></td>
                        </tr>                       
                        <tr>         
                            <td>Hubungan Keluarga</td>
                            <td>:</td>
                            <td><?php echo $cetak['bpjs_hub'] ?></td>
                        </tr>  
                        <tr>         
                            <td>Tanggal Lahir</td>
                            <td>:</td>
                            <td><?php echo pretty_date($cetak['bpjs_date'], 'd M Y') ?></td>
                        </tr>  
                        <td>TMT Date</td>
                        <td>:</td>
                        <td><?php echo pretty_date($cetak['bpjs_tmt'], 'd M Y') ?></td>
                    </tr>
                    <tr>         
                        <td>Faskes</td>
                        <td>:</td>
                        <td><?php echo $cetak['bpjs_faskes'] ?></td>
                    </tr>       
                    <td>Kelas Rawat</td>
                    <td>:</td>
                    <td><?php echo $cetak['bpjs_kelas'] ?></td>
                </tr>  
                
            </tbody>
        </table>
    </div>
</div>

</div>
</div>