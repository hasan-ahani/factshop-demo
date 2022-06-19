<?php if(cs_get_option('show-notification') == true):
$time = str_replace('-','', cs_get_option('notification-day'));
$time = str_replace(' ','', $time);
$time = str_replace(':','', $time);
    ?>
<?php if(wpp_jdate( 'YmdHi', current_time( 'timestamp') ) < $time):?>
<?php if(!isset($_COOKIE['wf_notification']) or $_COOKIE['wf_notification'] != cs_get_option('notification-text')):?>
        <?php $ntcolor = cs_get_option('notification-color');?>
        <?php $ntbg = cs_get_option('notification-bgcolor');?>
        <?php $bg = ($ntbg != '') ? 'background: ' .$ntbg. ' !important; ' : '';?>
        <?php $cr = ($ntcolor != '') ? 'color: ' .$ntcolor. ' !important;'  : '';?>
        <div id="notification" class="bgg-purple text-center " style="<?php echo $bg . ' ' .$cr;?>">

            <a class="text-white h4 " <?php if(cs_get_option('notification-link') != ''):?> href="<?php echo cs_get_option('notification-link');?>" <?php endif;?> style="<?php echo $cr;?>">
                <?php if(cs_get_option('notification-pic')){ echo '<img src="' . wp_get_attachment_url(cs_get_option('notification-pic')) . '" style="width: 100%;"/>'; }else{ echo '<div class="col py-3">' . cs_get_option('notification-text') .'</div>';}?>
            </a>
            <?php if(cs_get_option('notification-remove') == 'one'):?>
                <a href="javascript:;" data-path="<?php echo home_url();?>" data-removed="<?php echo cs_get_option('notification-text');?>" class="notifi-clos"  style="<?php echo $cr;?>"><i class="icon-close"></i></a>
            <?php elseif (cs_get_option('notification-remove') == 'page'):?>
                <a href="javascript:;" data-path="<?php echo home_url();?>" data-removed="none" class="notifi-clos"  style="<?php echo $cr;?>"><i class="icon-close"></i></a>
            <?php endif;?>
            </div>
    <?php endif;?>
<?php endif;?>
<?php endif;?>

