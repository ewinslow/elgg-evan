// <script>
define({
    user: <?php echo json_encode(elgg_get_person_proto(elgg_get_logged_in_user_entity())); ?>
});