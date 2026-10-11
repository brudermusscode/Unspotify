<?php

require_once _root() . "/config/get_requirements.php";

use Bruder\Http\Request;
use Bruder\Model\Album;
use Bruder\Model\Artist;
use Bruder\Model\Playlist;
use Bruder\Model\Track;

/**
 * @var Request $Request
 */

/**
 * @var mixed
 */
$input = filter_input(INPUT_GET, "q", FILTER_SANITIZE_SPECIAL_CHARS);

/**
 * Input is empty?
 */
if (strlen($input) < 1)
  die($Request->error("<strong>Nichts eingegeben Bruder.</strong> Warum machst du so?"));

/**
 * @var Track
 */
$Tracks = Track::where(function ($q) use ($input) {
  $q->where("title", "LIKE", "%$input%")
    ->orWhere("artist", "LIKE", "%$input%")
    ->orWhere("genre", "LIKE", "%$input%")
    ->orWhere("file_name", "LIKE", "%$input%");
})
  ->whereNull("deleted_at")
  ->orderBy("created_at", "DESC")
  ->get();

$Albums = Album::where("name", "LIKE", "%$input%")
  ->whereNull("deleted_at")
  ->orderBy("created_at", "DESC")
  ->get();

$Playlists = Playlist::where("name", "LIKE", "%$input%")
  ->whereNull("deleted_at")
  ->orderBy("created_at", "DESC")
  ->get();

$Artists = Artist::where("name", "LIKE", "%$input%")
  ->whereNull("deleted_at")
  ->orderBy("created_at", "DESC")
  ->get();

# Bind together all search results ordering by the creation date.
$Results = collect()
  ->merge($Artists->sortByDesc("created_at"))
  ->merge($Tracks->sortByDesc("listens"))
  ->merge($Albums->sortByDesc("created_at"))
  ->merge($Playlists->sortByDesc("created_at"));

ob_start(); ?>

<?php if ($Tracks->count()) : ?>
  <overflow-container tracks flone>
    <div fl jucstart z mb12 style="position:sticky;top:0px;">
      <p window-light background=primary color=primary-text rounded=mid pinline14 pblock8 text smol ttup semibold>Songs</p>
    </div>
    <div tracks play-only>
      <?php foreach ($Tracks as $Track) :
        include TEMPLATE . "/track/_track-preview.php";
      endforeach; ?>
    </div>
  </overflow-container>
<?php endif; ?>

<?php if ($Artists->count()) : ?>
  <overflow-container artists flone posrel>
    <div fl jucstart z mb12 style="position:sticky;top:0px;">
      <p window-light background=secondary color=secondary-text rounded=mid pinline14 pblock8 text smol ttup semibold>Künstler</p>
    </div>
    <?php foreach ($Artists as $Artist) :
      include TEMPLATE . "/artist/_artist-preview.php";
    endforeach; ?>
  </overflow-container>
<?php endif; ?>

<?php if ($Albums->count()) : ?>
  <overflow-container releases flone posrel pinline8>
    <div fl jucstart z mb12 style="position:sticky;top:0px;">
      <p window-light background=tertiary color=tertiary-text rounded=mid pinline14 pblock8 text smol ttup semibold>Releases</p>
    </div>
    <div fl fldircol gap=smol>
      <?php foreach ($Albums as $Album) :
        $full_width = true;
        include TEMPLATE . "/album/_album.php";
      endforeach; ?>
    </div>
  </overflow-container>
<?php endif; ?>

<?php

die($Request->success("Deine Tracks Bruder ;)", data: ob_get_clean()));
