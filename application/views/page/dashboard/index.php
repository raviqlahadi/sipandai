 <main class="c-main">
     <div class="container-fluid">
         <div id="ui-view">
             <div>
                 <div class="fade-in">
                     <div class="row">
                         <div class="col-12">
                             <div class="fade-in">
                                 <div class="row">
                                     <div class="col-12">
                                         <h4>Selamat Datang Di SIPINTAR</h4>
                                     </div>
                                 </div>
                                 <div class="row mt-3">
                                     <div class="col-12">
                                         <div class="card">
                                             <div class="card-header">
                                                 Cek Bebas Aset
                                             </div>
                                             <div class="card-body">
                                                 <div class="row">
                                                     <div class="col-12">
                                                         <form action="" method="get">
                                                             <div class="input-group pb-3">
                                                                 <input class="form-control" id="search" type="text" name="search" placeholder="Masukan NIP / Nama ASN" required 
                                                                 value="<?php if(isset($search) && $search!=null) echo $search; ?>">
                                                                 <span class="input-group-append">
                                                                     <a class="btn btn-info" href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-sync-alt"></i></a>
                                                                     <button class="btn btn-primary" type="submit">Cari ASN</button>
                                                                 </span>
                                                             </div>
                                                         </form>
                                                     </div>
                                                     <div class="col-12">
                                                         <?php 
                                                            if(isset($table_content) && $table_content!=null){
                                                               $this->load->view('page/dashboard/table');
                                                            }
                                                         ?>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <?php if ($this->session->flashdata('alert') !== null) echo $this->session->flashdata('alert') ?>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

         </div>
 </main>