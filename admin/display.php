<div class="wrap">
    <h2><?php esc_html_e( 'My Plugin Settings', 'my-plugin' ); ?></h2>
    <div>
        <form method="post" action="options.php">
            <?php settings_fields( 'my-plugin-admin-options' ); ?>
            <?php do_settings_sections( 'my-plugin-admin-options' ); ?>
            <?php submit_button( esc_html__( 'Save Changes' ) ); ?>
        </form>
    </div>
</div>