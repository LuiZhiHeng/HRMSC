<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Permission List
    </div>
    <div class="card-body">
        <form action="setting.php?permission=" method="POST">
            <button type="submit" class="btn btn-success float-end mb-2" name="save">Save</button>
        
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Permission Name</th>
                        <th>Permission to Staff</th>
                    </tr>
                </thead>
                <tbody>
<?php
    $rs = $conn->query("SELECT * FROM permission");
    if($rs->num_rows >= 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_assoc();
            echo "<tr>";
            $page = $data['name'];
            $lvl = $data['permissionLevel'];

            $arrPage = explode("_", $page);
            $pageText = "";
            for ($j=0; $j < count($arrPage); $j++) { 
                $pageText .= ucfirst($arrPage[$j]) . " ";
            }
            echo_td($i+1);
            echo_td($pageText);
?>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input" name="<?= $page; ?>" type="checkbox" <?php if($lvl == 2) echo_txt('checked="checked"'); ?>>
                    </div>
                </td>
            </tr>
<?php
        }
    } else die("Failed to get permission data...");
?>
                </tbody>
            </table>       
        </form>
    </div>
</div>