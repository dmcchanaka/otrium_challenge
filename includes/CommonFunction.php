<?php

class CommonFunction {

    public static function table_names($link) {
        $query = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'otrium_challenge'";
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <option value="<?php echo $row['table_name']; ?>"><?php echo $row['table_name']; ?></option>   
                <?php
            }
        }
    }
    
    public static function  brand($link){
        $query = "SELECT * FROM `brands`";
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>   
                <?php
            }
        }
    }

}
