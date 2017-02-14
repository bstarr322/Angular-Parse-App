<form action="<?php  echo home_url(); ?>/" method="get">
    <fieldset>
        <input type="text" name="s" id="s" data-placeholder="<?php echo __('Search...', TEMPNAME); ?>" value="<?php echo __('Search...', TEMPNAME); ?>" />
        <span class="icon-close"></span>
        <input type="submit" id="searchsubmit" value="<?php echo __('Search', TEMPNAME); ?>" />
        <span class="icon-search2"></span>
    </fieldset>
</form>