<?php
add_action( 'show_user_profile', 'add_user_logo_field' );
add_action( 'edit_user_profile', 'add_user_logo_field' );

function add_user_logo_field( $user ) {
   $user_logo = get_user_meta( $user->ID, 'user_logo', true );
   ?>
   <h3><?php _e( 'Profile Picture' ); ?></h3>
   <table class="form-table">
       <tr>
           <th><label for="user_logo"><?php _e( 'Profile Picture' ); ?></label></th>
           <td>
               <input type="hidden" id="user_logo" name="user_logo" value="<?php echo esc_attr( $user_logo ); ?>" />
               <button type="button" class="button" id="upload_logo_button"><?php _e( 'Add Media File' ); ?></button>
               <button type="button" class="button" id="remove_logo_button" style="<?php echo empty( $user_logo ) ? 'display:none;' : ''; ?>"><?php _e( 'Remove' ); ?></button>
               
               <div id="logo_preview" style="margin-top: 10px;">
                   <?php if ( $user_logo ) : ?>
                       <img src="<?php echo wp_get_attachment_image_url( $user_logo, 'thumbnail' ); ?>" style="max-width: 150px; height: auto;" />
                   <?php endif; ?>
               </div>
           </td>
       </tr>
   </table>

   <script>
   jQuery(document).ready(function($) {
       var mediaUploader;
       
       $('#upload_logo_button').click(function(e) {
           e.preventDefault();
           
           if (mediaUploader) {
               mediaUploader.open();
               return;
           }
           
           mediaUploader = wp.media({
               title: '<?php _e( "Select Logo" ); ?>',
               button: {
                   text: '<?php _e( "Use this image" ); ?>'
               },
               multiple: false,
               library: {
                   type: 'image'
               }
           });
           
           mediaUploader.on('select', function() {
               var attachment = mediaUploader.state().get('selection').first().toJSON();
               $('#user_logo').val(attachment.id);
               $('#logo_preview').html('<img src="' + attachment.sizes.thumbnail.url + '" style="max-width: 150px; height: auto;" />');
               $('#remove_logo_button').show();
           });
           
           mediaUploader.open();
       });
       
       $('#remove_logo_button').click(function(e) {
           e.preventDefault();
           $('#user_logo').val('');
           $('#logo_preview').html('');
           $(this).hide();
       });
   });
   </script>
   <?php
}

add_action( 'personal_options_update', 'save_user_logo_field' );
add_action( 'edit_user_profile_update', 'save_user_logo_field' );

function save_user_logo_field( $user_id ) {
   if ( current_user_can( 'edit_user', $user_id ) ) {
       update_user_meta( $user_id, 'user_logo', sanitize_text_field( $_POST['user_logo'] ) );
   }
}