<?php
/**
 * The footer for our theme
 *
 * @package WordPress
 * @subpackage overline
 * @since 1.0
 * @version 1.0
 */

?>
	</div> <!-- End Main -->
	<?php do_action( 'thb_after_main' ); ?>
	<?php

		/*
		 * Always have wp_footer() just before the closing </body>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to reference JavaScript files.
		 */

		wp_footer();
	?>
</div> <!-- End Wrapper -->
<?php do_action( 'thb_after_wrapper' ); ?>

<!--JS edit. Last updated date add before /body tag-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
show_data();
$(".wkmp-action-section.right.wkmp-text-right button").click(function(){

var payment_box = $('#mp_seller_payment_details').val();
var user_id = "<?php echo get_current_user_id(); ?>";

if(payment_box.length>2){

var payment_box = $('#mp_seller_payment_details').val();
$.ajax({
    url:'/wp-content/themes/overline/update_date_profile.php',
    type:'POST',
    data:{user_id,payment_box},
    success:function(msg){
  // alert(msg);

    },
    error:function(){
     alert("Oops, something went wrong.");
    }
  })
}
  
})
  
})
function show_data(){
 var id = "<?php echo get_current_user_id(); ?>";
 var payment_box = $('#mp_seller_payment_details').val();
 if(payment_box.length>2){

$.ajax({
    url:'/wp-content/themes/overline/update_date_profile.php',
    type:'GET',
    data:{id},
    success:function(msg){
      $("#mp_seller_payment_details").parent().find("label").append("<br>"+msg);
   },
    error:function(){
     alert("Oops, something went wrong.");
    }
  })
}
}
</script>

</body>
</html>
