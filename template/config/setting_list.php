<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-sliders-h"></i>
        Setting List
    </div>
    <div class="card-body">
        <ul id="setting_list">
            <li><a href="setting.php?changePass=">Change Password</a></li>
        <?php
            if(get_logged_user_id() == 1) echo '<li><a href="setting.php?permission=">Permission</a></li>';
            $rsPermission = $conn->query("SELECT * FROM permission");
            if($rsPermission->num_rows >= 0){
                for ($i=0; $i < $rsPermission->num_rows; $i++) { 
                    $dataPermission = $rsPermission->fetch_assoc();
                    $lvl = $dataPermission['permissionLevel'];
                    $page = $dataPermission['name'];
                    $pageTemp = explode('_', $page);
                    for ($j=0, $name = ""; $j < count($pageTemp); $j++) {
                        $name .= ucfirst($pageTemp[$j]) . " ";
                    }
                    if($lvl >= get_logged_user_id()){
                        echo '<li><a href="setting.php?' . $page .'=">' . $name . '</a></li>';
                    }
                }
            } else echo "Fail to get permission list";
        ?>
            
        </ul>
    </div>
</div>
