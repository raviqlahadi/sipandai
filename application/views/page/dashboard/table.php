<table class="table table-responsive-sm table-striped table-borderless">
    <thead>
        <tr>
            <?php

            echo "<th>No</th>";
            foreach ($table_head as $key => $value) {
                echo "<th>" . ucfirst($value) .  "</th>";
            }
            echo "<th>Aset</th>";
            if($this->session->level==2){
                echo "<th><span class='float-right'>Action</span></th>";
            }
            

            ?>
        </tr>
    </thead>
    <tbody>
        <?php
       
        $no =0;
        foreach ($table_content as $key => $value) {
            $no++;
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            foreach ($table_head as $key_head => $value_head) {
                echo "<td>" . $value->{$key_head} .  "</td>";
            }
            if ($value->status_penguasaan == null || $value->status_penguasaan == 'kembali') {
                $status = 'bebas';
                $badge = 'success';
                $print = true;
            } else {
                $status = 'menguasai';
                $badge = 'danger';
                $print = false;
            }
            echo "<td><span class='badge badge-" . $badge . " text-white'>" . $status . "</span</td>";
            if ($this->session->level == 2) {
                $page_url = site_url('officer');
                echo "<td><span class='float-right'>" . $this->table_template->action_dropdown_officer($page_url, $value->id, $print, true) . "</span></td>";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>