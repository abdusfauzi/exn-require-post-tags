<?php
/*
Plugin Name: EXN Require Post Tags
Plugin URI: https://github.com/abdusfauzi/exn-require-post-tags
Description: Require users to add at least one post tag before saving a draft or publishing.
Version: 1.2
Author: Abdus Fauzi, Josh Hartman
Author URI: https://github.com/abdusfauzi/exn-require-post-tags
License: GPL2
*/
/*
	Copyright 2013 Josh Hartman

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action( 'admin_footer-post.php', 'rpt_admin_footer_post_func' );
add_action( 'admin_footer-post-new.php', 'rpt_admin_footer_post_func' );

function rpt_admin_footer_post_func() {
	global $post_type;
	if ( 'post' === $post_type ) {
		echo '<script>
			var messageNoTags = "<div id=\"message\" class=\"error error-missing-tags\"><h2><span class=\"dashicons dashicons-warning\"></span> Sila isikan <strong>Kata Nama</strong> dalam ruangan Tags</h2><p>Contoh: Nike, Najib, Samsung, Malaysia.</p><p>Untuk advertorial, sila isi tag <strong>advertorial</strong>.<br>Untuk video, sila isi tag <strong>video</strong>.<br>Untuk /tv (VOCKET original video), sila isi <strong>tv</strong> dan <strong>video</strong>.</p></div>";

			jQuery(function($){
				if($("#post_tag .tagchecklist span").length==0){
					$("input#publish").removeClass("button-primary").prop("disabled",true);
					$("#wpbody-content form#post").before(messageNoTags);
				}

				$("#post_tag .tagchecklist").bind("DOMNodeInserted", function() {
					$("input#publish").addClass("button-primary").prop("disabled",false);
					$("#message").remove();
				});

				$(".tagchecklist").bind("click", ".ntdelbutton", function(e){
					if($("#post_tag .tagchecklist span").length==0){
						$("input#publish").removeClass("button-primary").prop("disabled",true);
						
						alert(`Sila isikan "Kata Nama" dalam ruangan Tags.\n\nContoh: Nike, Najib, Samsung, Malaysia.\n\nUntuk advertorial, sila isi tag "advertorial".\nUntuk video, sila isi tag "video".\nUntuk /tv (original video), sila isi "tv" dan "video".`);

						$("#wpbody-content form#post").before(messageNoTags);
					}
				});

				$("#publish, #save-post").click(function(e){
					if($("#post_tag .tagchecklist span").length==0){
						$("#message").remove();

						alert(`Sila isikan "Kata Nama" dalam ruangan Tags.\n\nContoh: Nike, Najib, Samsung, Malaysia.\n\nUntuk advertorial, sila isi tag "advertorial".\nUntuk video, sila isi tag "video".\nUntuk /tv (original video), sila isi "tv" dan "video".`);

						$("#wpbody-content form#post").before(messageNoTags);

						e.stopImmediatePropagation();
						return false;
					}else{
						return true;
					}
				});
				var publish_click_events = $("#publish").data("events").click;
				if(publish_click_events){
					if(publish_click_events.length>1){
						publish_click_events.unshift(publish_click_events.pop());
					}
				}
				if($("#save-post").data("events") != null){
					var save_click_events = $("#save-post").data("events").click;
					if(save_click_events){
						if(save_click_events.length>1){
							save_click_events.unshift(save_click_events.pop());
						}
					}
				}
			});
			</script>';
	}
}
