<?php
if (!current_user_can('manage_options')) {
  wp_die('You do not have sufficient permissions to access this page.');
}

if ($_GET["page"] === 'video-analytics' || is_page('videos')) {
  wp_enqueue_script('custom-admin-script');
}

?>
<div class="wrap analytics">
  <h1>Channels</h1>
  <?php
  $channels = DBD_Channels::get_dbd_channels();
  foreach ($channels as $channel) { ?>
    <div class="accordion-item">
      <div class="accordion-header">
        <div class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#<?= $channel->channel_username ?>" aria-expanded="false" aria-controls="<?= $channel->channel_username ?>">
          <div class="col-6">
            <h4><?= $channel->channel_name ?></h4>
            <span class="small"><?= $channel->id . ' || ' . $channel->platform . ' || ' . $channel->channel_url ?></span>
          </div>
        </div>
      </div>

      <div id="<?= $channel->channel_username ?>" class="p-3 accordion-collapse collapse">
        <p class="mb-0">Display the videos for this channel</p>
        <?php
        if ($channel->platform == 'youtube') {
          $channel_id = $channel->channel_id;
          // $channel_vids = Dbd_Youtube::get_channel_videos($channel, 3);
          // get_template_part('lib/youtube-templates/video_list', 'video_list', $channel_vids->items); 
        ?>
          <h4>Playlists</h4>
        <?php
          // Display the video analytics page
          $playlists = Dbd_Youtube::get_playlists_with_items($channel_id);
          if (isset($playlists) && $playlists) :
            Dbd_Youtube::save_playlists($channel_id, $playlists);
            Dbd_Admin::display_playlists($playlists, true);
          endif;
        }
        ?>
      </div>
    </div>
  <?php
  }
  ?>
</div>