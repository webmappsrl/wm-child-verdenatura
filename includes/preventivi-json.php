<?php



function preventivi_json_to_text(){
    
    global $woocommerce;
    $coupon_id = WC()->cart->get_coupons();
    
    foreach ($coupon_id as $val ){
            $json =  $val;
    }
    ?>
    <h2><?php echo __('Rooms and Travelers\' details: ' ,'wm-child-verdenatura');?></h2>
    <?php
    $json_output = json_decode($json, JSON_PRETTY_PRINT); 
    $description = $json_output['description'];
    $desc = json_decode($description, JSON_PRETTY_PRINT);
    ?>
    <div class="rooms-composition"> <!------- rooms composition -- ---->
    <?php
    $departure_date = '';
    $nightsBefore = '';
    $insurance_name = '';
    $club_name = '';
    foreach ($desc as $val => $key){
        if ($val == 'departureDate') {
            $date = $key;
            $departure_date = date("Y-m-d", strtotime($date));
        }
        if ($val == 'nightsBefore') {
            $nightsBefore = $key;
        }
        if ($val == 'insurance') {
            $insurance_name = $key['name'];
        }
        if ($val == 'club') {
            $club_name = $key['name'];
        }
    }
    foreach ($desc as $val => $key){
        if ($val == 'rooms') {
            $rooms = $key;?>
            <?php 
                echo '<div class="tour-general-info"><p><strong>';
                echo __('Departure date:' ,'wm-child-verdenatura').' </strong>';
                echo $departure_date.'</p>';
            if ( $nightsBefore ) {
                echo '<p><strong>';
                echo __('Nights Before:' ,'wm-child-verdenatura').' </strong>';
                echo $nightsBefore.'</p>';
            }
            if ( $nightsBefore ) { 
                echo '<p><strong>';
                echo __('Insurance:' ,'wm-child-verdenatura').' </strong>';
                echo $insurance_name.'</p>';
            }
            if ( $nightsBefore ) {
                echo '<p><strong>';
                echo __('Club:' ,'wm-child-verdenatura').' </strong>';
                echo $club_name.'</p>';
            }
                echo '</div>';
            ?>
            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
            <?php
            foreach ($rooms as $val2 => $room){
                ?>
                <thead> <!--  table head  -->
                    <tr> <!--  table row head  -->
                        <th><?php $room_number = $val2 + 1; echo sprintf(__('Room number %s' ,'wm-child-verdenatura'), $room_number);?></th>
                        <th><?php echo __('Name' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Rent bike' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Bike extras' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Bike Warranty' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Extras' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Share' ,'wm-child-verdenatura');?></th>
                    </tr>
                </thead> <!-- END table head  -->
                <tbody>
                <?php
                    foreach ($room as $val3 => $pax){
                        $firsName = $pax['firstName'];
                        $lastName = $pax['lastName'];
                        $price = $pax['price'];
                        $rentBike = '';
                        $babyseat = '';
                        $tagalong = '';
                        $trail = '';
                        $trailgator = '';
                        $bikeWarranty = '';
                        $helmet = '';
                        $roadbook = '';
                        $halfboard = '';
                        ?>
                        <tr>
                        <td></td>
                        <td><?php echo $firsName.' '.$lastName; ?></td>
                        
                        <?php
                        foreach ($pax as $val4 => $extra){
                            if ($val4 == 'rentBike'){
                                foreach ($extra as $val5 => $bikename){
                                    if ($val5 == 'name'){
                                        $rentBike = $bikename;
                                    }
                                }
                            }
                            if ($val4 == 'babySeat'){
                                $babyseat = true;
                            }
                            if ($val4 == 'tagAlong'){
                                $tagalong = true;
                            }
                            if ($val4 == 'trailer'){
                                $trail = true;
                            }
                            if ($val4 == 'trailgator'){
                                $trailgator = true;
                            }
                            if ($val4 == 'bikeWarranty'){
                                $bikeWarranty = true;
                            }
                            if ($val4 == 'helmet'){
                                $helmet = true;
                            }
                            if ($val4 == 'roadbook'){
                                $roadbook = true;
                            }
                            if ($val4 == 'halfboard'){
                                $halfboard = true;
                            }
                        }
                        ?>
                        <td><?php if($rentBike): switch ($rentBike) {
                            case 'bike':
                                echo __('Bike' ,'wm-child-verdenatura');
                                break;
                            case 'eBike':
                                echo __('eBike' ,'wm-child-verdenatura');
                                break;
                            case 'kidBike':
                                echo __('kidBike' ,'wm-child-verdenatura');
                                break;
                                
                        } endif;?></td>
                        <td>
                            <?php if($babyseat): echo __('Baby seat' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($tagalong): echo __('Tag-along' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($trail): echo __('Trailer' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($trailgator): echo __('Trailgator' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                        </td>
                        <td><?php if($bikeWarranty):?><i class="icon-ok"></i><?php endif;?></td>
                        <td>
                            <?php if($helmet): echo __('Helmet' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($roadbook): echo __('Roadbook' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($halfboard): echo __('Halfboard' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                        </td>
                        <td><?php echo $price.'€'; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody> 
                <?php
            }
            ?></table><?php
        }
    }
    ?>
    </div><!-- END rooms composition  --> 
    <h2><?php echo __('Cart detail: ' ,'wm-child-verdenatura');?></h2>
    <?php
    
}