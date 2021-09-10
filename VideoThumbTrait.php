<?php

trait VideoThumbTrait
{
    public function get_video_thumbnail($src)
    {
        $thumbnail = "https://via.placeholder.com/400?text=Loading+upgrade+video+thumbnail";
        $url_pieces = explode('/', $src);

        if ( isset($url_pieces[2] ) && $url_pieces[2] == 'player.vimeo.com' ) { // If Vimeo

            $id = $url_pieces[4];
            $hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . $id . '.php'));
            $thumbnail = $hash[0]['thumbnail_large'];

        }  elseif ( isset($url_pieces[2]) && $url_pieces[2] == 'vimeo.com'  ) { // If Vimeo

            $extract_id = explode('?', $url_pieces[5]);
            $id = $extract_id[0];
            $hash = json_decode(file_get_contents('https://vimeo.com/api/oembed.json?url=https%3A//vimeo.com/' . $id ), true);
            $thumbnail = $hash['thumbnail_url'];

        } elseif ( isset($url_pieces[2]) && $url_pieces[2] == 'www.youtube.com' && $url_pieces[3] == 'embed' ) { // If Youtube

            $thumbnail = 'http://img.youtube.com/vi/' . $url_pieces[4] . '/mqdefault.jpg';

        } elseif ( isset($url_pieces[2] ) && $url_pieces[2] == 'www.youtube.com' ) { // If Youtube

            $extract_id = explode('?v=', $url_pieces[3]);
            $id = $extract_id[1];
            $thumbnail = 'http://img.youtube.com/vi/' . $id . '/mqdefault.jpg';

        } elseif ( isset($url_pieces[2] ) && $url_pieces[2] == 'youtu.be' ) {  // If Youtube

            $thumbnail = 'http://img.youtube.com/vi/' . $url_pieces[3] . '/mqdefault.jpg';
        }

        return $thumbnail;
    }
}
