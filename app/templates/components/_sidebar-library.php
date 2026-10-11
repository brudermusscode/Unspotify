<form data-form="library:reorder" update-library>
  <input type=hidden name="reorder" value="1" />

  <library view=list>

    <!--- bib heading --->
    <library-header fl alic jucsb scroll-manipulated>
      <p window-light pinline14 pblock8 text smol ttup semibold>Bibliothek</p>

      <div fl alic gap=smol>
        <div fl alic gap=smol>
          <mbutton data-action="library:reorder" no-hover-shadow material normal smol icon-only has-tooltip=bottom>
            <mi>format_line_spacing</mi>
            <div ttooltip>Zeit für 1 neue Ordnung</div>
          </mbutton>
          <mbutton submit-closest reorder-library no-hover-shadow material smol icon-only has-tooltip=bottom>
            <mi>done_all</mi>
            <div ttooltip>Gut so</div>
          </mbutton>
        </div>

        <dot-divider></dot-divider>

        <library-view fl alic jucend gap=smoler>
          <mbutton active material no-hover-shadow smol icon-only view=list>
            <mi stdplus>view_day</mi>
          </mbutton>
          <mbutton disabled material no-hover-shadow smol icon-only view=grid>
            <mi stdplus>grid_view</mi>
          </mbutton>
        </library-view>
      </div>
    </library-header>

    <!--- actual bib with bookmarks --->
    <bookmarks>
      <get-content from="/get/library">
        <?php include TEMPLATE . "/global/_loader.php"; ?>
      </get-content>
    </bookmarks>
  </library>
</form>