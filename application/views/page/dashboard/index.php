 <main class="c-main">
     <div class="container-fluid">
         <div id="ui-view">
             <div>
                 <div class="fade-in">
                     <div class="row">
                         <div class="col-12">
                             <h1>Dashboard</h1>
                             <?php if ($this->session->flashdata('alert') !== null) echo $this->session->flashdata('alert') ?>
                         </div>
                     </div>
                 </div>
             </div>
         </div>

     </div>
 </main>