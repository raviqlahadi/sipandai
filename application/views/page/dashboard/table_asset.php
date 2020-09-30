<?php

if ($page_url == site_url('asset')) {;
?>
    <div class="table-responsive">
    <?php
}
    ?>



    <table class="table table-striped table-borderless">
        <thead>
            <tr>
                <?php
                echo "<th>No</th>";
                foreach ($table_head_asset as $key => $value) {
                    echo "<th>" . ucfirst($value) .  "</th>";
                }
                echo "<th><span class=''>Status</span></th>";
               

                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = (isset($table_start_number)) ? $table_start_number : 0;
            foreach ($list_asset as $key => $value) {
              
                $no++;
                echo "<tr>";
                echo "<td>" . $no . "</td>";
                foreach ($table_head_asset as $key_head => $value_head) {
                    echo "<td>" . $value->{$key_head} .  "</td>";
                }
                echo "<td><span class='text-white badge badge-" . $this->table_template->badge($value->asset_status) . "'>" . ucwords($value->asset_status) . "</span></td>";
               
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>


    <?php

    if ($page_url == site_url('asset')) {;
    ?>
    </div>
<?php
    }
?>