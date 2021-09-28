<label for="my_plugin_setting">
    <input type="checkbox" name="my_plugin_setting" id="my_plugin_setting" value="1" <?php checked( get_option( 'my_plugin_setting' ) ); ?> />
    <?php esc_html_e( 'Some setting', 'my-plugin' ); ?>
</label>
<br/>
<select name="image_default_link_type">
    <!-- some options -->
</select>