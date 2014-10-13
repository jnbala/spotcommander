<?php

/*

Copyright 2014 Ole Jon Bjørkum

This file is part of SpotCommander.

SpotCommander is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

SpotCommander is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with SpcotCommander.  If not, see <http://www.gnu.org/licenses/>.

*/

require_once('main.php');

$activity = array();
$activity['project_version'] = project_version;

if(isset($_GET['import_playlists']))
{
	echo import_playlists($_POST['uris']);
}
elseif(isset($_GET['import_spotify_playlists']))
{
	echo import_spotify_playlists();
}
elseif(isset($_GET['create_playlist']))
{
	echo create_playlist($_POST['name'], string_to_boolean($_POST['make_public']));
}
elseif(isset($_GET['edit_playlist']))
{
	echo edit_playlist($_POST['name'], $_POST['uri'], string_to_boolean($_POST['make_public']));
}
elseif(isset($_GET['add_uris_to_playlist']))
{
	echo add_uris_to_playlist($_POST['uri'], $_POST['uris']);
}
elseif(isset($_GET['delete_uris_from_playlist']))
{
	echo delete_uris_from_playlists($_POST['uri'], $_POST['uris'], intval($_POST['positions']), $_POST['snapshot_id']);
}
elseif(isset($_GET['cache_playlist']))
{
	get_playlist($_POST['uri']);
}
elseif(isset($_GET['refresh_playlist']))
{
	echo refresh_playlist($_POST['uri']);
}
elseif(isset($_GET['remove_playlist']))
{
	echo remove_playlist($_POST['id']);
}
elseif(isset($_GET['remove_all_playlists']))
{
	echo remove_all_playlists();
}
elseif(isset($_GET['get_playlists_with_starred']))
{
	echo json_encode(get_playlists_with_starred());
}
elseif(isset($_GET['save_recent_playlists']))
{
	echo save_recent_playlists($_POST['uri']);
}
elseif(isset($_GET['clear_recent_playlists']))
{
	echo clear_recent_playlists();
}
elseif(isset($_GET['add']))
{
	$activity['title'] = 'Add Playlists';

	echo '
		<div id="activity_inner_div" data-activitydata="' . base64_encode(json_encode($activity)) . '">

		<div id="add_playlists_div">

		<div class="cards_div">
		<div>
		<div>
		<div class="card_div actions_div" data-actions="confirm_import_spotify_playlists" data-isauthorizedwithspotify="' . boolean_to_string(is_authorized_with_spotify) . '" data-highlightclass="card_highlight" onclick="void(0)"><div class="card_icon_div"><div class="img_div img_24_div import_24_img_div"></div></div><div class="card_text_div"><div><b>Import from Spotify</b></div><div>Import your playlists from Spotify. Your playlists are refreshed every five minutes. This action does it manually.</div></div></div>
		<div class="card_div actions_div" data-actions="change_activity_if_is_authorized_with_spotify" data-activity="playlists" data-subactivity="create" data-args="" data-isauthorizedwithspotify="' . boolean_to_string(is_authorized_with_spotify) . '" data-highlightclass="card_highlight" onclick="void(0)"><div class="card_icon_div"><div class="img_div img_24_div new_24_img_div"></div></div><div class="card_text_div"><div>Create Playlist</div><div>Create a new playlist.</div></div></div>
		<div class="card_div actions_div" data-actions="change_activity" data-activity="playlists" data-subactivity="recent-playlists" data-args="" data-highlightclass="card_highlight" onclick="void(0)"><div class="card_icon_div"><div class="img_div img_24_div history_24_img_div"></div></div><div class="card_text_div"><div>Recent Playlists</div><div>Listened to a great playlist but can\'t find it? You may find it here.</div></div></div>
		</div>
		<div>
		<div class="card_div actions_div" data-actions="change_activity_if_is_authorized_with_spotify" data-activity="playlists" data-subactivity="import" data-args="" data-isauthorizedwithspotify="' . boolean_to_string(is_authorized_with_spotify) . '" data-highlightclass="card_highlight" onclick="void(0)"><div class="card_icon_div"><div class="img_div img_24_div edit_24_img_div"></div></div><div class="card_text_div"><div>Import Manually</div><div>Import playlists manually by pasting Spotify URIs. On Android you can share playlists to ' . project_name . ' from other apps.</div></div></div>
		<div class="card_div actions_div" data-actions="change_activity" data-activity="browse" data-subactivity="" data-args="" data-highlightclass="card_highlight" onclick="void(0)"><div class="card_icon_div"><div class="img_div img_24_div browse_24_img_div"></div></div><div class="card_text_div"><div>Browse Playlists</div><div>Browse popular playlists.</div></div></div>
		</div>
		</div>
		</div>

		</div>

		</div>
	';
}
elseif(isset($_GET['import']))
{
	$activity['title'] = 'Import Manually';
	$activity['actions'][] = array('action' => array('Import', 'yes_32_img_div'), 'keys' => array('actions', 'form'), 'values' => array('submit_form', 'form#import_playlists_form'));

	echo '
		<div id="activity_inner_div" data-activitydata="' . base64_encode(json_encode($activity)) . '">

		<div id="activity_form_div">
		<form method="post" action="." id="import_playlists_form" autocomplete="off" autocapitalize="off">
		<div class="input_text_div"><div><div class="img_div img_24_div edit_24_img_div"></div></div><div><input type="text" id="import_playlists_uris_input" value="URIs..." data-hint="URIs..."></div></div>
		<div class="input_information_div">Separate multiple URIs by space</div>
		<div class="invisible_div"><input type="submit" value="Import"></div>
		</form>
		</div>

		</div>
	';
}
elseif(isset($_GET['create']))
{
	$activity['title'] = 'Create Playlist';
	$activity['actions'][] = array('action' => array('Create', 'yes_32_img_div'), 'keys' => array('actions', 'form'), 'values' => array('submit_form', 'form#create_playlist_form'));

	echo '
		<div id="activity_inner_div" data-activitydata="' . base64_encode(json_encode($activity)) . '">

		<div id="activity_form_div">
		<form method="post" action="." id="create_playlist_form" autocomplete="off" autocapitalize="off">
		<div class="input_text_div"><div><div class="img_div img_24_div edit_24_img_div"></div></div><div><input type="text" id="create_playlist_name_input" value="Name..." data-hint="Name..."></div></div>
		<div class="input_checkbox_div"><div><input type="checkbox" id="create_playlist_make_public_input"></div><div><label for="create_playlist_make_public_input">Make public</label></div></div>
		<div class="invisible_div"><input type="submit" value="Create"></div>
		</form>
		</div>

		</div>
	';
}
elseif(isset($_GET['recent-playlists']))
{
	$activity['title'] = 'Recent Playlists';
	$activity['actions'][] = array('action' => array('Clear', 'delete_32_img_div'), 'keys' => array('actions'), 'values' => array('clear_recent_playlists'));

	$playlists = get_db_rows('recent-playlists', "SELECT id, name, uri FROM recent_playlists ORDER BY id DESC", array('id', 'name', 'uri'));

	if(empty($playlists))
	{
		echo '
			<div id="activity_inner_div" data-activitydata="' . base64_encode(json_encode($activity)) . '">

			<div id="activity_message_div"><div><div class="img_div img_64_div information_64_img_div"></div></div><div>No recent playlists</div></div>

			</div>
		';
	}
	else
	{	
		echo '
			<div id="activity_inner_div" data-activitydata="' . base64_encode(json_encode($activity)) . '">

			<div class="list_header_div"><div><div>ALL</div></div><div></div></div>

			<div class="list_div">
		';

		foreach($playlists as $playlist)
		{
			$id = $playlist['id'];
			$name = $playlist['name'];
			$uri = $playlist['uri'];
			$user = is_facebook_user(rawurldecode(get_playlist_user($uri)));

			$actions_dialog = array();
			$actions_dialog['title'] = hsc($name);

			if(!playlist_is_saved(null, $uri)) $actions_dialog['actions'][] = array('text' => 'Add to My Playlists', 'keys' => array('actions', 'uri'), 'values' => array('hide_dialog import_playlist', $uri, is_authorized_with_spotify));

			$actions_dialog['actions'][] = array('text' => 'Queue Tracks', 'keys' => array('actions', 'uris', 'randomly'), 'values' => array('hide_dialog queue_uris', $uri, 'false'));
			$actions_dialog['actions'][] = array('text' => 'Queue Tracks Randomly', 'keys' => array('actions', 'uris', 'randomly'), 'values' => array('hide_dialog queue_uris', $uri, 'true'));

			echo '
				<div class="list_item_div">
				<div title="' . hsc($name) . '" class="list_item_main_div actions_div" data-actions="toggle_list_item_actions" data-highlightotherelement="div.list_item_main_corner_arrow_div" data-highlightotherelementparent="div.list_item_div" data-highlightotherelementclass="corner_arrow_dark_grey_highlight" onclick="void(0)">
				<div class="list_item_main_actions_arrow_div"></div>
				<div class="list_item_main_corner_arrow_div"></div>
				<div class="list_item_main_inner_div">
				<div class="list_item_main_inner_icon_div"><div class="img_div img_24_div playlist_24_img_div"></div></div>
				<div class="list_item_main_inner_text_div"><div class="list_item_main_inner_text_upper_div">' . hsc($name) . '</div><div class="list_item_main_inner_text_lower_div">' . hsc($user) . '</div></div>
				</div>
				</div>
				<div class="list_item_actions_div">
				<div class="list_item_actions_inner_div">
				<div title="Play" class="actions_div" data-actions="play_uri" data-uri="' . $uri . '" data-highlightclass="dark_grey_highlight" data-highlightotherelement="div.list_item_main_actions_arrow_div" data-highlightotherelementparent="div.list_item_div" data-highlightotherelementclass="up_arrow_dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div play_24_img_div"></div></div>
				<div title="Shuffle Play" class="actions_div" data-actions="shuffle_play_uri" data-uri="' . $uri . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div shuffle_play_uri_24_img_div"></div></div>
				<div title="Browse" class="actions_div" data-actions="browse_playlist" data-uri="' . $uri . '" data-description="" data-isauthorizedwithspotify="' . boolean_to_string(is_authorized_with_spotify) . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div playlist_24_img_div"></div></div>
				<div title="Share" class="actions_div" data-actions="share_uri" data-title="' . hsc($name) . '" data-uri="' . rawurlencode(uri_to_url($uri)) . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div share_24_img_div"></div></div>
				<div title="More" class="show_actions_dialog_div actions_div" data-actions="show_actions_dialog" data-dialogactions="' . base64_encode(json_encode($actions_dialog)) . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div overflow_24_img_div"></div></div>
				</div>
				</div>
				</div>
			';
		}

		echo '</div></div>';
	}
}
elseif(isset($_GET['edit']))
{
	$uri = str_replace('%3A', ':', rawurlencode($_GET['uri']));
	$playlist = get_playlist($uri);

	$activity['title'] = 'Edit Playlist';

	if(empty($playlist))
	{
		$activity['actions'][] = array('action' => array('Retry', 'reload_32_img_div'), 'keys' => array('actions'), 'values' => array('reload_activity'));

		echo '
			<div id="activity_inner_div" data-activitydata="' . base64_encode(json_encode($activity)) . '">

			<div id="activity_message_div"><div><div class="img_div img_64_div information_64_img_div"></div></div><div>Could not get playlist. Try again.</div></div>

			</div>
		';
	}
	else
	{
		$name = $playlist['name'];
		$is_public = ($playlist['public'] == 'Yes') ? ' checked="checked"' : '';

		$activity['actions'][] = array('action' => array('Edit', 'yes_32_img_div'), 'keys' => array('actions', 'form'), 'values' => array('submit_form', 'form#edit_playlist_form'));

		echo '
			<div id="activity_inner_div" data-activitydata="' . base64_encode(json_encode($activity)) . '">

			<div id="activity_form_div">
			<form method="post" action="." id="edit_playlist_form" autocomplete="off" autocapitalize="off">
			<div class="input_text_div"><div><div class="img_div img_24_div edit_24_img_div"></div></div><div><input type="text" class="focused_text_input" id="edit_playlist_name_input" value="' . hsc($name) . '" data-hint="Name..."></div></div>
			<div class="input_checkbox_div"><div><input type="checkbox" id="edit_playlist_make_public_input"' . $is_public . '></div><div><label for="edit_playlist_make_public_input">Make public</label></div></div>
			<div class="invisible_div"><input type="hidden" id="edit_playlist_uri_input" value="' . $uri . '"><input type="submit" value="Edit"></div>
			</form>
			</div>

			</div>
		';
	}
}
elseif(isset($_GET['browse']))
{
	$playlist_uri = str_replace('%3A', ':', rawurlencode($_GET['uri']));
	$metadata = get_playlist($playlist_uri);

	if(empty($metadata))
	{
		$activity['title'] = 'Error';
		$activity['actions'][] = array('action' => array('Retry', 'reload_32_img_div'), 'keys' => array('actions'), 'values' => array('reload_activity'));

		echo '
			<div id="activity_inner_div" data-activitydata="' . base64_encode(json_encode($activity)) . '">

			<div id="activity_message_div"><div><div class="img_div img_64_div information_64_img_div"></div></div><div>Could not get playlist. Try again.</div></div>

			</div>
		';
	}
	else
	{
		$name = $metadata['name'];
		$description = (empty($_COOKIE['playlist_description'])) ? '' : json_decode($_COOKIE['playlist_description'], true);
		$description = (empty($description[$playlist_uri])) ? '' : base64_decode($description[$playlist_uri]);
		$user = is_facebook_user($metadata['user']);
		$public = $metadata['public'];
		$snapshot_id = $metadata['snapshot_id'];
		$tracks = (empty($metadata['tracks'])) ? null : $metadata['tracks'];
		$tracks_count = $metadata['tracks_count'];
		$total_length = $metadata['total_length'];
		$cover_art_uri = $metadata['cover_art_uri'];

		$activity['title'] = hsc($name);

		if(empty($tracks))
		{
			$activity['actions'][] = array('action' => array('Retry', 'reload_32_img_div'), 'keys' => array('actions'), 'values' => array('reload_activity'));

			echo '
				<div id="activity_inner_div" data-activitydata="' . base64_encode(json_encode($activity)) . '">

				<div id="activity_message_div"><div><div class="img_div img_64_div information_64_img_div"></div></div><div>Empty playlist</div></div>

				</div>
			';
		}
		else
		{
			$is_starred = (get_uri_type($playlist_uri) == 'starred');
			$is_saved = playlist_is_saved(null, $playlist_uri);

			if(empty($cover_art_uri))
			{
				$cover_art_uri = ($is_starred) ? $tracks[0]['uri'] : $playlist_uri;

				$cover_art = cover_art_exists($cover_art_uri);
				$cover_art_uri = (!$cover_art) ? $cover_art_uri : '';
				$cover_art_style = (!$cover_art) ? '' : 'background-image: url(\'' . $cover_art . '\')';
			}
			else
			{
				$cover_art_style = 'background-image: url(\'' . $cover_art_uri . '\')';
				$cover_art_uri = '';
			}

			$details_dialog = array();
			$details_dialog['title'] = hsc($name);
			$details_dialog['details'][] = array('detail' => 'Total Length', 'value' => $total_length);
			$details_dialog['details'][] = array('detail' => 'Public', 'value' => $public);

			$activity['cover_art_uri'] = $cover_art_uri;
			$activity['actions'][] = array('action' => array('Refresh', ''), 'keys' => array('actions', 'uri'), 'values' => array('refresh_playlist', $playlist_uri));
			$activity['actions'][] = array('action' => array('Details', ''), 'keys' => array('actions', 'dialogdetails'), 'values' => array('show_details_dialog', base64_encode(json_encode($details_dialog))));

			if($is_saved && !$is_starred) $activity['actions'][] = array('action' => array('Edit', ''), 'keys' => array('actions', 'uri', 'isauthorizedwithspotify'), 'values' => array('show_edit_playlist_activity', $playlist_uri, is_authorized_with_spotify));

			$activity['actions'][] = array('action' => array('Share', ''), 'keys' => array('actions', 'title', 'uri'), 'values' => array('share_uri', hsc($name), rawurlencode(uri_to_url($playlist_uri))));
			$activity['actions'][] = array('action' => array('Queue Tracks', ''), 'keys' => array('actions', 'uris', 'randomly'), 'values' => array('queue_uris', $playlist_uri, 'false'));
			$activity['actions'][] = array('action' => array('Queue Tracks Randomly', ''), 'keys' => array('actions', 'uris', 'randomly'), 'values' => array('queue_uris', $playlist_uri, 'true'));

			$tracks_count = ($tracks_count == 1) ? '<span id="playlist_tracks_count_span">' . $tracks_count . '</span> track' : '<span id="playlist_tracks_count_span">' . $tracks_count . '</span> tracks';

			echo '
				<div id="cover_art_div">
				<div id="cover_art_art_div" class="actions_div" data-actions="resize_cover_art" data-resized="false" data-width="640" data-height="640" style="' . $cover_art_style . '" onclick="void(0)"></div>
				<div id="cover_art_actions_div"><div title="Play" class="actions_div" data-actions="play_uri" data-uri="' . $playlist_uri . '" data-highlightclass="green_opacity_highlight"><div class="img_div img_32_div cover_art_play_32_img_div"></div></div><div title="Shuffle Play" class="actions_div" data-actions="shuffle_play_uri" data-uri="' . $playlist_uri . '" data-highlightclass="green_opacity_highlight"><div class="img_div img_32_div cover_art_shuffle_play_32_img_div"></div></div></div>
				<div id="cover_art_information_div"><div><div>Playlist by ' . hsc($user) . '</div></div><div><div>' . $tracks_count . '</div></div></div>
				</div>

				<div id="activity_inner_div" data-activitydata="' . base64_encode(json_encode($activity)) . '">
			';


			if(!$is_starred && !$is_saved) echo '<div class="green_button_div green_button_below_cover_art_div actions_div" data-actions="import_playlist" data-uri="' . $playlist_uri . '" data-highlightclass="light_green_highlight" onclick="void(0)">Add to My Playlists</div>';

			if(!empty($description)) echo '<div id="playlist_description_div">' . hsc($description) . '</div>';

			$actions_dialog = array();
			$actions_dialog['title'] = 'Sort By';
			$actions_dialog['actions'][] = array('text' => 'Track Order', 'keys' => array('actions', 'cookieid', 'cookievalue', 'cookieexpires'), 'values' => array('hide_dialog set_cookie refresh_activity', 'settings_sort_playlist_tracks', 'default', 3650));
			$actions_dialog['actions'][] = array('text' => 'Added', 'keys' => array('actions', 'cookieid', 'cookievalue', 'cookieexpires'), 'values' => array('hide_dialog set_cookie refresh_activity', 'settings_sort_playlist_tracks', 'added', 3650));
			$actions_dialog['actions'][] = array('text' => 'Added By', 'keys' => array('actions', 'cookieid', 'cookievalue', 'cookieexpires'), 'values' => array('hide_dialog set_cookie refresh_activity', 'settings_sort_playlist_tracks', 'added_by', 3650));
			$actions_dialog['actions'][] = array('text' => 'Artist', 'keys' => array('actions', 'cookieid', 'cookievalue', 'cookieexpires'), 'values' => array('hide_dialog set_cookie refresh_activity', 'settings_sort_playlist_tracks', 'artist', 3650));
			$actions_dialog['actions'][] = array('text' => 'Title', 'keys' => array('actions', 'cookieid', 'cookievalue', 'cookieexpires'), 'values' => array('hide_dialog set_cookie refresh_activity', 'settings_sort_playlist_tracks', 'title', 3650));

			echo '
				<div class="list_header_div"><div><div>ALL</div></div><div title="Sort" class="actions_div" data-actions="show_actions_dialog" data-dialogactions="' . base64_encode(json_encode($actions_dialog)) . '" data-highlightclass="light_grey_highlight" onclick="void(0)"><div class="img_div img_24_div ' . is_sorted('settings_sort_playlist_tracks') . '_24_img_div"></div></div></div>

				<div class="list_div">
			';

			$sort = $_COOKIE['settings_sort_playlist_tracks'];

			if($sort != 'default')
			{
				function tracks_cmp($a, $b)
				{
					global $sort;

					if($sort == 'added')
					{
						return strcasecmp($b['added'], $a['added']);
					}
					elseif($sort == 'added_by')
					{
						return strcasecmp($a['added_by'], $b['added_by']);
					}
					elseif($sort == 'artist')
					{
						return strcasecmp($a['artist'], $b['artist']);
					}
					elseif($sort == 'title')
					{
						return strcasecmp($a['title'], $b['title']);
					}
				}

				usort($tracks, 'tracks_cmp');
			}

			$hide_local_files = (string_to_boolean($_COOKIE['settings_hide_local_files']));
			$i = 0;

			foreach($tracks as $track)
			{
				$i++;

				$artist = $track['artist'];
				$title = $track['title'];
				$album = $track['album'];
				$length = $track['length'];
				$uri = $track['uri'];
				$position = $track['position'];
				$added = $track['added'];
				$added_by = $track['added_by'];

				if($hide_local_files && get_uri_type($uri) == 'local') continue;

				$list_item_div = 'list_item_' . $i . '_div';

				$details_dialog = array();
				$details_dialog['title'] = hsc($title);
				$details_dialog['details'][] = array('detail' => 'Album', 'value' => $album);
				$details_dialog['details'][] = array('detail' => 'Length', 'value' => $length);
				$details_dialog['details'][] = array('detail' => 'Added', 'value' => substr($added, 0, 10));
				$details_dialog['details'][] = array('detail' => 'Added By', 'value' => $added_by);

				$actions_dialog = array();
				$actions_dialog['title'] = hsc($title);
				$actions_dialog['actions'][] = array('text' => 'Add to Playlist', 'keys' => array('actions', 'title', 'uri', 'isauthorizedwithspotify'), 'values' => array('hide_dialog add_to_playlist', $title, $uri, is_authorized_with_spotify));
				$actions_dialog['actions'][] = array('text' => 'Go to Album', 'keys' => array('actions', 'uri'), 'values' => array('hide_dialog browse_album', $uri));
				$actions_dialog['actions'][] = array('text' => 'Search Artist', 'keys' => array('actions', 'string'), 'values' => array('hide_dialog get_search', rawurlencode('artist:"' . $artist . '"')));
				$actions_dialog['actions'][] = array('text' => 'Start Track Radio', 'keys' => array('actions', 'uri', 'playfirst'), 'values' => array('hide_dialog start_track_radio', $uri, 'true'));
				$actions_dialog['actions'][] = array('text' => 'Lyrics', 'keys' => array('actions', 'activity', 'subactivity', 'args'), 'values' => array('hide_dialog change_activity', 'lyrics', '', 'artist=' . rawurlencode($artist) . '&amp;title=' . rawurlencode($title)));
				$actions_dialog['actions'][] = array('text' => 'Details', 'keys' => array('actions', 'dialogdetails'), 'values' => array('hide_dialog show_details_dialog', base64_encode(json_encode($details_dialog))));
				$actions_dialog['actions'][] = array('text' => 'Share', 'keys' => array('actions', 'title', 'uri'), 'values' => array('hide_dialog share_uri', hsc($title), rawurlencode(uri_to_url($uri))));
				$actions_dialog['actions'][] = array('text' => 'Delete from Playlist', 'keys' => array('actions', 'uri', 'uris', 'positions', 'snapshot_id', 'div'), 'values' => array('hide_dialog delete_uris_from_playlist', $playlist_uri, $uri, $position, $snapshot_id, $list_item_div));

				echo '
					<div id="' . $list_item_div . '" class="list_item_div">
					<div title="' . hsc($artist . ' - ' . $title) . '" class="list_item_main_div actions_div" data-actions="toggle_list_item_actions" data-trackuri="' . $uri . '" data-highlightotherelement="div.list_item_main_corner_arrow_div" data-highlightotherelementparent="div.list_item_div" data-highlightotherelementclass="corner_arrow_dark_grey_highlight" onclick="void(0)">
					<div class="list_item_main_actions_arrow_div"></div>
					<div class="list_item_main_corner_arrow_div"></div>
					<div class="list_item_main_inner_div">
					<div class="list_item_main_inner_icon_div"><div class="img_div img_24_div ' . track_is_playing($uri, 'icon') . '"></div></div>
					<div class="list_item_main_inner_text_div"><div class="list_item_main_inner_text_upper_div ' . track_is_playing($uri, 'text') . '">' . hsc($title) . '</div><div class="list_item_main_inner_text_lower_div">' . hsc($artist) . '</div></div>
					</div>
					</div>
					<div class="list_item_actions_div">
					<div class="list_item_actions_inner_div">
					<div title="Play" class="actions_div" data-actions="play_uri" data-uri="' . $uri . '" data-highlightclass="dark_grey_highlight" data-highlightotherelement="div.list_item_main_actions_arrow_div" data-highlightotherelementparent="div.list_item_div" data-highlightotherelementclass="up_arrow_dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div play_24_img_div"></div></div>
					<div title="Queue" class="actions_div" data-actions="queue_uri" data-artist="' . rawurlencode($artist) . '" data-title="' . rawurlencode($title) . '" data-uri="' . $uri . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div queue_24_img_div"></div></div>
					<div title="Save to/Remove from Library" class="actions_div" data-actions="save" data-artist="' . rawurlencode($artist) . '" data-title="' . rawurlencode($title) . '" data-uri="' . $uri . '" data-isauthorizedwithspotify="' . boolean_to_string(is_authorized_with_spotify) . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div ' . is_saved($uri) . '_24_img_div"></div></div>
					<div title="Go to Artist" class="actions_div" data-actions="browse_artist" data-uri="' . $uri . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div artist_24_img_div"></div></div>
					<div title="More" class="show_actions_dialog_div actions_div" data-actions="show_actions_dialog" data-dialogactions="' . base64_encode(json_encode($actions_dialog)) . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div overflow_24_img_div"></div></div>
					</div>
					</div>
					</div>
				';
			}
		}

		echo '</div></div>';
	}
}
else
{
	$activity['is_authorized_with_spotify'] = is_authorized_with_spotify;
	$activity['title'] = 'Playlists';

	if(!is_authorized_with_spotify)
	{
		$activity['actions'][] = array('action' => array('Authorize with Spotify', 'key_32_img_div'), 'keys' => array('actions'), 'values' => array('confirm_authorize_with_spotify'));

		echo '
			<div id="activity_inner_div" data-activitydata="' . base64_encode(json_encode($activity)) . '">

			<div id="activity_message_div"><div><div class="img_div img_64_div information_64_img_div"></div></div><div>You must authorize with Spotify. Tap the top right icon to continue.</div></div>

			</div>
		';
	}
	else
	{
		$activity['actions'][] = array('action' => array('Add Playlists', 'new_32_img_div'), 'keys' => array('actions', 'activity', 'subactivity', 'args'), 'values' => array('change_activity', 'playlists', 'add', ''));

		echo '<div id="activity_inner_div" data-activitydata="' . base64_encode(json_encode($activity)) . '">';

		$username = get_spotify_username();

		if(!empty($username))
		{
			$uri = 'spotify:user:' . $username . ':starred';

			$actions_dialog = array();
			$actions_dialog['title'] = 'Starred';
			$actions_dialog['actions'][] = array('text' => 'Queue Tracks', 'keys' => array('actions', 'uris', 'randomly'), 'values' => array('hide_dialog queue_uris', $uri, 'false'));
			$actions_dialog['actions'][] = array('text' => 'Queue Tracks Randomly', 'keys' => array('actions', 'uris', 'randomly'), 'values' => array('hide_dialog queue_uris', $uri, 'true'));

			echo '
				<div class="list_header_div"><div><div>STARRED</div></div><div></div></div>

				<div class="list_div">

				<div class="list_item_div">
				<div title="Starred" class="list_item_main_div actions_div" data-actions="toggle_list_item_actions" data-highlightotherelement="div.list_item_main_corner_arrow_div" data-highlightotherelementparent="div.list_item_div" data-highlightotherelementclass="corner_arrow_dark_grey_highlight" onclick="void(0)">
				<div class="list_item_main_actions_arrow_div"></div>
				<div class="list_item_main_corner_arrow_div"></div>
				<div class="list_item_main_inner_div">
				<div class="list_item_main_inner_icon_div"><div class="img_div img_24_div star_24_img_div"></div></div>
				<div class="list_item_main_inner_text_div"><div class="list_item_main_inner_text_upper_div">Starred</div><div class="list_item_main_inner_text_lower_div">' . $username . '</div></div>
				</div>
				</div>
				<div class="list_item_actions_div">
				<div class="list_item_actions_inner_div">
				<div title="Play" class="actions_div" data-actions="play_uri" data-uri="' . $uri . '" data-highlightclass="dark_grey_highlight" data-highlightotherelement="div.list_item_main_actions_arrow_div" data-highlightotherelementparent="div.list_item_div" data-highlightotherelementclass="up_arrow_dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div play_24_img_div"></div></div>
				<div title="Shuffle Play" class="actions_div" data-actions="shuffle_play_uri" data-uri="' . $uri . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div shuffle_play_uri_24_img_div"></div></div>
				<div title="Browse" class="actions_div" data-actions="browse_playlist" data-description="" data-uri="' . $uri . '" data-isauthorizedwithspotify="' . boolean_to_string(is_authorized_with_spotify) . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div playlist_24_img_div"></div></div>
				<div title="Share" class="actions_div" data-actions="share_uri" data-title="Starred" data-uri="' . rawurlencode(uri_to_url($uri)) . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div share_24_img_div"></div></div>
				<div title="More" class="show_actions_dialog_div actions_div" data-actions="show_actions_dialog" data-dialogactions="' . base64_encode(json_encode($actions_dialog)) . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div overflow_24_img_div"></div></div>
				</div>
				</div>
				</div>

				</div>
			';
		}

		$actions_dialog = array();
		$actions_dialog['title'] = 'Sort By';
		$actions_dialog['actions'][] = array('text' => 'Name', 'keys' => array('actions', 'cookieid', 'cookievalue', 'cookieexpires'), 'values' => array('hide_dialog set_cookie refresh_activity', 'settings_sort_playlists', 'default', 3650));
		$actions_dialog['actions'][] = array('text' => 'User', 'keys' => array('actions', 'cookieid', 'cookievalue', 'cookieexpires'), 'values' => array('hide_dialog set_cookie refresh_activity', 'settings_sort_playlists', 'user', 3650));

		echo '
			<div class="list_header_div"><div><div>PLAYLISTS</div></div><div title="Sort" class="actions_div" data-actions="show_actions_dialog" data-dialogactions="' . base64_encode(json_encode($actions_dialog)) . '" data-highlightclass="light_grey_highlight" onclick="void(0)"><div class="img_div img_24_div ' . is_sorted('settings_sort_playlists') . '_24_img_div"></div></div></div>

			<div class="list_div">
		';

		$sort = $_COOKIE['settings_sort_playlists'];

		$order1 = 'name';
		$order2 = 'uri';

		if($sort == 'user')
		{
			$order1 = 'uri';
			$order2 = 'name';
		}

		$playlists = get_playlists($order1, $order2);

		if(empty($playlists))
		{
			echo '<div class="list_empty_div">No playlists.</div>';
		}
		else
		{
			foreach($playlists as $playlist)
			{
				$id = $playlist['id'];
				$name = $playlist['name'];
				$uri = $playlist['uri'];
				$user = is_facebook_user(rawurldecode(get_playlist_user($uri)));

				$name = ($name == 'Unknown') ? 'Unknown (ID: ' . $id . ')' : $name;

				$actions_dialog = array();
				$actions_dialog['title'] = hsc($name);
				$actions_dialog['actions'][] = array('text' => 'Queue Tracks', 'keys' => array('actions', 'uris', 'randomly'), 'values' => array('hide_dialog queue_uris', $uri, 'false'));
				$actions_dialog['actions'][] = array('text' => 'Queue Tracks Randomly', 'keys' => array('actions', 'uris', 'randomly'), 'values' => array('hide_dialog queue_uris', $uri, 'true'));
				$actions_dialog['actions'][] = array('text' => 'Edit', 'keys' => array('actions', 'uri', 'isauthorizedwithspotify'), 'values' => array('hide_dialog show_edit_playlist_activity', $uri, is_authorized_with_spotify));
				$actions_dialog['actions'][] = array('text' => 'Remove', 'keys' => array('actions', 'id'), 'values' => array('hide_dialog remove_playlist', $id));

				echo '
					<div class="list_item_div">
					<div title="' . hsc($name) . '" class="list_item_main_div actions_div" data-actions="toggle_list_item_actions" data-highlightotherelement="div.list_item_main_corner_arrow_div" data-highlightotherelementparent="div.list_item_div" data-highlightotherelementclass="corner_arrow_dark_grey_highlight" onclick="void(0)">
					<div class="list_item_main_actions_arrow_div"></div>
					<div class="list_item_main_corner_arrow_div"></div>
					<div class="list_item_main_inner_div">
					<div class="list_item_main_inner_icon_div"><div class="img_div img_24_div playlist_24_img_div"></div></div>
					<div class="list_item_main_inner_text_div"><div class="list_item_main_inner_text_upper_div">' . hsc($name) . '</div><div class="list_item_main_inner_text_lower_div">' . hsc($user) . '</div></div>
					</div>
					</div>
					<div class="list_item_actions_div">
					<div class="list_item_actions_inner_div">
					<div title="Play" class="actions_div" data-actions="play_uri" data-uri="' . $uri . '" data-highlightclass="dark_grey_highlight" data-highlightotherelement="div.list_item_main_actions_arrow_div" data-highlightotherelementparent="div.list_item_div" data-highlightotherelementclass="up_arrow_dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div play_24_img_div"></div></div>
					<div title="Shuffle Play" class="actions_div" data-actions="shuffle_play_uri" data-uri="' . $uri . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div shuffle_play_uri_24_img_div"></div></div>
					<div title="Browse" class="actions_div" data-actions="browse_playlist" data-description="" data-uri="' . $uri . '" data-isauthorizedwithspotify="' . boolean_to_string(is_authorized_with_spotify) . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div playlist_24_img_div"></div></div>
					<div title="Share" class="actions_div" data-actions="share_uri" data-title="' . hsc($name) . '" data-uri="' . rawurlencode(uri_to_url($uri)) . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div share_24_img_div"></div></div>
					<div title="More" class="show_actions_dialog_div actions_div" data-actions="show_actions_dialog" data-dialogactions="' . base64_encode(json_encode($actions_dialog)) . '" data-highlightclass="dark_grey_highlight" onclick="void(0)"><div class="img_div img_24_div overflow_24_img_div"></div></div>
					</div>
					</div>
					</div>
				';
			}
		}

		echo '</div></div>';
	}
}

?>