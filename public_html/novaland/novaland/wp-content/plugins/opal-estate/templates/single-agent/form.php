<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$message = '';

if( is_single() && get_post_type() == 'opalestate_property' ){
    $message = sprintf(__('Hi, I am interested in %s (Property ID: %s)'), get_the_title() , get_the_ID() );
}
?>

<?php if ( ! empty( $email ) ) : ?>
    <div class="agent-contact-form-container">
        <h3><?php echo __( 'Contact Form', 'opalestate' ); ?></h3>

        <div class="box-content agent-contact-form">

            <form method="post" action="" class="opalestate-contact-form">
                <?php do_action('opalestate_agent_contact_form_before'); ?>
                <input type="hidden" name="post_id" value="<?php the_ID(); ?>">
                <input type="hidden" name="agent_id" value="<?php echo $post_id; ?>">
                <?php if( isset($author_id) ) : ?>
                 <input type="hidden" name="author_id" value="<?php echo $author_id; ?>">
                <?php endif ; ?>
               

                <div class="form-group">
                    <input class="form-control" name="name" type="text" placeholder="<?php echo __( 'Name', 'opalestate' ); ?>" required="required">
                </div><!-- /.form-group -->

                <div class="form-group">
                    <input class="form-control" name="email" type="email" placeholder="<?php echo __( 'E-mail', 'opalestate' ); ?>" required="required">
                </div><!-- /.form-group -->

                <div class="form-group">
                    <textarea class="form-control" name="message" placeholder="<?php echo __( 'Message', 'opalestate' ); ?>" style="overflow: hidden; word-wrap: break-word; height: 68px;"><?php echo $message
                    ; ?></textarea>
                </div><!-- /.form-group -->
                <?php do_action('opalestate_agent_contact_form_after'); ?>
                <button class="button btn btn-primary btn-3d" type="submit" name="contact-form"><?php echo __( 'Send message', 'opalestate' ); ?></button>
            </form>
        </div><!-- /.agent-contact-form -->
    </div><!-- /.agent-contact-->
<?php endif; ?>
